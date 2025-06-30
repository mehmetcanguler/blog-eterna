<?php

namespace App\Dtos\Posts;

use App\Dtos\BaseDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class PostUpdateDTO extends BaseDTO
{
    /**
     * @param  \Illuminate\Database\Eloquent\Collection<\App\Models\Category>  $categories
     */
    public function __construct(
        public string $title,
        public string $content,
        public array|Collection $categories
    ) {}

    public static function fromRequest(array $data): static
    {
        return new self(
            title: $data['title'],
            content: $data['content'],
            categories: Category::whereIn('id', $data['categories'])->get()
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'categories' => $this->categories,
        ];
    }
}
