<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class PhoneRequiredException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::PhoneRequired->message(), 400);
    }
}
