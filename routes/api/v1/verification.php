<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\VerificationController;

Route::post('verify-code', [VerificationController::class, 'verifyCode']);
Route::post('send', [VerificationController::class, 'send']);

