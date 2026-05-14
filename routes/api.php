<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Api\AuthController;

// Public API Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected API Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rename API routes to prevent collision with Web routes
    Route::apiResource('stocks', StockController::class)->names([
        'index' => 'api.stocks.index',
        'store' => 'api.stocks.store',
        'show' => 'api.stocks.show',
        'update' => 'api.stocks.update',
        'destroy' => 'api.stocks.destroy',
    ]);

    Route::apiResource('stock-requests', StockRequestController::class)->names([
        'index' => 'api.stock-requests.index',
        'store' => 'api.stock-requests.store',
        'show' => 'api.stock-requests.show',
        'update' => 'api.stock-requests.update',
        'destroy' => 'api.stock-requests.destroy',
    ]);

    Route::get('reports/low-stock', [ReportController::class, 'lowStock']);
    Route::get('reports/department-requests', [ReportController::class, 'departmentRequests']);
});