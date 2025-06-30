<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('comments.view_any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('comments.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('comments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        if ($user->role()->name == RoleEnum::AUTHOR->value) {
            return $user->hasPermissionTo('comments.update') && $comment->author_id == $user->id;
        }

        return $user->hasPermissionTo('comments.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('comments.delete');
    }

    public function publish(User $user, Comment $comment): bool
    {
        return $user->hasPermissionTo('comments.publish');
    }
}
