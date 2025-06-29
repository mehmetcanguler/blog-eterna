<?php

namespace App\Observers;

use App\Contracts\Logging\Loggable;
use App\Enums\ModelEvent;
use App\Models\Post;

class PostObserver
{
    public function __construct(protected Loggable $logger)
    {

    }
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->logger->log($post, ModelEvent::CREATED);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->logger->log($post, ModelEvent::UPDATED);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->logger->log($post, ModelEvent::DELETED);
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
       $this->logger->log($post, ModelEvent::RESTORED);
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
       $this->logger->log($post, ModelEvent::FORCE_DELETED);
    }
}
