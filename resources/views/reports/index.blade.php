<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex space-x-4">
                        <a href="{{ route('reports.index', ['type' => 'low-stock']) }}" class="px-4 py-2 rounded {{ $type === 'low-stock' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Low Stock Report</a>
                        <a href="{{ route('reports.index', ['type' => 'department']) }}" class="px-4 py-2 rounded {{ $type === 'department' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Department Request Summary</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($type === 'low-stock')
                        <h3 class="text-lg font-bold mb-4">Low Stock Items (Quantity < 10)</h3>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-semibold text-gray-600">Item Name</th>
                                    <th class="p-3 font-semibold text-gray-600">SKU</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Available Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $stock)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-3">{{ $stock->name }}</td>
                                    <td class="p-3">{{ $stock->sku ?? 'N/A' }}</td>
                                    <td class="p-3 text-center text-red-600 font-bold">{{ $stock->quantity }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">No low stock items found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <h3 class="text-lg font-bold mb-4">Department Request Summary</h3>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-semibold text-gray-600">Department</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Total Requests</th>
                                    <th class="p-3 font-semibold text-gray-600 text-center">Total Items Requested</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $row)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-3">{{ $row->department->name }}</td>
                                    <td class="p-3 text-center">{{ $row->total_requests }}</td>
                                    <td class="p-3 text-center">{{ $row->total_items }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">No request data found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
