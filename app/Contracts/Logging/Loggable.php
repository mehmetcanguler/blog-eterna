<?php

namespace App\Contracts\Logging;

use App\Enums\ModelEvent;
use Illuminate\Database\Eloquent\Model;

interface Loggable
{
    public function log(Model $model, ModelEvent $event): void;
}
