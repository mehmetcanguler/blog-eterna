<?php

namespace App\Dtos\Categories;

class CategoryUpdateDTO extends CategoryDTO
{
    public function __construct(
        public string $name
    ) {}
}
