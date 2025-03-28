<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\API\CheckoutController;


Route::apiResource('products', ProductController::class);
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::put('/{id}', [CartController::class, 'updateCart']);
    Route::delete('/{id}', [CartController::class, 'deleteCart']);
    Route::get('/', [CartController::class, 'listCart']);
});


Route::post('/checkout', [CheckoutController::class, 'checkout']);
