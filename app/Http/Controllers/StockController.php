<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Debugging to see if this controller is actually reached
        // echo "DEBUG: Reached Web\StockController@index"; 
        
        $query = Stock::query();
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->get('filter') === 'low-stock') {
            $query->where('quantity', '<', 10);
        }

        $stocks = $query->paginate(10);
        
        $stats = [
            'total_items' => Stock::count(),
            'total_quantity' => Stock::sum('quantity'),
            'low_stock' => Stock::where('quantity', '<', 10)->count(),
            'out_of_stock' => Stock::where('quantity', 0)->count(),
        ];

        return view('stocks.index', compact('stocks', 'stats'));
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
