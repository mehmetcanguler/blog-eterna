<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class InvalidVerificationCodeException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::InvalidVerificationCode->message(), 400);
    }
}
