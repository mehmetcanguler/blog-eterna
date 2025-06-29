<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class InvalidCredentialsException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::InvalidCredentials->message(), 401);
    }
}
