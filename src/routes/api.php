<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
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

Route::group(['prefix' => 'product'], function () {
    Route::get('', [ProductController::class, 'index']);
});

Route::group(['prefix' => 'sale'], function () {
    Route::get('', [SaleController::class, 'index']);
    Route::post('', [SaleController::class, 'create']);
    Route::put('/{id}', [SaleController::class, 'update']);
    Route::get('/{id}', [SaleController::class, 'findByFilter']);
    Route::delete('/{id}', [SaleController::class, 'delete']);
});