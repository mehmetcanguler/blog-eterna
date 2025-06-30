<?php

namespace App\Services\Internal;

use App\Contracts\Internal\PostServiceInterface;
use App\Dtos\BaseDTO;
use App\Dtos\Posts\PostDTO;
use App\Dtos\Posts\PostListDTO;
use App\Dtos\Posts\PostUpdateDTO;
use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use function Pest\Laravel\instance;

/**
 * @extends BaseService<Post, PostDTO, PostUpdateDTO, PostListDTO>
 */
class PostService extends BaseService implements PostServiceInterface
{
    public function __construct(Post $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @param  PostListDTO  $data
     * @return LengthAwarePaginator<Post>
     */
    public function all(BaseDTO $data): LengthAwarePaginator
    {
        $query = $this->model->query()->with('categories');

        if (!Auth::user()->can('publish', $this->model)) {
            $query->where(function ($query) {
                $query->where('status', PostStatus::PUBLISHED)
                    ->orWhere(function ($query) {
                        $query->where('author_id', Auth::id());
                    });
            });
        }
        if ($data->search) {
            $query->where('title', 'like', '%' . $data->search . '%')
                ->orWhere('content', 'like', '%' . $data->search . '%');
        }

        return $query->paginate($data->per_page);
    }

    /**
     * @param  PostDTO  $data
     */
    public function create(BaseDTO $data): Post
    {
        $model = $this->model::create([
            'title' => $data->title,
            'content' => $data->content,
            'author_id' => Auth::user()->id,
        ]);

        if (Auth::user()->can('publish', $model)) {
            $model->status = PostStatus::PUBLISHED;
            $model->published_at = now();
            $model->save();
        }
        $model->setCoverImage($data->coverImage);
        $model->setGalleryImages($data->galleryImages);
        $model->categories()->sync($data->categories);

        return $model;
    }

    /**
     * @param  Post  $model
     */
    public function show(Model $model): Post
    {
        $model = $this->model->with('categories')
            ->find($model->id);

        if (!Auth::user()->can('publish', $this->model)) {
            if ($model->status !== PostStatus::PUBLISHED && $model->author_id !== Auth::user()->id) {
                throw new AccessDeniedHttpException();
            }
        }

        return $model;

    }

    /**
     * @param  Post  $model
     * @param  PostUpdateDTO  $data
     */
    public function update(Model $model, BaseDTO $data): Post
    {
        $model->update([
            'title' => $data->title,
            'content' => $data->content,
        ]);

        if (!Auth::user()->can('publish', $model)) {
            $model->status = PostStatus::DRAFT;
            $model->save();
        }

        $model->categories()->sync($data->categories);

        return $model;
    }

    /**
     * @param  Post  $model
     */
    public function delete(Model|Post $model): bool
    {
        $model->categories()->detach();

        return $model->delete();
    }

    public function publish(Post $model): Post
    {
        $model->status = PostStatus::PUBLISHED;
        $model->published_at = now();
        $model->save();

        return $model;
    }
    public function unPublish(Post $model): Post
    {
        $model->status = PostStatus::DRAFT;
        $model->save();

        return $model;
    }
}
