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
                                name="category_filter"
                                onchange="document.getElementById('filterForm').submit();"
                                class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                            >
                                <option value="">All Categories</option>
                                @foreach ($categoryNames as $code => $label)
                                    <option value="{{ $code }}" {{ request('category_filter') == $code ? 'selected' : '' }}>
                                        {{ $label }}
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

                    <!-- Desktop Display with Animation -->
                    <div class="hidden md:block">
                        @foreach($categoryGroups as $category)
                            @php
                                $categoryItems = $category['items'];
                                $pendingCount = $category['pending'];
                            @endphp

                            <div class="mb-10">
                                <div class="flex items-center justify-between mb-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $category['name'] }}</h3>
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $category['code'] }}</span>
                                        @if($pendingCount > 0)
                                            <span class="flex items-center gap-1 text-xs font-medium text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $pendingCount }} pending
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full table-fixed divide-y divide-gray-200 border border-gray-300 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="w-[6%] px-6 py-4 text-left text-sm font-semibold text-gray-600">#</th>
                                                <th class="w-[22%] px-6 py-4 text-left text-sm font-semibold text-gray-600">ID Tag</th>
                                                <th class="w-[15%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Date</th>
                                                <th class="w-[32%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Item</th>
                                                <th class="w-[15%] px-6 py-4 text-left text-sm font-semibold text-gray-600">Status</th>
                                                <th class="w-[10%] px-6 py-4 text-sm font-semibold text-gray-600 text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @forelse ($categoryItems as $index => $disposal)
                                                @php
                                                    $source = $disposal->deletedInventory ?? $disposal->inventory;
                                                    $idTag = optional($disposal->deletedInventory)->id_tag
                                                        ?? optional($disposal->inventory)->id_tag
                                                        ?? $disposal->id_tag
                                                        ?? 'N/A';
                                                    $itemName = optional($source)->item ?? $disposal->assetDescrip;
                                                    $dateValue = optional($source)->date ?? $disposal->acquisitionDate;
                                                    $formattedDate = $dateValue ? \Illuminate\Support\Carbon::parse($dateValue)->format('M d, Y') : 'No Date';
                                                    $pdfUrl = null;
                                                    if ($disposal->deletedInventory) {
                                                        $pdfUrl = route('inventories.download-deleted-pdf', $disposal->deletedInventory->id);
                                                    } elseif ($disposal->inventory) {
                                                        $pdfUrl = route('inventories.download-single-pdf', $disposal->inventory->id);
                                                    }
                                                @endphp
                                                <tr class="hover:bg-gray-50 transition-colors duration-300">
                                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-600">
                                                        <span class="truncate block" title="{{ $idTag }}">
                                                            {{ $idTag }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600">
                                                        {{ $formattedDate }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $itemName }}">
                                                        {{ $itemName }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600">
                                                        @if($disposal->remarks1 == 1)
                                                            @if($disposal->remarks2 == 1)
                                                                @if($disposal->remarks3 == 1)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        Approved
                                                                    </span>
                                                                @elseif($disposal->remarks3 == 2)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        Rejected
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        Pending for MD
                                                                    </span>
                                                                @endif
                                                            @elseif($disposal->remarks2 == 2)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    Rejected
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    Pending for GM
                                                                </span>
                                                            @endif
                                                        @elseif($disposal->remarks1 == 2)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                </svg>
                                                                Pending for Finance Manager
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-600 text-center leading-5 whitespace-normal">
                                                        <div class="flex justify-center space-x-3">
                                                            <a href="{{ route('disposal.approval', $disposal->id) }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                                    View Disposal
                                                                </span>
                                                            </a>
                                                            @if($pdfUrl)
                                                            <a href="{{ $pdfUrl }}" class="inline-block transform hover:-translate-y-1 transition-transform duration-300 group relative">
                                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                                                    Download PDF
                                                                </span>
                                                            </a>
                                                            @endif
                                                            @if(auth()->user()->role === 'Admin System' && $disposal->deletedInventory)
                                                            <form action="{{ route('inventories.restore', $disposal->deletedInventory->id) }}" method="POST" class="inline-block">
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
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                                        No deleted items found in this category.
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
                        
                        @foreach($categoryGroups as $category)
                            <div class="mb-6">
                                <!-- Category Title Card -->
                                <div class="bg-gray-200 border-2 border-gray-400 rounded-lg mb-4">
                                    <div class="px-6 py-4 text-center">
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $category['name'] }}</h3>
                                        <p class="text-xs text-gray-600 uppercase tracking-wide mt-1">{{ $category['code'] }}</p>
                                    </div>
                                </div>
                                
                                @forelse ($category['items'] as $index => $disposal)
                                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 shadow-sm hover:shadow-md transition-all duration-300">
                                    @php
                                        $source = $disposal->deletedInventory ?? $disposal->inventory;
                                        $idTag = optional($disposal->deletedInventory)->id_tag
                                            ?? optional($disposal->inventory)->id_tag
                                            ?? $disposal->id_tag
                                            ?? 'N/A';
                                        $itemName = optional($source)->item ?? $disposal->assetDescrip;
                                        $dateValue = optional($source)->date ?? $disposal->acquisitionDate;
                                        $formattedDate = $dateValue ? \Illuminate\Support\Carbon::parse($dateValue)->format('M d, Y') : 'No Date';
                                        $description = optional($source)->description ?? $disposal->assetDescrip;
                                        $pdfUrl = null;
                                        if ($disposal->deletedInventory) {
                                            $pdfUrl = route('inventories.download-deleted-pdf', $disposal->deletedInventory->id);
                                        } elseif ($disposal->inventory) {
                                            $pdfUrl = route('inventories.download-single-pdf', $disposal->inventory->id);
                                        }
                                    @endphp
                                    <div class="flex justify-between items-center px-6 py-4 bg-white">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $index + 1 }}. {{ $itemName }}
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
                                            <div><strong>ID Tag:</strong> {{ $idTag }}</div>
                                            <div><strong>Date:</strong> {{ $formattedDate }}</div>
                                            <div><strong>Status:</strong> 
                                                @if($disposal->remarks1 == 1)
                                                    @if($disposal->remarks2 == 1)
                                                        @if($disposal->remarks3 == 1)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                                </svg>
                                                                Approved
                                                            </span>
                                                        @elseif($disposal->remarks3 == 2)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                                </svg>
                                                                Pending for MD
                                                            </span>
                                                        @endif
                                                    @elseif($disposal->remarks2 == 2)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                            </svg>
                                                            Rejected
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                            </svg>
                                                            Pending for GM
                                                        </span>
                                                    @endif
                                                @elseif($disposal->remarks1 == 2)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                        </svg>
                                                        Pending for Finance Manager
                                                    </span>
                                                @endif
                                            </div>
                                            <div><strong>Description:</strong> {{ $description }}</div>
                                            <div class="flex justify-center mt-4 space-x-4">
                                                <a href="{{ route('disposal.approval', $disposal->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View Disposal
                                                </a>
                                                @if($pdfUrl)
                                                <a href="{{ $pdfUrl }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download PDF
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <div class="text-gray-500 text-sm text-center px-4">
                                        No deleted items found in this category.
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