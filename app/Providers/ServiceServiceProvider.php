<?php

namespace App\Providers;

use App\Contracts\External\SmsServiceInterface;
use App\Contracts\Internal\CategoryServiceInterface;
use App\Contracts\Internal\CommentServiceInterface;
use App\Contracts\Internal\NotificationServiceInterface;
use App\Contracts\Internal\PostServiceInterface;
use App\Contracts\Logging\Loggable;
use App\Services\External\SmsService\DevelopmentLogSmsService;
use App\Services\External\SmsService\NetgsmSmsService;
use App\Services\Internal\CategoryService;
use App\Services\Internal\CommentService;
use App\Services\Internal\NotificationService;
use App\Services\Internal\PostService;
use App\Services\Logging\ActivityLogger;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (app()->environment('local')) {
            $this->app->bind(SmsServiceInterface::class, DevelopmentLogSmsService::class);
        }

        if (app()->environment('production')) {
            /**
             * Hesap bilgileri olursa eğer Netgsm sms servisi kullanılabilir.
             */
            $this->app->bind(SmsServiceInterface::class, NetgsmSmsService::class);
        }

        $this->app->bind(Loggable::class, ActivityLogger::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
