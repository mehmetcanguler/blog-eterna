<?php

namespace App\Enums;

use App\Enums\Traits\BaseEnum;

enum PostStatus: int
{
    use BaseEnum;

    case DRAFT = 1;
    case PUBLISHED = 2;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => trans('enums.draft'),
            self::PUBLISHED => trans('enums.published'),
        };
    }
}
