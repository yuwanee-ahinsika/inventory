<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Stock Requests') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
                <span>/</span>
                <span class="font-semibold text-gray-800">Requests</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 rounded-xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002 2h-10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Total Requests</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ number_format($stats['total_requests'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 rounded-xl">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Pending</div>
                    <div class="text-3xl font-extrabold text-gray-900 text-amber-600">{{ number_format($stats['pending'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-50 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Approved</div>
                    <div class="text-3xl font-extrabold text-gray-900 text-emerald-600">{{ number_format($stats['approved'] ?? 0) }}</div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transform transition hover:scale-[1.02] duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Rejected</div>
                    <div class="text-3xl font-extrabold text-gray-900 text-red-600">{{ number_format($stats['rejected'] ?? 0) }}</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center bg-gray-100 p-1 rounded-xl">
                    <a href="{{ route('stock-requests.index') }}" class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ !request('status') ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-800' }}">All</a>
                    <a href="{{ route('stock-requests.index', ['status' => 'pending']) }}" class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ request('status') === 'pending' ? 'bg-white shadow-sm text-amber-600' : 'text-gray-500 hover:text-gray-800' }}">Pending</a>
                    <a href="{{ route('stock-requests.index', ['status' => 'approved']) }}" class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ request('status') === 'approved' ? 'bg-white shadow-sm text-emerald-600' : 'text-gray-500 hover:text-gray-800' }}">Approved</a>
                    <a href="{{ route('stock-requests.index', ['status' => 'rejected']) }}" class="px-5 py-2 rounded-lg text-sm font-bold transition-all {{ request('status') === 'rejected' ? 'bg-white shadow-sm text-red-600' : 'text-gray-500 hover:text-gray-800' }}">Rejected</a>
                </div>
                
                <a href="{{ route('stock-requests.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    New Request
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl mb-8 flex items-center shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Table Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Requested Item</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Requester</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Qty</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($requests as $request)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold">
                                                {{ substr($request->stock->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $request->stock->name }}</div>
                                                <div class="text-xs text-gray-400">Req #{{ $request->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="font-bold text-gray-800">{{ $request->user->name }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase tracking-wider">{{ $request->department->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-lg font-extrabold text-gray-900">{{ $request->quantity }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($request->status === 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-widest border border-emerald-200">
                                                Approved
                                            </span>
                                        @elseif($request->status === 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-widest border border-red-200">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest border border-amber-200 animate-pulse">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($request->status === 'pending' && in_array($roleName, ['Admin', 'Inventory Manager']))
                                            <div class="flex items-center justify-end space-x-2">
                                                <form action="{{ route('stock-requests.approve', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 transition shadow-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('stock-requests.reject', $request) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-bold hover:bg-red-700 transition shadow-sm">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="font-bold text-lg text-gray-700">No requests found</p>
                                            <p class="text-sm text-gray-500">There are currently no stock requests in this category.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
