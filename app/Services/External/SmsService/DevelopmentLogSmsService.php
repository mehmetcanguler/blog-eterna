<?php

namespace App\Services\External\SmsService;

use App\Contracts\External\SmsServiceInterface;

class DevelopmentLogSmsService implements SmsServiceInterface
{
    public function sendTo(string $number, string $message, ?string $header = null): array
    {
        $data = [
            'number' => $number,
            'message' => $message,
            'success' => true,
        ];
        \Log::info('Gönderilen SMS', $data);

        return $data;
    }
}
