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

        $query = StockRequest::with(['user', 'department', 'stock', 'processor', 'hodApprover']);

        // Status filter
        if ($request->has('status') && in_array($request->status, ['pending_hod', 'pending_manager', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        if (in_array($roleName, ['Admin', 'Inventory Manager'])) {
            // Admin/Manager see all requests
            $requests = $query->latest()->paginate(10);
            $stats = [
                'total_requests' => StockRequest::count(),
                'pending_hod' => StockRequest::where('status', 'pending_hod')->count(),
                'pending_manager' => StockRequest::where('status', 'pending_manager')->count(),
                'approved' => StockRequest::where('status', 'approved')->count(),
                'rejected' => StockRequest::where('status', 'rejected')->count(),
            ];
        } elseif ($roleName === 'HOD') {
            // HOD sees requests from their department
            $requests = $query->where('department_id', $user->department_id)
                              ->latest()
                              ->paginate(10);
            $stats = [
                'total_requests' => StockRequest::where('department_id', $user->department_id)->count(),
                'pending_hod' => StockRequest::where('department_id', $user->department_id)->where('status', 'pending_hod')->count(),
                'pending_manager' => StockRequest::where('department_id', $user->department_id)->where('status', 'pending_manager')->count(),
                'approved' => StockRequest::where('department_id', $user->department_id)->where('status', 'approved')->count(),
                'rejected' => StockRequest::where('department_id', $user->department_id)->where('status', 'rejected')->count(),
            ];
        } else {
            // Department User sees only their own requests
            $requests = $query->where('user_id', $user->id)
                              ->latest()
                              ->paginate(10);
            $stats = [
                'total_requests' => StockRequest::where('user_id', $user->id)->count(),
                'pending_hod' => StockRequest::where('user_id', $user->id)->where('status', 'pending_hod')->count(),
                'pending_manager' => StockRequest::where('user_id', $user->id)->where('status', 'pending_manager')->count(),
                'approved' => StockRequest::where('user_id', $user->id)->where('status', 'approved')->count(),
                'rejected' => StockRequest::where('user_id', $user->id)->where('status', 'rejected')->count(),
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
        $roleName = $user->role->name ?? '';

        // HOD requests skip HOD approval and go directly to Inventory Manager
        if ($roleName === 'HOD') {
            $status = 'pending_manager';
            $hodStatus = 'approved';
            $successMsg = 'Stock request submitted. Forwarded directly to Inventory Manager.';
        } else {
            $status = 'pending_hod';
            $hodStatus = 'pending_hod';
            $successMsg = 'Stock request submitted. Waiting for HOD approval.';
        }

        StockRequest::create([
            'user_id' => $user->id,
            'department_id' => $user->department_id,
            'stock_id' => $stock->id,
            'quantity' => $validated['quantity'],
            'status' => $status,
            'hod_status' => $hodStatus,
            'hod_approved_by' => $roleName === 'HOD' ? $user->id : null,
        ]);

        return redirect()->route('stock-requests.index')->with('success', $successMsg);
    }

    /**
     * HOD approves the request - moves it to Inventory Manager
     */
    public function hodApprove(Request $request, StockRequest $stock_request)
    {
        $user = auth()->user();
        $isAssignedHod = ($stock_request->user->hod_id ?? null) === $user->id;
        $isDeptHod = ($user->role->name ?? '') === 'HOD' && $stock_request->department_id === $user->department_id;

        if (!$isAssignedHod && !$isDeptHod) {
            abort(403, 'Unauthorized action.');
        }

        if ($stock_request->status !== 'pending_hod') {
            return back()->withErrors(['error' => 'This request is not pending HOD approval.']);
        }

        $stock_request->update([
            'status' => 'pending_manager',
            'hod_status' => 'approved',
            'hod_approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Request approved by HOD. Forwarded to Inventory Manager.');
    }

    /**
     * HOD rejects the request
     */
    public function hodReject(Request $request, StockRequest $stock_request)
    {
        $user = auth()->user();
        $isAssignedHod = ($stock_request->user->hod_id ?? null) === $user->id;
        $isDeptHod = ($user->role->name ?? '') === 'HOD' && $stock_request->department_id === $user->department_id;

        if (!$isAssignedHod && !$isDeptHod) {
            abort(403, 'Unauthorized action.');
        }

        if ($stock_request->status !== 'pending_hod') {
            return back()->withErrors(['error' => 'This request is not pending HOD approval.']);
        }

        $stock_request->update([
            'status' => 'rejected',
            'hod_status' => 'rejected',
            'hod_approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Request rejected by HOD.');
    }

    /**
     * Inventory Manager / Admin approves the request - deducts stock
     */
    public function approve(Request $request, StockRequest $stock_request)
    {
        if ($stock_request->status !== 'pending_manager') {
            return back()->withErrors(['error' => 'This request must be approved by HOD first.']);
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

    /**
     * Inventory Manager / Admin rejects the request
     */
    public function reject(Request $request, StockRequest $stock_request)
    {
        if ($stock_request->status !== 'pending_manager') {
            return back()->withErrors(['error' => 'This request must be approved by HOD first.']);
        }

        $stock_request->update([
            'status' => 'rejected',
            'processed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Request rejected.');
    }

    public function edit(StockRequest $stockRequest)
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $stocks = Stock::all();
        return view('stock-requests.edit', compact('stockRequest', 'stocks'));
    }

    public function update(Request $request, StockRequest $stockRequest)
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending_hod,pending_manager,approved,rejected',
        ]);

        $stockRequest->update($validated);

        return redirect()->route('stock-requests.index')->with('success', 'Stock request updated successfully.');
    }

    public function destroy(StockRequest $stockRequest)
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $stockRequest->delete();

        return redirect()->route('stock-requests.index')->with('success', 'Stock request deleted successfully.');
    }
}
