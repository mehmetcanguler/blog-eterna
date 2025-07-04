<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Middleware\EnsureContactIsVerified;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verificationVerify'])->middleware(['signed'])->name('verification.verify');

Route::prefix('v1')->middleware(['throttle:api', 'api'])->group(function () {

    Route::prefix('auth')->group(base_path('routes/api/v1/auth.php'));

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('verification')->group(base_path('routes/api/v1/verification.php'));

        Route::middleware([EnsureContactIsVerified::class])->group(function () {
            Route::prefix('posts')->group(base_path('routes/api/v1/posts.php'));
            Route::prefix('comments')->group(base_path('routes/api/v1/comments.php'));
            Route::prefix('categories')->group(base_path('routes/api/v1/categories.php'));
            Route::prefix('notifications')->group(base_path('routes/api/v1/notifications.php'));
        });
    });
});
