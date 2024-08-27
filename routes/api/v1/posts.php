<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware([])
    ->prefix('my')
    ->name('posts.')
    ->group(function () {

    Route::get('/posts' , [PostController::class, 'index'])->name('index');

    Route::get('/posts/{post}' , [PostController::class, 'show'])->name('show');

    Route::post('/posts' , [PostController::class, 'store'])->name('store');

    Route::patch('/posts/{post}' , [PostController::class, 'edit'])->name('update');

    Route::delete('/posts/{post}' , [PostController::class, 'destroy'])->name('delete');
});
