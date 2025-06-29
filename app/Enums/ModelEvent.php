<?php

namespace App\Enums;

use App\Enums\Traits\BaseEnum;

enum ModelEvent: string
{
    use BaseEnum;
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
    case RESTORED = 'restored';
    case FORCE_DELETED = 'force_deleted';

    public function label(): string
    {
        return match ($this) {
            self::CREATED => trans('enums.created'),
            self::UPDATED => trans('enums.updated'),
            self::DELETED => trans('enums.deleted'),
            self::RESTORED => trans('enums.restored'),
            self::FORCE_DELETED => trans('enums.force_deleted'),
        };
    }
}
