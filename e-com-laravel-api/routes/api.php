<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ShoppingCartsController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(ProductsController::class)->group(function () {
    Route::post('add_product', 'add_product');
    Route::post('edit_product/{id}', 'edit_product');
    Route::get('get_products/{id?}', 'get_products');
    Route::delete('delete_product/{id}', 'delete_product');
});

Route::controller(OrdersController::class)->group(function () {
    Route::post('add_order', 'add_order');
    Route::post('edit_order/{id}', 'edit_order');
    Route::get('get_orders/{id?}', 'get_orders');
    Route::delete('delete_order/{id}', 'delete_order');
});

Route::controller(ShoppingCartsController::class)->group(function () {
    Route::get('view_cart', 'view_cart');
    Route::get('view_transaction_history', 'view_transaction_history');
});
