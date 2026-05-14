<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Inventory Reports') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-purple-600 transition font-bold">Dashboard</a>
                <span>/</span>
                <span class="font-semibold text-gray-800">Reports</span>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            nav, .no-print, .report-sidebar, .filters-section { display: none !important; }
            body { background-color: white !important; }
            .shadow-sm, .shadow-xl { box-shadow: none !important; }
            .main-content { width: 100% !important; max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
            .print-only { display: block !important; }
        }
        .print-only { display: none; }
    </style>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Sidebar Navigation -->
            <div class="w-full md:w-64 flex-shrink-0 report-sidebar">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sticky top-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 px-2">Report Types</h3>
                    <nav class="space-y-1">
                        <a href="{{ route('reports.index', ['type' => 'system-overview']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'system-overview' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'system-overview' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            System Overview
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'stock-availability']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'stock-availability' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'stock-availability' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            Stock Availability
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'low-stock']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'low-stock' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'low-stock' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Low Stock Items
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'department']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'department' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'department' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Department Requests
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'request-status']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'request-status' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'request-status' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Request Statuses
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'summary']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'summary' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'summary' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Daily/Monthly Summary
                        </a>
                        <a href="{{ route('reports.index', ['type' => 'movements']) }}" class="flex items-center px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ $type === 'movements' ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3 {{ $type === 'movements' ? 'text-purple-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            Stock Movements
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 main-content space-y-6">
                
                <div class="print-only text-center mb-8">
                    <h1 class="text-3xl font-bold">Inventory System Report</h1>
                    <p class="text-gray-500">Generated on {{ now()->format('F j, Y, g:i A') }}</p>
                </div>

                <!-- Filters Section -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 filters-section">
                    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                        <input type="hidden" name="type" value="{{ $type }}">
                        
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Department</label>
                            <select name="department_id" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-xl text-sm font-bold shadow-sm hover:bg-gray-900 transition-all">
                                Filter
                            </button>
                            <a href="{{ route('reports.index', ['type' => $type]) }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Report Title & Export -->
                <div class="flex items-center justify-between no-print">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                            @if($type === 'system-overview') System Overview
                            @elseif($type === 'stock-availability') Current Stock Availability
                            @elseif($type === 'low-stock') Low Stock Items Analysis
                            @elseif($type === 'department') Department-wise Requests
                            @elseif($type === 'request-status') Approved & Rejected Requests
                            @elseif($type === 'summary') Daily/Monthly Summary
                            @elseif($type === 'movements') Stock Movement History
                            @endif
                        </h2>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold shadow-sm hover:bg-gray-50 transition-all flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print
                        </button>
                        
                        @if($type !== 'system-overview')
                            <form action="{{ route('reports.index') }}" method="GET" class="inline">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                <input type="hidden" name="department_id" value="{{ request('department_id') }}">
                                <input type="hidden" name="export" value="csv">
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-bold shadow-sm hover:bg-purple-700 transition-all flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Export CSV
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Report Data Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    
                    @if($type === 'system-overview')
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100/50 rounded-xl p-6 border border-indigo-100">
                                <h4 class="text-indigo-800 font-bold mb-4 uppercase text-xs tracking-widest flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Inventory Scope
                                </h4>
                                <div class="space-y-3">
                                    <div class="bg-white/60 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Unique Items</span>
                                        <span class="text-xl font-extrabold text-gray-900">{{ number_format($data['total_items']) }}</span>
                                    </div>
                                    <div class="bg-white/60 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Total Stock Qty</span>
                                        <span class="text-xl font-extrabold text-indigo-700">{{ number_format($data['total_quantity']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl p-6 border border-emerald-100">
                                <h4 class="text-emerald-800 font-bold mb-4 uppercase text-xs tracking-widest flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Approvals
                                </h4>
                                <div class="space-y-3">
                                    <div class="bg-white/60 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Pending</span>
                                        <span class="text-xl font-extrabold text-amber-600">{{ number_format($data['pending_requests']) }}</span>
                                    </div>
                                    <div class="bg-white/60 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-xs font-bold text-gray-500 uppercase">Approved</span>
                                        <span class="text-xl font-extrabold text-emerald-700">{{ number_format($data['approved_requests']) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-6 border border-red-100">
                                <h4 class="text-red-800 font-bold mb-4 uppercase text-xs tracking-widest flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Rejections
                                </h4>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg flex justify-between items-center">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Total Rejected</span>
                                    <span class="text-3xl font-extrabold text-red-600">{{ number_format($data['rejected_requests']) }}</span>
                                </div>
                            </div>
                        </div>

                    @elseif($type === 'stock-availability' || $type === 'low-stock')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Item Name</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">SKU</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Available Qty</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $stock)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $stock->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $stock->sku ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-extrabold {{ $stock->quantity < 10 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $stock->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $stock->updated_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">No records found for the selected criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $data->appends(request()->query())->links() }}
                        </div>

                    @elseif($type === 'department')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Department</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Total Requests</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Total Items Requested</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $row)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $row->department->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-lg font-bold text-gray-700">{{ $row->total_requests }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-lg font-extrabold text-indigo-600">{{ $row->total_items }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">No records found for the selected criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @elseif($type === 'request-status')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Item</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Department</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Qty</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $req)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $req->updated_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $req->stock->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $req->department->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center font-bold">{{ $req->quantity }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-bold rounded-md {{ $req->status == 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No records found for the selected criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $data->appends(request()->query())->links() }}
                        </div>

                    @elseif($type === 'summary')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Date</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Total Requests</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Requested Volume</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Approved Volume</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $row)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-700">{{ $row->total_requests }}</td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-700">{{ $row->total_quantity }}</td>
                                        <td class="px-6 py-4 text-center font-extrabold text-emerald-600">{{ $row->approved_qty }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">No records found for the selected criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @elseif($type === 'movements')
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Date / Time</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Item Moved</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Moved To (Dept)</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Requested By</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Qty Out</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $move)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $move->updated_at->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $move->stock->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $move->department->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $move->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                                -{{ $move->quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">No records found for the selected criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            {{ $data->appends(request()->query())->links() }}
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
