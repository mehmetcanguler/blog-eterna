<?php

namespace App\Services\Internal;

use App\Contracts\Internal\CategoryServiceInterface;
use App\Dtos\Categories\CategoryDTO;
use App\Dtos\Categories\CategoryListDTO;
use App\Dtos\Categories\CategoryUpdateDTO;
use App\Models\Category;

/**
 * @extends BaseService<Category, CategoryDTO, CategoryUpdateDTO, CategoryListDTO>
 */
class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
