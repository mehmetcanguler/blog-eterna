<?php

namespace App\Contracts\External;

interface SmsServiceInterface
{
    /**
     * Tek kişiye SMS gönderimi
     */
    public function sendTo(string $number, string $message, ?string $header = null): array;
}
