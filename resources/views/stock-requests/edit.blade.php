<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Stock Request') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('stock-requests.index') }}" class="hover:text-indigo-600 transition font-bold">Requests</a>
                <span>/</span>
                <span class="font-semibold text-gray-800">Edit</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900">Edit Request #{{ $stockRequest->id }}</h3>
                        <p class="text-sm text-gray-500">Update request details, quantity, or current workflow status.</p>
                    </div>

                    <form action="{{ route('stock-requests.update', $stockRequest) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="stock_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Inventory Item *</label>
                            <select name="stock_id" id="stock_id" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{ old('stock_id', $stockRequest->stock_id) == $stock->id ? 'selected' : '' }}>
                                        {{ $stock->name }} (Available: {{ $stock->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('stock_id')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="quantity" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Requested Quantity *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $stockRequest->quantity) }}" required min="1"
                                   class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                            @error('quantity')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Status *</label>
                            <select name="status" id="status" required
                                    class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                                <option value="pending_hod" {{ old('status', $stockRequest->status) === 'pending_hod' ? 'selected' : '' }}>Pending HOD</option>
                                <option value="pending_manager" {{ old('status', $stockRequest->status) === 'pending_manager' ? 'selected' : '' }}>Pending Manager</option>
                                <option value="approved" {{ old('status', $stockRequest->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $stockRequest->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('stock-requests.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                Update Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
