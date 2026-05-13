<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Inventory Stocks') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
                <span>/</span>
                <span class="font-semibold text-gray-800">Stocks</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-50 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Active</span>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Total Items</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_items'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Total Qty</span>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Stock Volume</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_quantity'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-50 rounded-xl">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">Warning</span>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Low Stock</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['low_stock'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">Critical</span>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Out of Stock</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['out_of_stock'] ?? 0) }}</div>
                </div>
            </div>

            <!-- Actions & Search -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between space-y-4 md:space-y-0">
                    <div class="flex-1 max-w-lg">
                        <form action="{{ route('stocks.index') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all" 
                                placeholder="Search by item name or SKU...">
                        </form>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <form action="{{ route('stocks.index') }}" method="GET" id="filterForm">
                                <select name="filter" onchange="document.getElementById('filterForm').submit()" 
                                    class="block w-full pl-3 pr-10 py-3 text-sm border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-xl bg-gray-50 transition-all">
                                    <option value="">All Inventory</option>
                                    <option value="low-stock" {{ request('filter') === 'low-stock' ? 'selected' : '' }}>Low Stock Items</option>
                                </select>
                            </form>
                        </div>
                        @if(in_array(auth()->user()->role->name ?? '', ['Admin', 'Inventory Manager']))
                            <a href="{{ route('stocks.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add New Item
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Item Details</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">SKU</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Current Stock</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($stocks as $stock)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold">
                                                {{ substr($stock->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $stock->name }}</div>
                                                <div class="text-xs text-gray-500">ID: #{{ str_pad($stock->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">{{ $stock->sku ?? 'NO SKU' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-extrabold text-gray-900">{{ number_format($stock->quantity) }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium">Units available</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($stock->quantity == 0)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                Out of Stock
                                            </span>
                                        @elseif($stock->quantity < 10)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                                Low Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                In Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            @if(in_array(auth()->user()->role->name ?? '', ['Admin', 'Inventory Manager']))
                                                <a href="{{ route('stocks.edit', $stock) }}" class="text-indigo-600 hover:text-indigo-900 font-bold transition">Edit</a>
                                                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" onsubmit="return confirm('Permanently delete this item?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition">Delete</button>
                                                </form>
                                            @endif
                                            
                                            @if($stock->quantity > 0)
                                                <a href="{{ route('stock-requests.create', ['stock_id' => $stock->id]) }}" class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition font-bold text-xs">
                                                    Request
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-900">No inventory found</h3>
                                            <p class="text-gray-500 text-sm max-w-xs mt-1">We couldn't find any stock items matching your criteria. Try adjusting your search.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($stocks->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $stocks->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
