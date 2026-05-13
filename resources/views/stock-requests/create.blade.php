<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('New Stock Request') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('stock-requests.index') }}" class="hover:text-indigo-600 transition font-bold">Requests</a>
                <span>/</span>
                <span class="font-semibold text-gray-800">New</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900">Request Details</h3>
                        <p class="text-sm text-gray-500">Select an item and specify the quantity you need for your department.</p>
                    </div>

                    <form action="{{ route('stock-requests.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="stock_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Inventory Item *</label>
                            <select name="stock_id" id="stock_id" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                                <option value="">Select an item...</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{ (old('stock_id') == $stock->id || (isset($selectedStockId) && $selectedStockId == $stock->id)) ? 'selected' : '' }}>
                                        {{ $stock->name }} (Available: {{ $stock->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('stock_id')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="quantity" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Requested Quantity *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1"
                                   class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm"
                                   placeholder="Enter amount needed...">
                            @error('quantity')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-indigo-700 leading-5">
                                        Your request will be submitted to the Inventory Manager for approval. You will be notified once the status changes.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('stock-requests.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
