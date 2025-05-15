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

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Record of the Inventory</h3>
                        <a href="{{ route('itemForm') }}" class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                            Add Items
                        </a>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="w-1/6 px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="w-1/6 px-4 py-2 text-left text-sm font-medium text-gray-600">Date</th>
                                    <th class="w-2/6 px-4 py-2 text-left text-sm font-medium text-gray-600">Title</th>
                                    <th class="w-2/6 px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th> 
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="w-1/6 px-4 py-2 text-sm text-gray-700">#</td>
                                        <td class="w-1/6 px-4 py-2 text-sm text-gray-700">Date</td>
                                        <td class="w-2/6 px-4 py-2 text-sm text-gray-700">Title</td>
                                        <td class="w-2/6 px-4 py-2 text-sm text-gray-700">Department</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
