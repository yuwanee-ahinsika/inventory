<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Stocks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between items-center">
                <form action="{{ route('stocks.index') }}" method="GET" class="flex space-x-2">
                    <input type="text" name="search" placeholder="Search by Name or SKU..." value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded shadow">Search</button>
                </form>
                <a href="{{ route('stocks.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">Add Stock Item</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-3 font-semibold text-gray-600">ID</th>
                                <th class="p-3 font-semibold text-gray-600">SKU</th>
                                <th class="p-3 font-semibold text-gray-600">Name</th>
                                <th class="p-3 font-semibold text-gray-600">Quantity</th>
                                <th class="p-3 font-semibold text-gray-600 w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3">{{ $stock->id }}</td>
                                <td class="p-3">{{ $stock->sku ?? 'N/A' }}</td>
                                <td class="p-3">{{ $stock->name }}</td>
                                <td class="p-3">
                                    <span class="{{ $stock->quantity < 10 ? 'text-red-600 font-bold' : '' }}">{{ $stock->quantity }}</span>
                                </td>
                                <td class="p-3 flex space-x-3 text-sm">
                                    <a href="{{ route('stocks.edit', $stock) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                    <form action="{{ route('stocks.destroy', $stock) }}" method="POST" onsubmit="return confirm('Delete this stock item?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">No stock items found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $stocks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
