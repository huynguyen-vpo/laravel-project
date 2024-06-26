<?php

use App\Http\Controllers\AuthController;
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

Route::group([
    'middleware'=> 'api',
    'prefix' => 'auth'
], function($router){
    Route::post('login', [AuthController::class,'login'])->name('auth.login');
});

$routes = glob(__DIR__ . "/api/*.php");
foreach ($routes as $route) require($route);