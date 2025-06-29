<?php

namespace App\Providers;

use App\Contracts\External\SmsServiceInterface;
use App\Contracts\Logging\Loggable;
use App\Services\External\SmsService\DevelopmentLogSmsService;
use App\Services\External\SmsService\NetgsmSmsService;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
