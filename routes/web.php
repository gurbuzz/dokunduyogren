<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PagesController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pages/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::patch('/pages/{id}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');
});

require __DIR__.'/auth.php';
