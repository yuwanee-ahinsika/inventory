<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockRequestController;
use App\Http\Controllers\ReportController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('stocks', StockController::class);
    Route::apiResource('stock-requests', StockRequestController::class);

    Route::get('reports/low-stock', [ReportController::class, 'lowStock']);
    Route::get('reports/department-requests', [ReportController::class, 'departmentRequests']);
});
