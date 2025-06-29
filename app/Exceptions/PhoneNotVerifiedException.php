<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class PhoneNotVerifiedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::PhoneNotVerified->message(), 400);
    }
}
