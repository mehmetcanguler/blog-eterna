<?php

namespace App\Listeners;

use App\Contracts\External\SmsServiceInterface;
use App\Events\SmsVerificationRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsVerificationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected SmsServiceInterface $smsService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SmsVerificationRequested $event): void
    {
        $verificationCode = $event->verificationCode;

        $this->smsService->sendTo(
            $event->verificationCode->user->phone,
            trans('app.your_code_to_verify', ['code' => $verificationCode->code])
        );
    }
}
