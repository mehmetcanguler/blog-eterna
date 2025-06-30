<?php

namespace App\Dtos\Posts;

use App\Dtos\BaseDTO;

class PostListDTO extends BaseDTO
{
    public function __construct(
        public int $per_page,
        public ?string $search,
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
            search: $data['search'] ?? null
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
        ];
    }
}
