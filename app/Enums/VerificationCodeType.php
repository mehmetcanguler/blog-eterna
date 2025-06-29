<?php

namespace App\Enums;

use App\Enums\Traits\BaseEnum;

enum VerificationCodeType: int
{
    use BaseEnum;
    case EMAIL = 1;
    case PHONE = 2;

    public function label(): string
    {
        return match ($this) {
            self::EMAIL => trans('enums.email'),
            self::PHONE => trans('enums.phone'),
        };
    }
}
