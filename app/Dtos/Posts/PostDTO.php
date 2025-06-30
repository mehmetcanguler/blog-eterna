<?php

namespace App\Dtos\Posts;

use App\Dtos\BaseDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostDTO extends BaseDTO
{
    /**
     * @param   array<UploadedFile>  $galleryImages
     * @param  \Illuminate\Database\Eloquent\Collection<\App\Models\Category>  $categories
     */
    public function __construct(
        public string $title,
        public string $content,
        public UploadedFile $coverImage,
        public array $galleryImages,
        public array|Collection $categories
    ) {
    }

    public static function fromRequest(array $data): static
    {
        return new self(
            title: $data['title'],
            content: $data['content'],
            coverImage: $data['cover_image'],
            galleryImages: $data['gallery_images'],
            categories: Category::whereIn('id', $data['categories'])->get()
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'cover_image' => $this->coverImage,
            'gallery_images' => $this->galleryImages,
            'categories' => $this->categories,
        ];
    }
}
