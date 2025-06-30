<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Observers\PostObserver;
use App\Policies\PostPolicy;
use App\Traits\Blameable;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[UsePolicy(PostPolicy::class)]
#[ObservedBy(PostObserver::class)]
class Post extends BaseModel implements HasMedia
{
    use Blameable, HasSlug, InteractsWithMedia, HasFactory;

    public const MEDIA_COLLECTION_COVER = 'cover';

    public const MEDIA_COLLECTION_GALLERY = 'gallery';

    protected $fillable = [
        'author_id',
        'title',
        'content',
        'published_at',
        'status',
    ];

    protected $attributes = [
        'status' => PostStatus::DRAFT,
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
        ];
    }

    protected function getSlugSource(): string
    {
        return 'title';
    }

    public function coverImage(): ?Media
    {
        return $this->getMedia(self::MEDIA_COLLECTION_COVER)->first();
    }

    public function galleryImages(): MediaCollection
    {
        return $this->getMedia(self::MEDIA_COLLECTION_GALLERY);
    }

    public function setCoverImage(string|UploadedFile $image): Media
    {
        if (!$this->exists) {
            $this->save();
        }

        return $this->addMedia($image)->toMediaCollection(self::MEDIA_COLLECTION_COVER);
    }

    /**
     *  @param  array<UploadedFile> <string|UploadedFile>  $images
     */
    public function setGalleryImages(array $images): bool
    {
        if (!$this->exists) {
            $this->save();
        }
        foreach ($images as $image) {
            $this->addMedia($image)->toMediaCollection(self::MEDIA_COLLECTION_GALLERY);
        }

        return true;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
