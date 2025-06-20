<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/products', [ProductController::class, 'apiIndex']);
    Route::post('/sales-orders', [SalesOrderController::class, 'apiStore']);
    Route::get('/sales-orders/{id}', [SalesOrderController::class, 'apiShow']);
});

?>
