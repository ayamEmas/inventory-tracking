<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Record Inventory Disposal') }}
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
                        <h3 class="text-xl font-semibold text-gray-800">Record Inventory Disposal</h3>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('info.disposal') }}" class="bg-blue-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-blue-700 text-center transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Disposal Information
                            </a>
                            <a href="{{ route('pelupusan') }}" class="bg-red-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-red-700 text-center transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Disposal Form
                            </a>
                            <a href="{{ route('inventory') }}" class="bg-gray-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 text-center transition-all duration-500 hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Inventory
                            </a>
                        </div>
                    </div>

                    <!-- Filter Section with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 400)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="mb-6">
                        <form id="filterForm" method="GET" action="{{ route('inventories.deleted') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-3">
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
                                    placeholder="Filter by ID Tag"
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
                         class="hidden md:block">
                        
                        @php
                            // Group deleted items by department
                            $groupedItems = $deletedItems->groupBy('department.name');
                            
                            // Separate "None" department items
                            $noDepartmentItems = $groupedItems->pull('None');
                            
                            // Sort remaining departments alphabetically
                            $groupedItems = $groupedItems->sortKeys();
                            
                            // Add "None" back at the end if it exists
                            if ($noDepartmentItems) {
                                $groupedItems->put('None', $noDepartmentItems);
                            }
                        @endphp

                        @foreach($groupedItems as $departmentName => $departmentItems)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 px-4">{{ $departmentName }}</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full table-fixed divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="w-[5%] px-6 py-4 text-left text-sm font-semibold text-gray-600">#</th>
                                                <th class="w-[20%] px-6 py-4 text-left text-sm font-semibold text-gray-600">ID Tag</th>
                                                <th class="w-[15%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Date</th>
                                                <th class="w-[30%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Item</th>
                                                <th class="w-[15%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Deleted At</th>
                                                <th class="w-[15%] px-6 py-4 text-sm font-semibold text-gray-600 text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @forelse ($departmentItems as $index => $item)
                                            <tr class="hover:bg-gray-50 transition-colors duration-300">
                                                <td class="w-[5%] px-6 py-4 text-left text-sm text-gray-600">{{ $index + 1 }}</td>
                                                <td class="w-[20%] px-6 py-4 text-left text-sm text-gray-600 truncate" title="{{ $item->id_tag }}">{{ $item->id_tag }}</td>
                                                <td class="w-[15%] px-6 py-4 text-left text-sm text-gray-600">{{ $item->date->format('M d, Y') }}</td>
                                                <td class="w-[30%] px-6 py-4 text-left text-sm text-gray-600 truncate" title="{{ $item->item }}">{{ $item->item }}</td>
                                                <td class="w-[15%] px-6 py-4 text-left text-sm text-gray-600">{{ $item->deleted_at->format('M d, Y H:i') }}</td>
                                                <td class="w-[15%] px-6 py-4 text-sm text-gray-600 text-center">
                                                    <div class="flex justify-center space-x-3">
                                                        <a href="{{ route('inventories.download-deleted-pdf', $item->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                                Download PDF
                                                            </span>
                                                        </a>
                                                        <form action="{{ route('inventories.restore', $item->id) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <button type="submit" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative" onclick="return confirm('Are you sure you want to restore this item?')">
                                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                                </svg>
                                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                                    Restore Item
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                                    No deleted items found in this department.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Mobile Display with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 800)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="block md:hidden">
                        
                        @foreach($groupedItems as $departmentName => $departmentItems)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 px-4">{{ $departmentName }}</h3>
                                
                                @forelse ($departmentItems as $index => $item)
                                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 shadow-sm hover:shadow-md transition-all duration-300">
                                    <div class="flex justify-between items-center px-6 py-4 bg-gray-50">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $index + 1 }}. {{ $item->item }}
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
                                            <div><strong>ID Tag:</strong> {{ $item->id_tag }}</div>
                                            <div><strong>Date:</strong> {{ $item->date->format('M d, Y') }}</div>
                                            <div><strong>Deleted At:</strong> {{ $item->deleted_at->format('M d, Y H:i') }}</div>
                                            <div><strong>Description:</strong> {{ $item->description }}</div>
                                            <div class="flex justify-center mt-4 space-x-4">
                                                <a href="{{ route('inventories.download-deleted-pdf', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download PDF
                                                </a>
                                                <form action="{{ route('inventories.restore', $item->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300" onclick="return confirm('Are you sure you want to restore this item?')">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        Restore Item
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <div class="text-gray-500 text-sm text-center px-4">
                                        No deleted items found in this department.
                                    </div>
                                @endforelse
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 