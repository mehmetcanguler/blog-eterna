<?php

namespace App\Services\External\SmsService;

use App\Contracts\External\SmsServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NetgsmSmsService implements SmsServiceInterface
{
    protected string $username;
    protected string $password;
    protected string $url;
    protected string $defaultHeader;

    public function __construct()
    {
        $this->username = config('services.netgsm.username');
        $this->password = config('services.netgsm.password');
        $this->url = config('services.netgsm.url', 'https://api.netgsm.com.tr/sms/rest/v2/send');
        $this->defaultHeader = config('services.netgsm.header', 'BLOG');
    }

    /**
     * Çoklu SMS gönderme işlemi
     */
    public function send(string $header, array $messages, ?string $encoding = 'TR', ?string $iysfilter = '', ?string $partnercode = ''): array
    {
        $payload = [
            'msgheader' => $header,
            'messages' => $messages,
            'encoding' => $encoding,
            'iysfilter' => $iysfilter,
            'partnercode' => $partnercode,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withBasicAuth($this->username, $this->password)
                ->post($this->url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'number' => $messages[0]['no'],
                    'message' => $messages[0]['msg'],
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Tek kişiye SMS gönderme işlemi
     */
    public function sendTo(string $number, string $message, ?string $header = null): array
    {
        $header = $header ?? $this->defaultHeader;

        return $this->send($header, [
            [
                'msg' => $message,
                'no' => $number,
            ]
        ]);
    }
}
