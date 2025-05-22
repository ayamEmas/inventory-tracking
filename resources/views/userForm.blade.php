<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"><div class="flex items-center justify-between mb-4">
                    <a href="{{ route('user') }}" class="inline-block bg-red-600 text-white text-sm px-4 py-2 rounded-md hover:bg-red-700">
                        < Cancel
                    </a>
                </div>
                    <form method="POST" action="{{ route('userForm.store') }}">
                        @csrf

                        <div class="flex space-x-4 mb-4">
                            <!-- Name -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Email -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                <input type="text" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        <!-- Password, Department, and Role -->
                        <div class="flex space-x-4 mb-4">
                            <!-- Year -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                                <input type="text" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Department -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="department_id">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- Select Department --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- role -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="role">Position</label>
                                <input type="text" name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end">
                            <x-primary-button>
                                Add User
                            </x-primary-button>
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

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>