<?php

namespace App\Http\Requests\Notifications;

use App\Dtos\Notifications\NotificationListDto;
use App\Http\Requests\ListRequest;
use Illuminate\Foundation\Http\FormRequest;

class ListNotificationRequest extends ListRequest
{
    public function toDto(): NotificationListDto
    {
        return NotificationListDto::fromRequest($this->validated());
    }
}
