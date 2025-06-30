<?php

namespace App\Dtos\Comments;

use App\Dtos\BaseDTO;

class CommentListDTO extends BaseDTO
{
    public function __construct(
        public int $per_page,
        public ?string $search,
        public string $post_id
    ) {
        if ($this->search) {
            $this->search = $this->searchStrReplace($this->search);
        }
    }


    /**
     * {@inheritDoc}
     */
    public static function fromRequest(array $data): static
    {
        return new self(
            per_page: $data['per_page'] ?? 10,
            search: $data['search'] ?? null,
            post_id: $data['post_id'],
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'per_page' => $this->per_page,
            'search' => $this->search,
            'post_id' => $this->post_id
        ];
    }
}
