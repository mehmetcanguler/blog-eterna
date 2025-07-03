<?php

namespace App\Services\Internal;

use App\Contracts\Internal\NotificationServiceInterface;
use App\Models\Notification;
use App\Dtos\BaseDTO;
use App\Dtos\Notifications\NotificationListDto;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @extends BaseService<Notification, BaseDTO, BaseDTO, NotificationListDto>
 */
class NotificationService extends BaseService implements NotificationServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }
    /**
     * @param  NotificationListDto  $data
     * @return LengthAwarePaginator<Notification>
     */
    public function all(BaseDTO $data): LengthAwarePaginator
    {
        $query = $this->model->query();

        $query->where('notifiable_id', Auth::id())
            ->where('notifiable_type', User::class);
        if ($data->search) {
            $query->where('name', 'like', '%' . $data->search . '%');
        }

        return $query->paginate($data->per_page);
    }
    public function read(Notification $notification): bool
    {
        Auth::user()
            ->notifications()
            ->find($notification->id)
            ->markAsRead();
        return true;
    }

}
