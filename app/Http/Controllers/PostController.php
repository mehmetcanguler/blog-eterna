<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\ListPostRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Internal\PostService;
use App\Support\Helpers\ApiResponse;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
   public function __construct(
        private PostService $postService
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ListPostRequest $request)
    {
        Gate::authorize('viewAny', Post::class);

        return ApiResponse::collection(
            PostResource::collection(
                $this->postService->all($request->toDto())
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        Gate::authorize('create', Post::class);

        $this->postService->create($request->toDto());

        return ApiResponse::created();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        Gate::authorize('view', Post::class);

        return ApiResponse::item(
            PostResource::make(
                $this->postService->show($post)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', Post::class);

        $this->postService->update($post, $request->toDto());

        return ApiResponse::updated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', Post::class);

        $this->postService->delete($post);

        return ApiResponse::deleted();
    }
}
