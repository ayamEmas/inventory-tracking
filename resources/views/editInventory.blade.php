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
                    <a href="{{ route('inventory') }}" class="inline-block bg-red-600 text-white text-sm px-4 py-2 rounded-md hover:bg-red-700">
                        < Cancel
                    </a>
                </div>
                    <form method="POST" action="{{ route('inventories.update', $inventory->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Item -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="item">Item</label>
                            <input type="text" name="item" id="item" value="{{ $inventory->item }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                            <input type="text" name="description" id="description" value="{{ $inventory->description }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <!-- Year, Department, and Amount -->
                        <div class="flex space-x-4 mb-4">
                            <!-- Year -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="year">Year</label>
                                <input type="number" name="year" id="year" value="{{ $inventory->year }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Department -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="department_id">Department</label>
                                <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- Select Department --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ $inventory->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Amount -->
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700" for="amount">Amount (RM)</label>
                                <input type="number" step="0.01" name="amount" id="amount" value="{{ $inventory->amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <x-primary-button>
                            Update Item
                        </x-primary-button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>