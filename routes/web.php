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
    
    // Web Routes - Admin only
    Route::middleware('role:Admin')->group(function () {
        Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });

    // Stocks list is visible to everyone, but create/edit/delete is restricted
    Route::get('stocks', [\App\Http\Controllers\StockController::class, 'index'])->name('stocks.index');
    Route::middleware('role:Admin,Inventory Manager')->group(function () {
        Route::get('stocks/create', [\App\Http\Controllers\StockController::class, 'create'])->name('stocks.create');
        Route::post('stocks', [\App\Http\Controllers\StockController::class, 'store'])->name('stocks.store');
        Route::get('stocks/{stock}/edit', [\App\Http\Controllers\StockController::class, 'edit'])->name('stocks.edit');
        Route::put('stocks/{stock}', [\App\Http\Controllers\StockController::class, 'update'])->name('stocks.update');
        Route::delete('stocks/{stock}', [\App\Http\Controllers\StockController::class, 'destroy'])->name('stocks.destroy');
        
        Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });

    // Everyone can access requests, but what they see/do is handled in controller
    Route::resource('stock-requests', \App\Http\Controllers\StockRequestController::class);
    
    // HOD approval routes
    Route::middleware('role:HOD')->group(function () {
        Route::post('stock-requests/{stock_request}/hod-approve', [\App\Http\Controllers\StockRequestController::class, 'hodApprove'])->name('stock-requests.hod-approve');
        Route::post('stock-requests/{stock_request}/hod-reject', [\App\Http\Controllers\StockRequestController::class, 'hodReject'])->name('stock-requests.hod-reject');
    });

    // Manager/Admin approval routes (only after HOD has approved)
    Route::middleware('role:Admin,Inventory Manager')->group(function () {
        Route::post('stock-requests/{stock_request}/approve', [\App\Http\Controllers\StockRequestController::class, 'approve'])->name('stock-requests.approve');
        Route::post('stock-requests/{stock_request}/reject', [\App\Http\Controllers\StockRequestController::class, 'reject'])->name('stock-requests.reject');
    });
});

require __DIR__.'/auth.php';
