<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Stock Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('stock-requests.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="stock_id" class="block text-sm font-medium text-gray-700">Select Item *</label>
                            <select name="stock_id" id="stock_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select an Item</option>
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->id }}" {{ old('stock_id') == $stock->id ? 'selected' : '' }}>
                                        {{ $stock->name }} (Available: {{ $stock->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('stock_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Requested Quantity *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('stock-requests.index') }}" class="text-gray-600 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
