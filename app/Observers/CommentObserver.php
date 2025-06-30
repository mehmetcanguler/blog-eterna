<?php

namespace App\Observers;

use App\Contracts\Logging\Loggable;
use App\Enums\ModelEvent;
use App\Models\Comment;
use Auth;

class CommentObserver
{
    public function __construct(protected Loggable $logger) {}

    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        $this->logger->log($comment, ModelEvent::UPDATED);
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
