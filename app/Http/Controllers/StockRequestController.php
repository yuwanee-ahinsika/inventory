<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $roleName = $user->role->name ?? '';

        $query = StockRequest::with(['user', 'department', 'stock', 'processor']);

        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        if (in_array($roleName, ['Admin', 'Inventory Manager'])) {
            $requests = $query->latest()->paginate(10);
            $stats = [
                'total_requests' => StockRequest::count(),
                'pending' => StockRequest::where('status', 'pending')->count(),
                'approved' => StockRequest::where('status', 'approved')->count(),
                'rejected' => StockRequest::where('status', 'rejected')->count(),
            ];
        } else {
            $requests = $query->where('department_id', $user->department_id)
                              ->latest()
                              ->paginate(10);
            $stats = [
                'total_requests' => StockRequest::where('department_id', $user->department_id)->count(),
                'pending' => StockRequest::where('department_id', $user->department_id)->where('status', 'pending')->count(),
                'approved' => StockRequest::where('department_id', $user->department_id)->where('status', 'approved')->count(),
                'rejected' => StockRequest::where('department_id', $user->department_id)->where('status', 'rejected')->count(),
            ];
        }

        return view('stock-requests.index', compact('requests', 'roleName', 'stats'));
    }

    public function create(Request $request)
    {
        $selectedStockId = $request->get('stock_id');
        $stocks = Stock::where('quantity', '>', 0)->get();
        return view('stock-requests.create', compact('stocks', 'selectedStockId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $stock = Stock::findOrFail($validated['stock_id']);
        
        if ($stock->quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough stock available.'])->withInput();
        }

        $user = auth()->user();

        StockRequest::create([
            'user_id' => $user->id,
            'department_id' => $user->department_id,
            'stock_id' => $stock->id,
            'quantity' => $validated['quantity'],
            'status' => 'pending',
        ]);

        return redirect()->route('stock-requests.index')->with('success', 'Stock requested successfully.');
    }

    public function approve(Request $request, StockRequest $stock_request)
    {
        if ($stock_request->status !== 'pending') {
            return back()->withErrors(['error' => 'Request is already processed.']);
        }

        $stock = $stock_request->stock;

        if ($stock->quantity < $stock_request->quantity) {
            return back()->withErrors(['error' => 'Not enough stock available to fulfill request.']);
        }

        $stock->decrement('quantity', $stock_request->quantity);

        $stock_request->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, StockRequest $stock_request)
    {
        if ($stock_request->status !== 'pending') {
            return back()->withErrors(['error' => 'Request is already processed.']);
        }

        $stock_request->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Request rejected.');
    }
}
