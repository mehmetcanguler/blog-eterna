<?php

namespace App\Models;

use App\Enums\CommentStatus;
use App\Observers\CommentObserver;
use App\Policies\CommentPolicy;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

#[UsePolicy(CommentPolicy::class)]
#[ObservedBy(CommentObserver::class)]
class Comment extends BaseModel
{
    use Blameable;

    protected $fillable = [
        'post_id',
        'content',
        'author_id',
        'status',
    ];

    protected $attributes = [
        'status' => CommentStatus::DRAFT,
    ];

    protected function casts(): array
    {
        return [
            'status' => CommentStatus::class,
        ];
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
