<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\StockRequestController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks', [StockController::class, 'store']);
Route::get('/stocks/{stock}', [StockController::class, 'show']);
Route::put('/stocks/{stock}', [StockController::class, 'update']);
Route::delete('/stocks/{stock}', [StockController::class, 'destroy']);

Route::get('/stock-requests', [StockRequestController::class, 'index']);
Route::post('/stock-requests', [StockRequestController::class, 'store']);
Route::get('/stock-requests/{stock_request}', [StockRequestController::class, 'show']);
Route::put('/stock-requests/{stock_request}', [StockRequestController::class, 'update']);
Route::delete('/stock-requests/{stock_request}', [StockRequestController::class, 'destroy']);

Route::get('/reports/low-stock', [ReportController::class, 'lowStock']);
Route::get('/reports/department-requests', [ReportController::class, 'departmentRequests']);