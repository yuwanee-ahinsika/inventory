<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])
    ->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Web Routes
    Route::middleware('role:Admin')->group(function () {
        Route::resource('departments', \App\Http\Controllers\Web\DepartmentController::class);
        Route::resource('users', \App\Http\Controllers\Web\UserController::class);
    });

    Route::middleware('role:Admin|Inventory Manager')->group(function () {
        Route::resource('stocks', \App\Http\Controllers\Web\StockController::class);
        Route::get('reports', [\App\Http\Controllers\Web\ReportController::class, 'index'])->name('reports.index');
    });

    // Everyone can access requests, but what they see/do is handled in controller
    Route::resource('stock-requests', \App\Http\Controllers\Web\StockRequestController::class);
    
    Route::middleware('role:Admin|Inventory Manager')->group(function () {
        Route::post('stock-requests/{stock_request}/approve', [\App\Http\Controllers\Web\StockRequestController::class, 'approve'])->name('stock-requests.approve');
        Route::post('stock-requests/{stock_request}/reject', [\App\Http\Controllers\Web\StockRequestController::class, 'reject'])->name('stock-requests.reject');
    });
});

require __DIR__.'/auth.php';
