<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiBookController;
use App\Http\Controllers\API\ApiPagesController;
use App\Http\Controllers\API\ApiTagsController;
use App\Http\Controllers\API\ApiAuthController;


Route::prefix('v1')->group(function () {
    Route::post('/users/register', [ApiAuthController::class, 'register']);
    Route::post('/users/login', [ApiAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
         Route::post('/users/logout', [ApiAuthController::class, 'logout']);

        Route::post('/books', [ApiBookController::class, 'store']);
        Route::get('/books', [ApiBookController::class, 'index']);
        Route::get('/books/{book_id}', [ApiBookController::class, 'show']);
        Route::put('/books/{book_id}', [ApiBookController::class, 'update']);
        Route::delete('/books/{book_id}', [ApiBookController::class, 'destroy']);

        Route::post('/pages', [ApiPagesController::class, 'store']);
        Route::get('/books/{book_id}/pages', [ApiPagesController::class, 'index']);
        Route::get('/pages/{page_id}', [ApiPagesController::class, 'show']);
        Route::put('/pages/{page_id}', [ApiPagesController::class, 'update']);
        Route::delete('/pages/{page_id}', [ApiPagesController::class, 'destroy']);
        Route::post('/pages/{page_id}/store_qrcode', [ApiPagesController::class, 'storeQRCode']);

        Route::post('/tags', [ApiTagsController::class, 'store']);
        Route::get('/tags/{page_id}', [ApiTagsController::class, 'index']);
        Route::put('/tags/{tag_id}', [ApiTagsController::class, 'update']);
        Route::delete('/tags/{tag_id}', [ApiTagsController::class, 'destroy']);
        Route::post('/tags/{page_id}/store_tags', [ApiTagsController::class, 'storeTags']);
        Route::post('/tags/{page_id}/translate', [ApiTagsController::class, 'storeTranslateTags']);
    });
});

