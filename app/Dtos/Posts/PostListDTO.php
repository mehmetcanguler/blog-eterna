<?php

namespace App\Dtos\Posts;

use App\Dtos\FilterDTO;
use App\Dtos\ListDTO;

class PostListDTO extends ListDTO
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
