<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Policies\CategoryPolicy;
use App\Traits\Blameable;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[UsePolicy(CategoryPolicy::class)]
#[ObservedBy(CategoryObserver::class)]
class Category extends BaseModel
{
    use Blameable, HasSlug, HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function getSlugSource(): string
    {
        return 'name';
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
