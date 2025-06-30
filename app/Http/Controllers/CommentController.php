<?php

namespace App\Http\Controllers;

use App\Contracts\Internal\CommentServiceInterface;
use App\Http\Requests\Comments\ListCommentRequest;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Support\Helpers\ApiResponse;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct(
        public CommentServiceInterface $commentService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListCommentRequest $request)
    {
        Gate::authorize('viewAny', Comment::class);

        return ApiResponse::collection(
            CommentResource::collection(
                $this->commentService->all($request->toDto())
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        Gate::authorize('create', Comment::class);

        $this->commentService->create($request->toDto());

        return ApiResponse::created();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        Gate::authorize('view', $comment);

        return ApiResponse::item(
            CommentResource::make(
                $this->commentService->show($comment)
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $this->commentService->update($comment, $request->toDto());

        return ApiResponse::updated();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $this->commentService->delete($comment);

        return ApiResponse::deleted();
    }

    public function publish(Comment $comment)
    {
        Gate::authorize('publish', $comment);

        $this->commentService->publish($comment);

        return ApiResponse::updated();
    }
    public function unPublish(Comment $comment)
    {
        Gate::authorize('publish', $comment);

        $this->commentService->unPublish($comment);

        return ApiResponse::updated();
    }
}
