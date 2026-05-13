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
        $type = $request->get('type', 'system-overview');

        if ($type === 'low-stock') {
            $data = Stock::where('quantity', '<', 10)->get();
        } elseif ($type === 'department') {
            $data = StockRequest::with('department')
                                ->selectRaw('department_id, count(*) as total_requests, sum(quantity) as total_items')
                                ->groupBy('department_id')
                                ->get();
        } else {
            // system-overview
            $data = [
                'total_items' => Stock::count(),
                'total_quantity' => Stock::sum('quantity'),
                'pending_requests' => StockRequest::where('status', 'pending')->count(),
                'approved_requests' => StockRequest::where('status', 'approved')->count(),
                'rejected_requests' => StockRequest::where('status', 'rejected')->count(),
            ];
        }

        return view('reports.index', compact('data', 'type'));
    }
}
