<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

// Routes Publiques
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{slug}', [ProductController::class, 'show']);

// Routes Protégées (Nécessitent un Token JWT valide)
Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'auth:api'], function () {
    // Espace Client
    Route::get('orders', [\App\Http\Controllers\Api\OrderController::class, 'myOrders']);
    Route::post('orders', [\App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::post('orders/{id}/cancel', [\App\Http\Controllers\Api\OrderController::class, 'cancel']);
    
    // Espace Employé/Admin
    Route::get('staff/orders/pending', [\App\Http\Controllers\Api\OrderController::class, 'pendingOrders']);
    Route::put('staff/orders/{id}/status', [\App\Http\Controllers\Api\OrderController::class, 'updateStatus']);
    
    // Espace Admin
    Route::get('admin/stats', [\App\Http\Controllers\Api\AdminController::class, 'stats']);
    Route::post('admin/products', [\App\Http\Controllers\Api\ProductController::class, 'store']);
    Route::put('admin/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::delete('admin/products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'destroy']);
});
