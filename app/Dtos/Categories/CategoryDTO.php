<?php

namespace App\Dtos\Categories;

use App\Dtos\BaseDTO;

class CategoryDTO extends BaseDTO
{
    public function __construct(
        public string $name
    ) {}

    public static function fromRequest(array $data): static
    {
        return new self(
            name: $data['name']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
