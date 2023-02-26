<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
//модуль 1 API
Route::middleware('auth:api')->get('/user', function () {
    return 1;
});
Route::post('/signup',  [\App\Http\Controllers\testController::class, 'createUser']);
Route::post('/login',  [\App\Http\Controllers\testController::class, 'loginUser']);

//Просто купить API
Route::get('/products', [ProductController::class, 'index']);
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->middleware(['auth:api']);
   // Route::middleware(['can:isUser,App\Models\User'])->group(function () {
        Route::prefix('cart')->group(function () {
            Route::post('/{product}', [ProductCartController::class, 'addProduct']);
            Route::get('/', [ProductCartController::class, 'show']);
            Route::delete('/{productCart}', [ProductCartController::class, 'remove']);
        });
        Route::prefix('order')->group(function () {
            Route::post('/', [OrderController::class, 'store']);
            Route::get('/', [OrderController::class, 'index']);
        });
   // });
   // Route::middleware(['can:isAdmin,App\Models\User'])->group(function () {
        Route::prefix('product')->group(function () {
            Route::post('/', [ProductController::class, 'store']);
            Route::delete('/{product}', [ProductController::class, 'remove']);
            Route::patch('/{product}', [ProductController::class, 'update']);
        });
   // });

});
//Route::post('/apartment',  [\App\Http\Controllers\testController::class, 'createUser']);
//apartment
//signup Route::middleware('auth:api')->get('/login',  [\App\Http\Controllers\testController::class, 'authorize']);
