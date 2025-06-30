<?php

namespace App\Contracts\Internal;

use App\Dtos\Categories\CategoryDTO;
use App\Dtos\Categories\CategoryListDTO;
use App\Dtos\Categories\CategoryUpdateDTO;
use App\Models\Category;

/**
 * @extends ServiceInterface<Category, CategoryDTO, CategoryUpdateDTO, CategoryListDTO>
 */
interface CategoryServiceInterface extends ServiceInterface
{
    //
}
