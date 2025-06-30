<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'cover_image' => MediaResource::make($this->coverImage()),
            'gallery_images' => MediaResource::collection($this->galleryImages()),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'author' => UserResource::make($this->whenLoaded('author')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => EnumResource::make($this->status)
        ];
    }
}
