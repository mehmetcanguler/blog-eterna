<?php

namespace App\Dtos;

class ListDTO extends BaseDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $per_page = 10,
        public ?string $search
    ) {
        //
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
            'search' => $this->search
        ];
    }

    protected function searchStrReplace(string $search): string
    {
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);

        return $search;
    }
}
