<?php

namespace App\Enums;

use App\Enums\Traits\BaseEnum;

enum RoleEnum: string
{
    use BaseEnum;

    case ADMIN = 'admin';
    case AUTHOR = 'author';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => trans('enums.admin'),
            self::AUTHOR => trans('enums.author'),
            self::USER => trans('enums.user'),
        };
    }
}
