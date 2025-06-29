<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Middleware\EnsureContactIsVerified;
use App\Http\Middleware\VerifyAccountCheck;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verificationVerify'])->middleware(['signed'])->name('verification.verify');

Route::prefix('v1')->middleware(['throttle:60'])->group(function () {

    Route::prefix('auth')->group(base_path('routes/api/v1/auth.php'));

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('verification')->group(base_path('routes/api/v1/verification.php'));

        Route::middleware([EnsureContactIsVerified::class])->group(function () {
            Route::prefix('posts')->group(base_path('routes/api/v1/posts.php'));

        });
    });
});
