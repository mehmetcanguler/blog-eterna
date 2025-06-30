<?php

namespace App\Observers;

use App\Contracts\Logging\Loggable;
use App\Enums\ModelEvent;
use App\Models\User;

class UserObserver
{
    public function __construct(protected Loggable $logger) {}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void {}

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->logger->log($user, ModelEvent::UPDATED);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void {}

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void {}

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void {}
}
