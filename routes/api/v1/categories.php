<?php

use App\Http\Controllers\CategoryController;

Route::get('/', [CategoryController::class, 'index']);
Route::post('/', [CategoryController::class, 'store']);
Route::get('/{category}', [CategoryController::class, 'show']);
Route::put('/{category}', [CategoryController::class, 'update']);
Route::delete('/{category}', [CategoryController::class, 'destroy']);
