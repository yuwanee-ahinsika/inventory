<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Stock Item') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('stocks.index') }}" class="hover:text-indigo-600 transition font-bold">Stocks</a>
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
                        <h3 class="text-xl font-bold text-gray-900">Update Item: {{ $stock->name }}</h3>
                        <p class="text-sm text-gray-500">Modify the inventory details for this specific stock item.</p>
                    </div>

                    <form action="{{ route('stocks.update', $stock) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Item Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $stock->name) }}" required
                                   class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                            @error('name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sku" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">SKU / Code</label>
                                <input type="text" name="sku" id="sku" value="{{ old('sku', $stock->sku) }}"
                                       class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                                @error('sku')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="quantity" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Quantity in Stock *</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $stock->quantity) }}" required min="0"
                                       class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">
                                @error('quantity')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Detailed Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="block w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all sm:text-sm">{{ old('description', $stock->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('stocks.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
