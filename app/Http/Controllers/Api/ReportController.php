<?php

namespace App\Http\Controllers\Api;

use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function lowStock(Request $request)
    {
        $threshold = $request->input('threshold', 10);
        $stocks = Stock::where('quantity', '<=', $threshold)->get();
        return response()->json($stocks);
    }

    public function departmentRequests(Request $request)
    {
        $query = StockRequest::with(['department', 'stock', 'user']);
        
        if ($request->has('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }
        
        return response()->json($query->get());
    }
}
