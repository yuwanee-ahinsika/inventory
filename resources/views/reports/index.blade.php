<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Reports') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            nav, .no-print { display: none !important; }
            body { background-color: white !important; }
            .shadow-sm { box-shadow: none !important; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl mb-8 border border-gray-100 no-print">
                <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-indigo-50 to-white">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">Inventory Reports</h3>
                        <p class="text-gray-500 font-medium text-sm">Analyze stock levels, department requests, and overall system metrics.</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-3 w-full md:w-auto">
                        <div class="flex bg-gray-100 p-1 rounded-lg space-x-1">
                            <a href="{{ route('reports.index', ['type' => 'system-overview']) }}" class="px-4 py-2 rounded-md text-sm font-semibold transition-all duration-200 {{ $type === 'system-overview' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Overview</a>
                            <a href="{{ route('reports.index', ['type' => 'low-stock']) }}" class="px-4 py-2 rounded-md text-sm font-semibold transition-all duration-200 {{ $type === 'low-stock' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Low Stock</a>
                            <a href="{{ route('reports.index', ['type' => 'department']) }}" class="px-4 py-2 rounded-md text-sm font-semibold transition-all duration-200 {{ $type === 'department' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Departments</a>
                        </div>
                        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center text-sm w-full md:w-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Report
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-8">
                <div class="p-8 text-gray-900">
                    <div class="mb-8 border-b border-gray-100 pb-6 flex justify-between items-end">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                @if($type === 'system-overview') System Overview Report
                                @elseif($type === 'low-stock') Low Stock Analysis Report
                                @else Department Request Summary Report
                                @endif
                            </h2>
                            <p class="text-sm font-medium text-gray-500 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Generated on {{ now()->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>

                    @if($type === 'system-overview')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100/50 rounded-xl p-6 border border-indigo-100 shadow-sm hover:shadow-md transition-shadow">
                                <h4 class="text-indigo-800 font-bold mb-4 uppercase text-xs tracking-[0.15em] flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Inventory Metrics
                                </h4>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Unique Items</p>
                                    <p class="text-3xl font-extrabold text-gray-900">{{ number_format($data['total_items']) }}</p>
                                </div>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Quantity In Stock</p>
                                    <p class="text-3xl font-extrabold text-indigo-700">{{ number_format($data['total_quantity']) }}</p>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-6 border border-green-100 shadow-sm hover:shadow-md transition-shadow">
                                <h4 class="text-green-800 font-bold mb-4 uppercase text-xs tracking-[0.15em] flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Active Approvals
                                </h4>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg border border-green-100/50">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Pending Requests</p>
                                    <p class="text-3xl font-extrabold text-gray-900">{{ number_format($data['pending_requests']) }}</p>
                                </div>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg border border-green-100/50">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Approved</p>
                                    <p class="text-3xl font-extrabold text-green-700">{{ number_format($data['approved_requests']) }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-6 border border-red-100 shadow-sm hover:shadow-md transition-shadow">
                                <h4 class="text-red-800 font-bold mb-4 uppercase text-xs tracking-[0.15em] flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Rejected Requests
                                </h4>
                                <div class="mt-4 bg-white/60 p-4 rounded-lg border border-red-100/50">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Total Rejected</p>
                                    <p class="text-3xl font-extrabold text-red-600">{{ number_format($data['rejected_requests']) }}</p>
                                </div>
                            </div>
                        </div>

                    @elseif($type === 'low-stock')
                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/80 border-b border-gray-100">
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Item Name</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">SKU</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Available Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $stock)
                                    <tr class="hover:bg-red-50/30 transition-colors duration-150">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $stock->name }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-600">{{ $stock->sku ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-extrabold bg-red-100 text-red-700">
                                                {{ $stock->quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="mt-4 text-sm text-gray-500 font-medium">All stock levels are healthy.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/80 border-b border-gray-100">
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Department</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Total Requests</th>
                                        <th class="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Total Items Requested</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($data as $row)
                                    <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $row->department->name }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-indigo-50 text-indigo-700">
                                                {{ $row->total_requests }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="text-lg font-extrabold text-gray-900">{{ $row->total_items }}</div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="mt-4 text-sm text-gray-500 font-medium">No request data found for any department.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
