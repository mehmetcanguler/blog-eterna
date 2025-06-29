<?php

namespace App\Services\Internal;

use App\Dtos\Posts\PostDTO;
use App\Dtos\Posts\PostListDTO;
use App\Dtos\Posts\PostUpdateDTO;
use App\Models\Post;

class PostService
{
    public function all(PostListDTO $data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Post::query()->with('categories');

        if ($data->search) {
            $query->where('title', 'like', '%' . $data->search . '%')
                ->orWhere('content', 'like', '%' . $data->search . '%');
        }
        return $query->paginate($data->per_page);

    }
    public function create(PostDTO $data): Post
    {
        $post = Post::create([
            'title' => $data->title,
            'content' => $data->content
        ]);

        $post->setCoverImage($data->coverImage);
        $post->setGalleryImages($data->galleryImages);
        $post->categories()->sync($data->categories);

        return $post;
    }

    public function show(Post $post): Post
    {
        $post->load('categories');
        return $post;
    }

    public function update(Post $post, PostUpdateDTO $data): Post
    {
        $post->update([
            'title' => $data->title,
            'content' => $data->content
        ]);

        $post->categories()->sync($data->categories);
        return $post;
    }

    public function delete(Post $post): bool
    {
        $post->categories()->detach();

        return $post->delete();
    }
}
