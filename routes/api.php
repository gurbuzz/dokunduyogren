<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;  // Güncelledik
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/users/register', [AuthenticatedSessionController::class, 'register']);
Route::post('/users/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/users/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book_id}', [BookController::class, 'show']);
    Route::put('/books/{book_id}', [BookController::class, 'update']);
    Route::delete('/books/{book_id}', [BookController::class, 'destroy']);

    Route::post('/pages', [PagesController::class, 'store']);
    Route::get('/pages/{page_id}', [PagesController::class, 'show']);
    Route::put('/pages/{page_id}', [PagesController::class, 'update']);
    Route::delete('/pages/{page_id}', [PagesController::class, 'destroy']);

    Route::post('/tags', [TagsController::class, 'store']);
    Route::get('/tags/{page_id}', [TagsController::class, 'index']);
    Route::put('/tags/{tag_id}', [TagsController::class, 'update']);
    Route::delete('/tags/{tag_id}', [TagsController::class, 'destroy']);
});
