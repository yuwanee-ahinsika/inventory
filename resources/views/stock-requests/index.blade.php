<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('stock-requests.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">New Request</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->has('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ $errors->first('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-3 font-semibold text-gray-600">Stock Item</th>
                                <th class="p-3 font-semibold text-gray-600">Quantity</th>
                                <th class="p-3 font-semibold text-gray-600">Department</th>
                                <th class="p-3 font-semibold text-gray-600">User</th>
                                <th class="p-3 font-semibold text-gray-600">Status</th>
                                <th class="p-3 font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3">{{ $request->stock->name }}</td>
                                <td class="p-3">{{ $request->quantity }}</td>
                                <td class="p-3">{{ $request->department->name }}</td>
                                <td class="p-3">{{ $request->user->name }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : ($request->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    @if($request->status === 'pending' && in_array($roleName, ['Admin', 'Inventory Manager']))
                                        <div class="flex space-x-2">
                                            <form action="{{ route('stock-requests.approve', $request) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                            </form>
                                            <form action="{{ route('stock-requests.reject', $request) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Reject</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">No actions</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">No requests found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
