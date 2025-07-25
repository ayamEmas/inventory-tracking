<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ now()->format('F d, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 space-y-6">
        <!-- Count Boxes -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Inventory Count Box -->
                <div class="bg-white/90 backdrop-blur-sm p-6 shadow-lg rounded-xl border border-gray-100 animate-fade-in-up delay-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Inventories</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $inventories->count() }}</p>
                        </div>
                        <div class="p-2.5 bg-indigo-100 rounded-xl group-hover:bg-indigo-200 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- User Count Box -->
                <div class="bg-white/90 backdrop-blur-sm p-6 shadow-lg rounded-xl border border-gray-100 animate-fade-in-up delay-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $users->count() }}</p>
                        </div>
                        <div class="p-2.5 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors duration-300">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Department Count Box -->
                <div class="bg-white/90 backdrop-blur-sm p-6 shadow-lg rounded-xl border border-gray-100 animate-fade-in-up delay-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Departments</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $departmentDistribution->count() }}</p>
                        </div>
                        <div class="p-2.5 bg-purple-100 rounded-xl group-hover:bg-purple-200 transition-colors duration-300">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Deleted Items Count Box -->
                <div class="bg-white/90 backdrop-blur-sm p-6 shadow-lg rounded-xl border border-gray-100 animate-fade-in-up delay-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Inventory Disposal</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $deletedItems->count() }}</p>
                        </div>
                        <div class="p-2.5 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors duration-300">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Distribution -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-sm p-4 shadow-lg rounded-xl animate-fade-in-up delay-600 border border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Department Distribution</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($departmentDistribution as $department)
                        <div class="bg-gray-50/50 rounded-lg p-3" x-data="{ open: false }">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                    <span class="text-sm font-medium text-gray-700">{{ $department['name'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $department['percentage'] }}%</span>
                                    <span class="text-sm text-gray-500">({{ $department['count'] }})</span>
                                    <button @click="open = !open" class="ml-2 text-indigo-600 hover:text-indigo-800 focus:outline-none transition-colors duration-200" :aria-expanded="open">
                                        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                                <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $department['percentage'] }}%"></div>
                            </div>
                            
                            <!-- Category Distribution within Department -->
                            <div class="mt-2 pl-3 border-l-2 border-indigo-200" x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">Categories:</h4>
                                <div class="space-y-2">
                                    @php
                                        $categoryNames = [
                                            'B' => 'Building',
                                            'MV' => 'Motor Vehicle',
                                            'M' => 'Machinery',
                                            'FF' => 'Furniture & Fitting',
                                            'SE' => 'Site Equipment',
                                            'OE' => 'Office Equipment',
                                            'C' => 'Computer',
                                        ];
                                    @endphp
                                    @foreach($department['categories'] as $category)
                                        <div>
                                            <div class="flex items-center justify-between mb-0.5">
                                                <div class="flex items-center gap-1.5">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                                    <span class="text-sm font-medium text-gray-700">{{ $categoryNames[$category['name']] ?? $category['name'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-medium text-gray-900">RM {{ number_format($category['total_amount'], 2) }}</span>
                                                    <span class="text-sm font-medium text-gray-900">{{ $category['percentage'] }}%</span>
                                                    <span class="text-sm text-gray-500">({{ $category['count'] }})</span>
                                                </div>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1">
                                                <div class="bg-green-500 h-1 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Staff + Inventory Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ showInventory: true }">
            <div class="relative">
                <!-- Inventory Table -->
                <div x-show="showInventory" class="bg-white/90 backdrop-blur-sm p-8 shadow-lg rounded-xl border border-gray-100 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">Inventory List</h3>
                        </div>
                        <a href="{{ route('inventory') }}" class="text-sm text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventories as $index => $inventory)
                                    <tr class="even:bg-gray-50 hover:bg-indigo-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $inventory->item }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inventory->department->name ?? 'No Department' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">No inventories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Next Button -->
                    <button @click="showInventory = false" class="absolute top-1/2 right-0 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-2 shadow-lg focus:outline-none transition-all duration-200" title="Show User Table">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <!-- User Table -->
                <div x-show="!showInventory" class="bg-white/90 backdrop-blur-sm p-8 shadow-lg rounded-xl border border-gray-100 transition-all duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-800">User List</h3>
                        </div>
                        <a href="{{ route('user') }}" class="text-sm text-green-600 hover:text-green-700 flex items-center gap-1">
                            View All
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr class="even:bg-gray-50 hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">No staff found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Prev Button -->
                    <button @click="showInventory = true" class="absolute top-1/2 left-0 -translate-y-1/2 bg-green-600 hover:bg-green-700 text-white rounded-full p-2 shadow-lg focus:outline-none transition-all duration-200" title="Show Inventory Table">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }
        .delay-200 {
            animation-delay: 200ms;
        }
        .delay-400 {
            animation-delay: 400ms;
        }
        .delay-600 {
            animation-delay: 600ms;
        }
        .delay-800 {
            animation-delay: 800ms;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</x-app-layout>
