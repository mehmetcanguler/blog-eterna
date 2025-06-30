<?php

namespace App\Http\Requests\Posts;

use App\Dtos\Posts\PostListDTO;
use App\Http\Requests\ListRequest;

class ListPostRequest extends ListRequest
{
    public function toDto(): PostListDTO
    {
        return PostListDTO::fromRequest($this->validated());
    }
}
