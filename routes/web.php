<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Document\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome-doc');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DocumentController::class, 'index'])->name('dashboard');
    Route::get('/document/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/document/store', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/document/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::patch('/document/{id}/update', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/document/{id}/destroy', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{id}/download/{format}', [DocumentController::class, 'downloadFilledDocument'])->name('documents.download');
});

require __DIR__.'/auth.php';
