<?php

use App\Http\Controllers\NotificationController;

Route::get('/', [NotificationController::class, 'index']);
Route::put('{notification}/read', [NotificationController::class, 'read']);
