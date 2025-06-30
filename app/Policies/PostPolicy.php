<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('posts.view_any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('posts.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('posts.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->role()->name == RoleEnum::AUTHOR->value) {
            return $user->hasPermissionTo('posts.update') && $post->author_id == $user->id;
        }

        return $user->hasPermissionTo('posts.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('posts.delete');
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->hasPermissionTo('posts.publish');
    }
}
