<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Inventory') }}
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
                         class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
                        <h3 class="text-xl font-semibold text-gray-800">Record of the Inventory</h3>
                        <a href="{{ route('itemForm') }}" class="bg-black text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-800 text-center w-full sm:w-auto transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Items
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
                        <form id="filterForm" method="GET" action="{{ route('inventory') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-3">
                            <div class="relative flex-grow">
                                <input
                                    type="text"
                                    name="item_filter"
                                    value="{{ request('item_filter') }}"
                                    placeholder="Filter by item name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>
                            <div class="relative flex-grow">
                                <input
                                    type="text"
                                    name="id_tag_filter"
                                    value="{{ request('id_tag_filter') }}"
                                    placeholder="Filter by ID Tag (e.g. QHSB/HQ/FIN/25/COM/001)"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>
                            <button
                                type="submit"
                                class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 w-full sm:w-auto transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Filter
                            </button>
                            <select
                                name="department_filter"
                                onchange="document.getElementById('filterForm').submit();"
                                class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                            >
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}" {{ request('department_filter') == $department->name ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select
                                name="year_filter"
                                onchange="document.getElementById('filterForm').submit();"
                                class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                            >
                                <option value="">Years</option>
                                @for ($year = 2020; $year <= 2025; $year++)
                                    <option value="{{ $year }}" {{ request('year_filter') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </form>
                    </div>

                    <!-- PC Display with Animation -->
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
                                    <th class="w-1/10 px-6 py-4 text-left text-sm font-semibold text-gray-600">#</th>
                                    <th class="w-2/10 px-6 py-4 text-left text-sm font-semibold text-gray-600">ID Tag</th>
                                    <th class="w-2/10 px-6 py-4 text-left text-sm font-semibold text-gray-600">Date</th>
                                    <th class="w-3/10 px-6 py-4 text-left text-sm font-semibold text-gray-600">Item</th>
                                    <th class="w-2/10 px-6 py-4 text-left text-sm font-semibold text-gray-600">Department</th>
                                    <th class="w-1/10 px-6 py-4 text-sm font-semibold text-gray-600 text-center">Action</th> 
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($inventories as $index => $inventory)
                                <tr class="hover:bg-gray-50 transition-colors duration-300">
                                    <td class="w-1/10 px-6 py-4 text-left text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="w-2/10 px-6 py-4 text-left text-sm text-gray-600">{{ $inventory->id_tag }}</td>
                                    <td class="w-2/10 px-6 py-4 text-left text-sm text-gray-600">{{ $inventory->date }}</td>
                                    <td class="w-3/10 px-6 py-4 text-left text-sm text-gray-600">{{ $inventory->item }}</td>
                                    <td class="w-2/10 px-6 py-4 text-left text-sm text-gray-600">{{ $inventory->department->name ?? 'No Department' }}</td>
                                    <td class="w-1/10 px-6 py-4 text-sm text-gray-600 text-center">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                    Edit
                                                </span>
                                            </a>
                                            <!--<a href="{{ route('inventories.download-qr', $inventory->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                    Download QR
                                                </span>
                                            </a>-->
                                            <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative" onclick="return confirm('Are you sure you want to delete this item?')">
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
                                        No inventories found.
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
                        @forelse ($inventories as $index => $inventory)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                                <div class="text-sm font-medium text-gray-800">
                                    {{ $index + 1 }}. {{ $inventory->item }}
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
                                    <div class="flex items-center justify-center mb-4">
                                        {!! QrCode::size(100)->generate(route('inventories.edit', $inventory->id)) !!}
                                    </div>
                                    <div><strong>ID Tag:</strong> {{ $inventory->id_tag }}</div>
                                    <div><strong>Date:</strong> {{ $inventory->date }}</div>
                                    <div><strong>Item:</strong> {{ $inventory->item }}</div>
                                    <div><strong>Description:</strong> {{ $inventory->description }}</div>
                                    <div><strong>Department:</strong> {{ $inventory->department->name ?? 'No Department' }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="text-gray-500 text-sm text-center">
                                No inventories found.
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
