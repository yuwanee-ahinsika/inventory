<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'low-stock');

        if ($type === 'low-stock') {
            $data = Stock::where('quantity', '<', 10)->get();
        } else {
            $data = StockRequest::with('department')
                                ->selectRaw('department_id, count(*) as total_requests, sum(quantity) as total_items')
                                ->groupBy('department_id')
                                ->get();
        }

        return view('reports.index', compact('data', 'type'));
    }
}
