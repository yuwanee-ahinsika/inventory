<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->has('department_id')) {
            $departmentId = $request->input('department_id');
            $query->whereHas('requests', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId)
                  ->where('status', 'approved');
            });
        }

        if ($request->has('stock_id')) {
            $query->where('id', $request->input('stock_id'));
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'sku' => 'nullable|string|unique:stocks',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $stock = Stock::create($validated);
        return response()->json($stock, 201);
    }

    public function show(Stock $stock)
    {
        return response()->json($stock);
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'sku' => 'sometimes|nullable|string|unique:stocks,sku,' . $stock->id,
            'description' => 'sometimes|nullable|string',
            'quantity' => 'sometimes|integer|min:0',
        ]);

        $stock->update($validated);
        return response()->json($stock);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(null, 204);
    }
}
