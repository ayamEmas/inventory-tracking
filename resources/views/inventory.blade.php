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

                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold">Record of the Inventory</h3>
                        <a href="{{ route('itemForm') }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                            Add Items
                        </a>
                    </div>

                    <div class="mb-4">
                        <form id="filterForm" method="GET" action="{{ route('inventory') }}" class="flex flex-wrap items-center space-x-2">
                            <input
                                type="text"
                                name="item_filter"
                                value="{{ request('item_filter') }}"
                                placeholder="Filter by item name"
                                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Filter
                            </button>
                            <select name="department_filter" onchange="document.getElementById('filterForm').submit();" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">All Departments</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->name }}" {{ request('department_filter') == $department->name ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">Year</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">Item</th>
                                    <th class="w-2/7 px-4 py-2 text-left text-sm font-medium text-gray-600">Description</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">Amount (RM)</th> 
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inventories as $index => $inventory)
                                <tr>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $index + 1 }}</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $inventory->year }}</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $inventory->item }}</th>
                                    <th class="w-2/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $inventory->description }}</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $inventory->department->name ?? 'No Department' }}</th>
                                    <th class="w-1/7 px-4 py-2 text-left text-sm font-medium text-gray-600">{{ number_format($inventory->amount, 2) }}</th>
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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
