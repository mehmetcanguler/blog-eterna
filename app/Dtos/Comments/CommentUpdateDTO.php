<?php

namespace App\Dtos\Comments;

use App\Dtos\BaseDTO;

class CommentUpdateDTO extends BaseDTO
{
    public function __construct(
        public string $content
    ) {}

    public static function fromRequest(array $data): static
    {
        return new self(
            content: $data['content'],
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
