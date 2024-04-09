<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('messages/', [MessageController::class,'index'])->name('message.index');
Route::post('messages/store', [MessageController::class,'store'])->name('message.store');
Route::get('posts/', [PostController::class,'index'])->name('post.index');
Route::post('posts/store', [PostController::class,'store'])->name('post.store');

Route::group([
    'middleware'=> 'api',
    'prefix' => 'auth'
], function($router){
    Route::post('login', [AuthController::class,'login'])->name('auth.login');
});