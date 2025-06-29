<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('notification.{userId}', function (User $user, string $userId): bool {
    return (string) $userId === (string) Auth::id();
}, ['guards' => ['sanctum']]);
