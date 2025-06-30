<?php

namespace App\Dtos\Comments;

use App\Dtos\BaseDTO;
use Auth;

class CommentDTO extends BaseDTO
{
    public function __construct(
        public string $content,
        public string $post_id,
        public ?string $author_id
    ) {}

    public static function fromRequest(array $data): static
    {
        return new self(
            content: $data['content'],
            post_id: $data['post_id'],
            author_id: $data['author_id'] ?? Auth::id()
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'post_id' => $this->post_id,
            'author_id' => $this->author_id
        ];
    }
}
