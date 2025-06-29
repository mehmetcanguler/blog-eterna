<?php

namespace App\Services\Logging;

use App\Contracts\Logging\Loggable;
use Auth;

class ActivityLogger implements Loggable
{
    public function log(\Illuminate\Database\Eloquent\Model $model, \App\Enums\ModelEvent $event): void
    {
        activity()
            ->performedOn($model)
            ->causedBy(Auth::user())
            ->withProperties($model->toArray())
            ->log($event->label());
    }
}
