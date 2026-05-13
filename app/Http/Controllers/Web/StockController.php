<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }
        $stocks = $query->paginate(10);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('stocks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:stocks',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        Stock::create($validated);
        return redirect()->route('stocks.index')->with('success', 'Stock item added successfully.');
    }

    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:stocks,sku,' . $stock->id,
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $stock->update($validated);
        return redirect()->route('stocks.index')->with('success', 'Stock item updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock item deleted successfully.');
    }
}
