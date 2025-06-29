<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class PhoneAlreadyVerifiedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::PhoneAlreadyVerified->message(), 400);
    }
}
