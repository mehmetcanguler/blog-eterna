<?php

namespace App\Exceptions;

use Exception;

/**
 * Handler içerisinde özel exceptionları yakalayabilmemiz için yazdığımız base exception sınıfı
 */
class BaseException extends Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
