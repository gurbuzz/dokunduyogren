<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BookController;
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
    Route::get('/pages/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::patch('/pages/{id}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');
    
    // Belirli bir kitap için sayfa oluşturma ve QR kod ekleme
    Route::get('/books/{book}/pages/create', [PagesController::class, 'createForBook'])->name('books.pages.create');
    Route::post('/books/{book}/pages', [PagesController::class, 'storeForBook'])->name('books.pages.store');
    Route::get('/pages/create/qrcode', [PagesController::class, 'createQRCode'])->name('pages.create.qrcode');
    Route::post('/pages/store/qrcode', [PagesController::class, 'storeQRCode'])->name('pages.store.qrcode');

    // Kitap ve sayfa görüntüleme rotaları
    Route::get('/books/{book}/pages', [PagesController::class, 'index'])->name('books.pages.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::patch('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
});


require __DIR__.'/auth.php';
