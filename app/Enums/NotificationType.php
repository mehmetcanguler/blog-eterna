<?php

namespace App\Enums;

use App\Enums\Traits\BaseEnum;

enum NotificationType: string
{
    use BaseEnum;

    case COMMENT = 'comment';

    public function label(): string
    {
        return match ($this) {
            self::COMMENT => trans('enums.comment'),
        };
    }
}
