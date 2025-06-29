<?php

namespace App\Contracts\External;

interface SmsServiceInterface
{
    /**
     * Tek kişiye SMS gönderimi
     *
     * @param string $number
     * @param string $message
     * @param string|null $header
     * @return array
     */
    public function sendTo(string $number, string $message, ?string $header = null): array;
}
