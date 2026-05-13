<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                <a href="{{ route('departments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">Add Department</a>
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
                                <th class="p-3 font-semibold text-gray-600">Name</th>
                                <th class="p-3 font-semibold text-gray-600 w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3">{{ $department->id }}</td>
                                <td class="p-3">{{ $department->name }}</td>
                                <td class="p-3 flex space-x-3 text-sm">
                                    <a href="{{ route('departments.edit', $department) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                    <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Delete this department?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">No departments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
