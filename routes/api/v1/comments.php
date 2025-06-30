<?php

use App\Http\Controllers\CommentController;

Route::put('{comment}/publish', [CommentController::class, 'publish']);
Route::put('{comment}/un-publish', [CommentController::class, 'unPublish']);

Route::get('/', [CommentController::class, 'index']);
Route::post('/', [CommentController::class, 'store']);
Route::get('/{comment}', [CommentController::class, 'show']);
Route::put('/{comment}', [CommentController::class, 'update']);
Route::delete('/{comment}', [CommentController::class, 'destroy']);
