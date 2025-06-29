<?php

namespace App\Dtos\Categories;

use App\Dtos\ListDTO;

class CategoryListDTO extends ListDTO
{
    public function __construct(
        public int $per_page = 10,
        public ?string $search,
    ) {
        if ($this->search) {
            $this->search = $this->searchStrReplace($this->search);
        }
    }
}
