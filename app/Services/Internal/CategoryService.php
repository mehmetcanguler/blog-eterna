<?php

namespace App\Services\Internal;

use App\Dtos\Categories\CategoryDTO;
use App\Dtos\Categories\CategoryListDTO;
use App\Models\Category;

class CategoryService
{
    public function all(CategoryListDTO $data): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Category::query();

        if ($data->search) {
            $query->where('name', 'like', '%' . $data->search . '%');
        }
        return $query->paginate($data->per_page);

    }
    public function create(CategoryDTO $data): Category
    {
        return Category::create($data->toArray());
    }

    public function show(Category $category): Category
    {
        //Veri yükleme işlemleri yapılabilir Eager Loading $category->load('x') gibi
        return $category;
    }

    public function update(Category $category, CategoryDTO $data): Category
    {
        $category->update($data->toArray());
        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
