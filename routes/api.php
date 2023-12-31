<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Purchase\BuyController;
use App\Http\Controllers\Purchase\RentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'jwt.guard'], function () {
    Route::post('products/{productId}/buy', [BuyController::class, 'store']);
    Route::post('products/{productId}/rent', [RentController::class, 'store']);
    Route::put('rent/{rentId}', [RentController::class, 'update']);
    Route::apiResource('purchases', BuyController::class)
        ->only('index');
    Route::apiResource('rent', RentController::class)
        ->only('index');
});
Route::apiResource('products', ProductController::class)
    ->only(['index', 'show']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware' => 'jwt.guard'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::get('test_deposit', [AuthController::class, 'testDeposit']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
