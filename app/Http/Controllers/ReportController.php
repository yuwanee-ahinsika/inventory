<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'system-overview');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $departmentId = $request->get('department_id');

        $departments = Department::all();

        if ($type === 'stock-availability') {
            $query = Stock::query();
            if ($startDate) $query->whereDate('created_at', '>=', $startDate);
            if ($endDate) $query->whereDate('created_at', '<=', $endDate);
            $data = $query->paginate(20);
        } elseif ($type === 'low-stock') {
            $data = Stock::where('quantity', '<', 10)->paginate(20);
        } elseif ($type === 'department') {
            $query = StockRequest::with('department')
                                ->selectRaw('department_id, count(*) as total_requests, sum(quantity) as total_items');
            if ($startDate) $query->whereDate('created_at', '>=', $startDate);
            if ($endDate) $query->whereDate('created_at', '<=', $endDate);
            if ($departmentId) $query->where('department_id', $departmentId);
            $data = $query->groupBy('department_id')->get();
        } elseif ($type === 'request-status') {
            $query = StockRequest::with(['user', 'department', 'stock', 'processor'])
                                ->whereIn('status', ['approved', 'rejected']);
            if ($startDate) $query->whereDate('updated_at', '>=', $startDate);
            if ($endDate) $query->whereDate('updated_at', '<=', $endDate);
            if ($departmentId) $query->where('department_id', $departmentId);
            $data = $query->latest('updated_at')->paginate(20);
        } elseif ($type === 'summary') {
            $query = StockRequest::selectRaw('DATE(created_at) as date, count(*) as total_requests, sum(quantity) as total_quantity, sum(case when status = "approved" then quantity else 0 end) as approved_qty')
                ->groupBy('date')
                ->orderBy('date', 'desc');
            if ($startDate) $query->whereDate('created_at', '>=', $startDate);
            if ($endDate) $query->whereDate('created_at', '<=', $endDate);
            if ($departmentId) $query->where('department_id', $departmentId);
            $data = $query->get();
        } elseif ($type === 'movements') {
            $query = StockRequest::with(['stock', 'department', 'user'])
                ->where('status', 'approved');
            if ($startDate) $query->whereDate('updated_at', '>=', $startDate);
            if ($endDate) $query->whereDate('updated_at', '<=', $endDate);
            if ($departmentId) $query->where('department_id', $departmentId);
            $data = $query->latest('updated_at')->paginate(20);
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

        if ($request->has('export') && $request->export == 'csv' && $type !== 'system-overview') {
            return $this->exportCsv($data, $type);
        }

        return view('reports.index', compact('data', 'type', 'departments'));
    }

    private function exportCsv($data, $type)
    {
        $filename = "report_{$type}_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($data, $type) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'stock-availability' || $type === 'low-stock') {
                fputcsv($file, ['ID', 'SKU', 'Item Name', 'Description', 'Quantity', 'Created At', 'Last Updated']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id, $row->sku, $row->name, $row->description, $row->quantity, $row->created_at, $row->updated_at]);
                }
            } elseif ($type === 'department') {
                fputcsv($file, ['Department', 'Total Requests', 'Total Items Requested']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->department->name ?? 'Unknown', $row->total_requests, $row->total_items]);
                }
            } elseif ($type === 'request-status') {
                fputcsv($file, ['Request ID', 'Item', 'Requested By', 'Department', 'Quantity', 'Status', 'Processed By', 'Date']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id, $row->stock->name ?? '', $row->user->name ?? '', $row->department->name ?? '', $row->quantity, $row->status, $row->processor->name ?? 'N/A', $row->updated_at]);
                }
            } elseif ($type === 'summary') {
                fputcsv($file, ['Date', 'Total Requests', 'Total Qty Requested', 'Approved Qty']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->date, $row->total_requests, $row->total_quantity, $row->approved_qty]);
                }
            } elseif ($type === 'movements') {
                fputcsv($file, ['Date', 'Item', 'Department', 'Requester', 'Qty Moved Out']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->updated_at, $row->stock->name ?? '', $row->department->name ?? '', $row->user->name ?? '', $row->quantity]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
