<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roleName = $user->role->name ?? '';

        if (in_array($roleName, ['Admin', 'Inventory Manager'])) {
            $requests = StockRequest::with(['user', 'department', 'stock'])->latest()->paginate(10);
        } else {
            $requests = StockRequest::with(['user', 'department', 'stock'])
                        ->where('department_id', $user->department_id)
                        ->latest()
                        ->paginate(10);
        }

        return view('stock-requests.index', compact('requests', 'roleName'));
    }

    public function create()
    {
        $stocks = Stock::where('quantity', '>', 0)->get();
        return view('stock-requests.create', compact('stocks'));
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
