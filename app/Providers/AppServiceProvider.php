<?php

namespace App\Providers;

use App\Contracts\External\SmsServiceInterface;
use App\Contracts\Logging\Loggable;
use App\Services\External\SmsService\DevelopmentLogSmsService;
use App\Services\External\SmsService\NetgsmSmsService;
use App\Services\Logging\ActivityLogger;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
