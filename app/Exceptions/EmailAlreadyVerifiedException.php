<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class EmailAlreadyVerifiedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::EmailAlreadyVerified->message(), 400);
    }
}
