<?php

namespace App\Services\External;

use App\Exceptions\EmailAlreadyVerifiedException;
use App\Exceptions\EmailNotVerifiedException;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmailVerificationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Kullanıcının e-postasının doğrulanıp doğrulanmadığını kontrol eder.
     */
    public function isVerified(Authenticatable $user): bool
    {
        return $user instanceof MustVerifyEmail && $user->hasVerifiedEmail();
    }

    /**
     * E-posta doğrulamasını gerçekleştirir.
     */
    public function verify(string $id, string $hash): void
    {
        $user = User::findOrFail($id);

        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            throw new EmailNotVerifiedException;
        }

        if ($user->hasVerifiedEmail()) {
            throw new EmailAlreadyVerifiedException;
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    }

    /**
     * E-posta doğrulama maili gönderir.
     */
    public function sendVerification(Authenticatable $user): void
    {
        if ($this->isVerified($user)) {
            throw new EmailAlreadyVerifiedException;
        }
        $user->sendEmailVerificationNotification();
    }
}
