<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                        <h3 class="text-lg font-semibold">Record of the Inventory</h3>
                        <a href="{{ route('itemForm') }}" class="bg-black text-white text-sm px-4 py-2 rounded-md hover:bg-gray-800 text-center w-full sm:w-auto">
                            Add Items
                        </a>
                    </div>

                    <div class="mb-4">
                        <form id="filterForm" method="GET" action="{{ route('inventory') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-2">
                            <input
                                type="text"
                                name="item_filter"
                                value="{{ request('item_filter') }}"
                                placeholder="Filter by item name"
                                class="border border-gray-300 rounded-md px-3 py-2 w-full sm:w-auto focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                            <button
                                type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 w-full sm:w-auto"
                            >
                                Filter
                            </button>
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
                            <select
                                name="year_filter"
                                onchange="document.getElementById('filterForm').submit();"
                                class="border border-gray-300 rounded-md px-3 py-2 w-full sm:w-24 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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

                    <!-- Pc display -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="w-1/10 px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="w-2/10 px-4 py-2 text-left text-sm font-medium text-gray-600">Date</th>
                                    <th class="w-3/10 px-4 py-2 text-left text-sm font-medium text-gray-600">Item</th>
                                    <th class="w-2/10 px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th>
                                    <th class="w-1/10 px-4 py-2 text-left text-sm font-medium text-gray-600">Amount (RM)</th> 
                                    <th class="w-1/10 px-4 py-2 text-sm text-sm font-medium text-gray-600 text-center">Action</th> 
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inventories as $index => $inventory)
                                <tr>
                                    <td class="w-1/10 px-4 py-2 text-left text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="w-2/10 px-4 py-2 text-left text-sm text-gray-600">{{ $inventory->date }}</td>
                                    <td class="w-3/10 px-4 py-2 text-left text-sm text-gray-600">{{ $inventory->item }}</td>
                                    <td class="w-2/10 px-4 py-2 text-left text-sm text-gray-600">{{ $inventory->department->name ?? 'No Department' }}</td>
                                    <td class="w-1/10 px-4 py-2 text-left text-sm text-gray-600">{{ number_format($inventory->amount, 2) }}</td>
                                    <td class="w-1/10 px-4 py-2 text-sm text-gray-600 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-200 group relative">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                    Edit
                                                </span>
                                            </a>
                                            <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="inline">
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
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-2 text-sm text-gray-500 text-center">
                                        No inventories found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile display -->
                    <div class="block md:hidden">
                        @forelse ($inventories as $index => $inventory)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-mb mb-4 shadow-sm">
                            <div class="flex justify-between items-center px-4 py-3 bg-gray-50">
                                <div class="text-sm font-medium text-gray-800">
                                    {{ $index + 1 }}. {{ $inventory->item }}
                                </div>
                                <button @click="open = !open"
                                        class="text-sm text-indigo-600 hover:underline focus:outline-none">
                                    <span x-show="!open">View</span>
                                    <span x-show="open">Hide</span>
                                </button>
                            </div>

                            <!-- Detail section -->
                            <div x-show="open" x-transition class="px-4 py-3 text-sm text-gray-700 bg-white border-t border-gray-200">
                                <div><strong>Year:</strong> {{ $inventory->year }}</div>
                                <div><strong>Item:</strong> {{ $inventory->item }}</div>
                                <div><strong>Description:</strong> {{ $inventory->description }}</div>
                                <div><strong>Department:</strong> {{ $inventory->department->name ?? 'No Department' }}</div>
                                <div><strong>Amount (RM):</strong> {{ number_format($inventory->amount, 2) }}</div>
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
