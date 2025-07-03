<?php

namespace App\Services\External\Verifications;

use App\Enums\VerificationCodeType;
use App\Events\SmsVerificationRequested;
use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\PhoneAlreadyVerifiedException;
use App\Models\VerificationCode;
use App\Support\Helpers\RandomHelper;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SmsVerificationService
{
    public function isVerified(Authenticatable $user): bool
    {
        return (bool) $user->phone_verified_at;
    }

    public function verifyContact(Authenticatable $user, string $code)
    {
        $verificationCode = VerificationCode::where('user_id', $user->id)
            ->where('type', VerificationCodeType::PHONE)
            ->where('value', $user->phone)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->where('verified', false)
            ->first();

        if (! $verificationCode) {
            throw new InvalidVerificationCodeException;
        }

        $verificationCode->update(['verified' => true]);
        $user->phone_verified_at = now();
        $user->save();

        return true;
    }

    public function sendVerification(Authenticatable $user): void
    {
        if ($this->isVerified($user)) {
            throw new PhoneAlreadyVerifiedException;
        }

        $verificationCode = VerificationCode::create([
            'user_id' => $user->id,
            'type' => VerificationCodeType::PHONE,
            'value' => $user->phone,
            'code' => RandomHelper::randomVerifyCode(),
            'expires_at' => now()->addMinutes(10),
        ]);

        event(new SmsVerificationRequested($verificationCode));

    }
}
