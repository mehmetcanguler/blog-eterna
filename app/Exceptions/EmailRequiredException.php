<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class EmailRequiredException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::EmailRequired->message(), 400);
    }
}
