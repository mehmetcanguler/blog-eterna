<?php

use App\Http\Controllers\PostController;

Route::put('{post}/publish', [PostController::class, 'publish']);
Route::put('{post}/un-publish', [PostController::class, 'unPublish']);

Route::get('/', [PostController::class, 'index']);
Route::post('/', [PostController::class, 'store']);
Route::get('/{post}', [PostController::class, 'show']);
Route::put('/{post}', [PostController::class, 'update']);
Route::delete('/{post}', [PostController::class, 'destroy']);
