<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;


Route::prefix('messages')
    ->middleware(['api'])
    ->group(function () {
        Route::resource('', MessageController::class)
            ->only(['show', 'destroy', 'edit', 'update'])
            ->parameters(["" => "id"]);
        
        Route::resource('', MessageController::class)
            ->only(['index', 'store']);
    });