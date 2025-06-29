<?php

namespace App\Services\Logging;

use App\Contracts\Logging\Loggable;
use App\Enums\ModelEvent;
use Auth;

class ActivityLogger implements Loggable
{
    public function log(\Illuminate\Database\Eloquent\Model $model, \App\Enums\ModelEvent $event): void
    {
        $withProperties = $model->toArray();

        activity()
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->withProperties($model->toArray())
            ->log($event->label());
    }
}
