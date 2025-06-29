<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\ListCategoryRequest;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Internal\CategoryService;
use App\Support\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ListCategoryRequest $request)
    {
        Gate::authorize('viewAny', Category::class);

        return ApiResponse::collection(
            CategoryResource::collection(
                $this->categoryService->all($request->toDto())
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('create', Category::class);

        $this->categoryService->create($request->toDto());

        return ApiResponse::created();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        Gate::authorize('view', Category::class);

        return ApiResponse::item(
            CategoryResource::make(
                $this->categoryService->show($category)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::authorize('update', Category::class);

        $this->categoryService->update($category, $request->toDto());

        return ApiResponse::updated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', Category::class);

        $this->categoryService->delete($category);

        return ApiResponse::deleted();
    }
}
