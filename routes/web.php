<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\v1\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome-doc');
});

Route::get('/dashboard', function () {
    return view('dashboard-doc');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product', [ProductController::class, 'create'])->name('products.create');
    Route::get('/product', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/product', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product', [ProductController::class, 'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';
