<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">User Record</h3>
                        <a href=" " class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-md hover:bg-indigo-700">
                            Add Staff
                        </a>
                    </div>

                    <!-- Table Layout -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Position</th>
                                    <th class="px-4 py-2 text-sm font-medium text-gray-600 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $index + 1 }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->name }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->email }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->department->name ?? 'No Department' }}</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">{{ $user->role }}</th>
                                        <th class="px-4 py-2 text-sm font-medium text-gray-600 text-center">Action</th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-sm text-gray-500 text-center">
                                            No users found.
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