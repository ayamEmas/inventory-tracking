<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-10">
        <!-- Staff + Inventory Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">

                <!-- Staff Table -->
                <a href="{{ route('user') }}" class="block md:w-1/2 bg-white p-6 shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                    <div class="flex justify-between items-c
                    enter mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">User List</h3>
                    </div>
                    <div class="overflow-y-auto" style="max-height: 250px;">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                            <thead class="bg-gray-100 border border-black-300 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left bg-gray-100">#</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Name</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Email</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr class="hover:bg-gray-100">
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
                </a>

                <!-- Inventory Column -->
                <a href="{{ route('inventory') }}" class="block md:w-1/2 bg-white p-6 shadow-sm sm:rounded-lg hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Inventory List</h3>
                    </div>
                    <div class="overflow-y-auto" style="max-height: 250px;">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                            <thead class="bg-gray-100 border border-black-300 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left bg-gray-100">#</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Item</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Department</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($inventories as $index => $inventory)
                                    <tr class="hover:bg-gray-100">
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
                </a>

            </div>
        </div>
    </div>

</x-app-layout>
