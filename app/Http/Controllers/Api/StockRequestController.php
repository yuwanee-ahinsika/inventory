<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = StockRequest::with(['user', 'department', 'stock']);

        if ($request->has('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user = $request->user();
        if ($user) {
            $validated['user_id'] = $user->id;
        } else {
            // Fallback for API if no user is authenticated (though sanctum should enforce this)
            $validated['user_id'] = 1; 
        }

        $stockRequest = StockRequest::create($validated);
        return response()->json($stockRequest, 201);
    }

    public function show(StockRequest $stockRequest)
    {
        return response()->json($stockRequest->load(['user', 'department', 'stock']));
    }

    public function update(Request $request, StockRequest $stockRequest)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,approved,rejected',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $stockRequest->update($validated);
        return response()->json($stockRequest);
    }

    public function destroy(StockRequest $stockRequest)
    {
        $stockRequest->delete();
        return response()->json(['message' => 'Stock request deleted successfully']);
    }
}
