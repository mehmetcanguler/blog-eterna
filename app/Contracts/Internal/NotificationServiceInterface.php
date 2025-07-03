<?php

namespace App\Contracts\Internal;

use App\Models\Notification;

interface NotificationServiceInterface extends ServiceInterface
{
    public function read(Notification $notification): bool;
}
