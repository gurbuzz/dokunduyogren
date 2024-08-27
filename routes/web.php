<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tags\TagManagementController;
use App\Http\Controllers\Tags\TagViewController;
use App\Http\Controllers\Tags\TagCreationController;
use App\Http\Controllers\Tags\TagTranslationController;
use App\Http\Controllers\Books\BookManagementController;
use App\Http\Controllers\Books\BookViewController;
use App\Http\Controllers\Books\BookCreationController;
use App\Http\Controllers\Pages\PageManagementController;
use App\Http\Controllers\Pages\PageViewController;
use App\Http\Controllers\Pages\PageCreationController;
use App\Http\Controllers\Pages\PageQRCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
});

Route::get('/books', [BookViewController::class, 'index'])->middleware(['auth', 'verified'])->name('books.index');

// Kullanıcı yetkilendirme ile korunan rotalar grubu
Route::middleware('auth')->group(function () {
    // Profil rotaları
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sayfa rotaları
    Route::get('/books/{book}/pages', [PageViewController::class, 'index'])->name('books.pages.index');
    Route::get('/pages/create/{book}', [PageCreationController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageCreationController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}/edit', [PageManagementController::class, 'edit'])->name('pages.edit');
    Route::patch('/pages/{page}', [PageManagementController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageManagementController::class, 'destroy'])->name('pages.destroy');

    Route::get('/books/{book}/pages/create', [PageCreationController::class, 'createForBook'])->name('books.pages.create');
    Route::post('/books/{book}/pages', [PageCreationController::class, 'storeForBook'])->name('books.pages.store');
    Route::get('/pages/{page}/create_qrcode', [PageQRCodeController::class, 'createQRCode'])->name('pages.create.qrcode');
    Route::post('/pages/{page}/store_qrcode', [PageQRCodeController::class, 'storeQRCode'])->name('pages.store.qrcode');

    // Kitap ve sayfa görüntüleme rotaları
    Route::get('/books/create', [BookCreationController::class, 'create'])->name('books.create');
    Route::post('/books', [BookCreationController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookManagementController::class, 'edit'])->name('books.edit');
    Route::match(['put', 'patch'], '/books/{id}', [BookManagementController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookManagementController::class, 'destroy'])->name('books.destroy');

    // Etiket ekleme rotaları
    Route::get('/pages/{page}/add_tags', [TagCreationController::class, 'create'])->name('pages.add_tags');
    Route::post('/pages/{page}/store_tags', [TagCreationController::class, 'storeTags'])->name('pages.store_tags');
    route::get('/pages/{page}/tags', [TagViewController::class, 'showTags'])->name('pages.show_tags');

    // Etiket çeviri rotaları
    Route::get('/pages/{page}/translate', [TagTranslationController::class, 'showTranslateTags'])->name('pages.translate_tags');
    Route::post('/pages/{page}/translate', [TagTranslationController::class, 'storeTranslateTags'])->name('tags.translate.store');
});

require __DIR__.'/auth.php';
