<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- User Information Banner -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl mb-8 border border-gray-100">
                <div class="p-8 flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-indigo-50 to-white">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4 shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h3>
                            <p class="text-gray-600">Logged in as <span class="font-semibold text-indigo-600">{{ $roleName }}</span> @if($user->department) in <span class="font-semibold text-gray-800">{{ $user->department->name }}</span> @endif</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 font-medium">Last Login</div>
                        <div class="text-lg font-bold text-gray-800">{{ now()->format('M d, Y - h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Role-Specific Stats Grid -->
            @if(isset($stats) && count($stats) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($stats as $key => $value)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">
                            {{ str_replace('_', ' ', $key) }}
                        </div>
                        <div class="p-2 bg-indigo-50 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        {{ $value }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Recent Activity / Requests -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $roleName === 'Department User' ? 'My Recent Requests' : 'Recent System Activity' }}
                    </h3>
                    <a href="{{ route('stock-requests.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Item</th>
                                @if($roleName !== 'Department User')
                                    <th class="px-6 py-4">Requested By</th>
                                @endif
                                <th class="px-6 py-4">Qty</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentRequests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $request->stock->name }}</td>
                                @if($roleName !== 'Department User')
                                    <td class="px-6 py-4">{{ $request->user->name }} ({{ $request->department->name }})</td>
                                @endif
                                <td class="px-6 py-4">{{ $request->quantity }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $request->status === 'approved' ? 'bg-green-100 text-green-700' : ($request->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ strtoupper($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $request->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">No recent activity found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
