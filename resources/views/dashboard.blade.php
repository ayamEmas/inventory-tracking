<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight animate-fade-in">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-10">
        <!-- Count Boxes -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                <!-- Inventory Count Box -->
                <a href="{{ route('inventory') }}" class="md:w-1/2 bg-white/90 backdrop-blur-sm p-6 shadow-lg sm:rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up delay-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Inventories</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $inventories->count() }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition-colors duration-300">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- User Count Box -->
                <a href="{{ route('user') }}" class="md:w-1/2 bg-white/90 backdrop-blur-sm p-6 shadow-lg sm:rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up delay-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $users->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full group-hover:bg-green-200 transition-colors duration-300">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Staff + Inventory Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                <!-- Inventory Column -->
                <div class="block md:w-1/2 bg-white/90 backdrop-blur-sm p-6 shadow-lg sm:rounded-lg animate-fade-in-up delay-600">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Inventory List</h3>
                    </div>
                    <div class="overflow-y-auto custom-scrollbar" style="max-height: 250px;">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                            <thead class="bg-gray-100/80 backdrop-blur-sm border border-black-300 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">#</th>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">Item</th>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">Department</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inventories as $index => $inventory)
                                    <tr class="hover:bg-gray-100/50 transition-colors duration-200">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $inventory->item }}</td>
                                        <td class="px-4 py-2">{{ $inventory->department->name ?? 'No Department' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">No inventories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Staff Table -->
                <div class="block md:w-1/2 bg-white/90 backdrop-blur-sm p-6 shadow-lg sm:rounded-lg animate-fade-in-up delay-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">User List</h3>
                    </div>
                    <div class="overflow-y-auto custom-scrollbar" style="max-height: 250px;">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                            <thead class="bg-gray-100/80 backdrop-blur-sm border border-black-300 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">#</th>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">Name</th>
                                    <th class="px-4 py-2 text-left bg-gray-100/80">Email</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-gray-100/50 transition-colors duration-200">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $user->name }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">No staff found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
