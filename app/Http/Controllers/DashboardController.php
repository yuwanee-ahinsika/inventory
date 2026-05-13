<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockRequest;
use App\Models\User;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['role', 'department']);
        $roleName = $user->role->name ?? 'User';

        $stats = [];
        $recentRequests = [];

        if ($roleName === 'Admin') {
            $stats['total_users'] = User::count();
            $stats['total_departments'] = Department::count();
            $stats['total_stocks'] = Stock::sum('quantity');
            $stats['pending_requests'] = StockRequest::where('status', 'pending')->count();
            
            $recentRequests = StockRequest::with(['user', 'stock', 'department'])->latest()->take(5)->get();
        } elseif ($roleName === 'Inventory Manager') {
            $stats['total_stocks'] = Stock::sum('quantity');
            $stats['low_stock_items'] = Stock::where('quantity', '<', 10)->count();
            $stats['pending_requests'] = StockRequest::where('status', 'pending')->count();
            $stats['approved_requests'] = StockRequest::where('status', 'approved')->count();
            
            $recentRequests = StockRequest::with(['user', 'stock', 'department'])->where('status', 'pending')->latest()->take(5)->get();
        } else {
            // Department User
            $departmentId = $user->department_id;
            $stats['my_pending_requests'] = StockRequest::where('department_id', $departmentId)->where('status', 'pending')->count();
            $stats['my_approved_requests'] = StockRequest::where('department_id', $departmentId)->where('status', 'approved')->count();
            $stats['total_items_received'] = StockRequest::where('department_id', $departmentId)->where('status', 'approved')->sum('quantity');
            
            $recentRequests = StockRequest::with(['stock'])->where('department_id', $departmentId)->latest()->take(5)->get();
        }

        return view('dashboard', compact('user', 'roleName', 'stats', 'recentRequests'));
    }
}
