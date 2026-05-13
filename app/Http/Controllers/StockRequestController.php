<?php

namespace App\Http\Controllers;

use App\Models\StockRequest;
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
}
