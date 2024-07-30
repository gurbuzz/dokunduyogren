<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TagsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.home');
});

Route::get('/books', [BookController::class, 'index'])->middleware(['auth', 'verified'])->name('books.index');

// Kullanıcı yetkilendirme ile korunan rotalar grubu
Route::middleware('auth')->group(function () {
    // Profil rotaları
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sayfa rotaları
    Route::get('/pages/create/{book}', [PagesController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{page}/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::patch('/pages/{page}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PagesController::class, 'destroy'])->name('pages.destroy');
    Route::get('/pages/{page}/tags', [TagsController::class, 'showTags'])->name('pages.show_tags');
    // Belirli bir kitap için sayfa oluşturma ve QR kod ekleme
    Route::get('/books/{book}/pages/create', [PagesController::class, 'createForBook'])->name('books.pages.create');
    Route::post('/books/{book}/pages', [PagesController::class, 'storeForBook'])->name('books.pages.store');
    Route::get('/pages/{page}/create_qrcode', [PagesController::class, 'createQRCode'])->name('pages.create.qrcode');
    Route::post('/pages/{page}/store_qrcode', [PagesController::class, 'storeQRCode'])->name('pages.store.qrcode');

    // Kitap ve sayfa görüntüleme rotaları
    Route::get('/books/{book}/pages', [PagesController::class, 'index'])->name('books.pages.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::patch('/books/{id}', [BookController::class, 'update'])->name('books.update');

    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/pages/{page}/add_tags', [TagsController::class, 'create'])->name('pages.add_tags');
    Route::post('/pages/{page}/store_tags', [TagsController::class, 'storeTags'])->name('pages.store_tags');
    Route::get('/pages/{page}/label_tags', [TagsController::class, 'label'])->name('pages.label_tags');
    Route::post('/pages/{page}/store_labels', [TagsController::class, 'labelStore'])->name('pages.store_labels');
});

require __DIR__.'/auth.php';
