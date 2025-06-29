<?php

namespace App\Http\Requests\Categories;

use App\Dtos\Categories\CategoryListDTO;
use App\Http\Requests\ListRequest;

class ListCategoryRequest extends ListRequest
{
    public function toDto(): CategoryListDTO
    {
        return CategoryListDTO::fromRequest($this->validated());
    }
}
