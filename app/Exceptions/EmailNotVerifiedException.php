<?php

namespace App\Exceptions;

use App\Enums\ErrorMessages;

class EmailNotVerifiedException extends BaseException
{
    public function __construct()
    {
        parent::__construct(ErrorMessages::EmailNotVerified->message(), 403);
    }
}
