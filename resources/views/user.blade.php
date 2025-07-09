<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('User') }}
            </h2>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ now()->format('F d, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Section with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 200)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">User Record</h3>
                        <a href="{{ route('userForm') }}" class="bg-black text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-800 text-center w-full sm:w-auto transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Add User
                        </a>
                    </div>

                    <!-- Filter Section with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 400)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="mb-6">
                        <form id="filterForm" method="GET" action="{{ route('user') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-3">
                            <div class="relative flex-grow">
                                <select
                                    name="department_filter"
                                    onchange="document.getElementById('filterForm').submit();"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                                >
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->name }}" {{ request('department_filter') == $department->name ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Table Layout with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 600)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">#</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Email</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Department</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Role</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Position</th>
                                    <th class="px-6 py-4 text-sm font-semibold text-gray-600 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $user->department->name ?? 'No Department' }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $user->role }}</td>
                                        <td class="px-6 py-4 text-left text-sm text-gray-600">{{ $user->position }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 text-center">
                                            <div class="flex justify-center space-x-3">
                                                @if(auth()->user()->position === 'Admin System')
                                                <form action="{{ route('users.impersonate', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                            Login as User
                                                        </span>
                                                    </button>
                                                </form>
                                                @endif
                                                <a href="{{ route('users.edit', $user->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                        Edit
                                                    </span>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                            Delete
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Display with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 800)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="block md:hidden">
                        @forelse ($users as $index => $user)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                                <div class="text-sm font-medium text-gray-800">
                                    {{ $index + 1 }}. {{ $user->name }}
                                </div>
                                <button @click="open = !open"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-300 focus:outline-none flex items-center gap-1">
                                    <span x-show="!open">View</span>
                                    <span x-show="open">Hide</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Detail section -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="px-6 py-4 text-sm text-gray-700 bg-white border-t border-gray-200">
                                <div class="space-y-2">
                                    <div><strong>Email:</strong> {{ $user->email }}</div>
                                    <div><strong>Department:</strong> {{ $user->department->name ?? 'No Department' }}</div>
                                    <div><strong>Role:</strong> {{ $user->role }}</div>
                                    <div><strong>Position:</strong> {{ $user->position }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="text-gray-500 text-sm text-center">
                                No users found.
                            </div>
                        @endforelse
                    </div>
                        
                    @if (session('success'))
                        <div 
                            x-data="{ show: true }" 
                            x-show="show" 
                            x-init="setTimeout(() => show = false, 3000)" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-8 py-4 rounded-lg shadow-xl z-50"
                        >
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>