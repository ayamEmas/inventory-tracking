<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">User Record</h3>
                        <a href="{{ route('userForm') }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                            Add User
                        </a>
                    </div>

                    <div class="mb-4">
                        <form id="filterForm" method="GET" action="{{ route('user') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-2">
                            <select
                                name="department_filter"
                                onchange="document.getElementById('filterForm').submit();"
                                class="border border-gray-300 rounded-md px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}" {{ request('department_filter') == $department->name ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Table Layout -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Position</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $index + 1 }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->name }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->email }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->department->name ?? 'No Department' }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->role }}</th>
                                        <th class="w-1/10 px-4 py-2 text-sm text-gray-600 text-center hover:">
                                            <a href="{{ route('users.edit', $user->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-200 group relative">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                    Edit
                                                </span>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block transform hover:-translate-y-1 transition-transform duration-200 group relative" onclick="return confirm('Are you sure you want to delete this item?')">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                        Delete
                                                    </span>
                                                </button>
                                            </form>
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-sm text-gray-500 text-center">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                        
                    @if (session('success'))
                        <div 
                            x-data="{ show: true }" 
                            x-show="show" 
                            x-init="setTimeout(() => show = false, 3000)" 
                            class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50"
                        >
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>