<?php

namespace App\Http\Controllers;

use App\Contracts\Internal\NotificationServiceInterface;
use App\Http\Requests\Notifications\ListNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Support\Helpers\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationServiceInterface $notificationService
    ) {
    }

    public function index(ListNotificationRequest $request)
    {
        return ApiResponse::collection(
            NotificationResource::collection(
                $this->notificationService->all($request->toDto())
            )
        );
    }

    public function read(Notification $notification)
    {
        $this->notificationService->read($notification);

        return ApiResponse::success();
    }
}
