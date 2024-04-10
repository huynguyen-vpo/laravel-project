<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('posts/', [PostController::class,'index'])->name('post.index');
Route::post('posts/store', [PostController::class,'store'])->name('post.store');
