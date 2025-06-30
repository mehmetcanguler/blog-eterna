<?php

namespace App\Services\Internal;

use App\Contracts\Internal\CommentServiceInterface;
use App\Dtos\BaseDTO;
use App\Dtos\Comments\CommentDTO;
use App\Dtos\Comments\CommentListDTO;
use App\Dtos\Comments\CommentUpdateDTO;
use App\Enums\CommentStatus;
use App\Enums\NotificationType;
use App\Models\Comment;
use App\Notifications\SendCommentNotification;
use App\ValueObject\NotificationData;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * @extends BaseService<Comment, CommentDTO, CommentUpdateDTO, CommentListDTO>
 */
class CommentService extends BaseService implements CommentServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    /**
     * @param  CommentListDTO  $data
     * @return LengthAwarePaginator<Comment>
     */
    public function all(BaseDTO $data): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!Auth::user()->can('publish', $this->model)) {
            $query->where(function ($query) {
                $query->where('status', CommentStatus::PUBLISHED)
                    ->orWhere(function ($query) {
                        $query->where('author_id', Auth::id());
                    });
            });
        }

        if ($data->search) {
            $query->where('name', 'like', '%' . $data->search . '%');
        }

        $query->where('post_id', $data->post_id);

        return $query->paginate($data->per_page);
    }

    /**
     * @param  Comment  $model
     */
    public function show(Model $model): Comment
    {
        $model = $this->model->with('categories')
            ->find($model->id);

        if (!Auth::user()->can('publish', $this->model)) {
            if ($model->status !== CommentStatus::PUBLISHED && $model->author_id !== Auth::user()->id) {
                throw new AccessDeniedHttpException();
            }
        }

        return $model;

    }


    /**
     * @param  CommentDTO  $data
     */
    public function create(BaseDTO $data): Comment
    {
        $model = $this->model::create($data->toArray());

        if (Auth::user()->can('publish', $model)) {
            $model->status = CommentStatus::PUBLISHED;
            $model->published_at = now();
            $model->save();
        }

        $model->post->author->notify(new SendCommentNotification(
            $model->post->author,
            new NotificationData(
                type: NotificationType::COMMENT,
                title: $model->post->title,
                description: $data->content,
                id: $model->id
            )
        ));

        return $model;
    }

    public function publish(Comment $model): Comment
    {
        $model->status = CommentStatus::PUBLISHED;
        $model->published_at = now();
        $model->save();

        return $model;
    }
    public function unPublish(Comment $model): Comment
    {
        $model->status = CommentStatus::DRAFT;
        $model->published_at = null;
        $model->save();

        return $model;
    }
}
