<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory Form') }}
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

                        <!-- GENERAL INFORMATION -->
                        <div class="border border-black-200 rounded-md p-4 mb-6">
                            <h3 class="text-lg font-bold mb-4 text-black-700">General Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Purchase Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="date">Purchase Date</label>
                                    <input type="date" name="date" id="date" value="{{ $inventory->date }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Purchase Order No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="purchase_order_no">Purchase Order No</label>
                                    <input type="text" name="purchase_order_no" id="purchase_order_no" value="{{ $inventory->purchase_order_no }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </div>
                        </div>

                        <!-- SUPPLIER INFORMATION -->
                        <div class="border border-black-200 rounded-md p-4 mb-6">
                            <h3 class="text-lg font-bold mb-4 text-black-700">Supplier Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Supplier Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="supplier_name">Supplier Name</label>
                                    <input type="text" name="supplier_name" id="supplier_name" value="{{ $inventory->supplier_name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="supplier_email">Email</label>
                                    <input type="email" name="supplier_email" id="supplier_email" value="{{ $inventory->supplier_email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700" for="supplier_address">Address</label>
                                    <textarea name="supplier_address" id="supplier_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>{{ $inventory->supplier_address }} </textarea>
                                </div>

                                <!-- Contact No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="supplier_contactno">Contact No</label>
                                    <input type="text" name="supplier_contactno" id="supplier_contactno" value="{{ $inventory->supplier_contactno }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Fax No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="supplier_faxno">Fax No</label>
                                    <input type="text" name="supplier_faxno" id="supplier_faxno" value="{{ $inventory->supplier_faxno }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </div>
                        </div>

                        <!-- ASSET INFORMATION -->
                        <div class="border border-black-200 rounded-md p-4 mb-6">
                            <h3 class="text-lg font-bold mb-4 text-black-700">Asset Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Department -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="department_id">Asset Department</label>
                                    <select name="department_id" id="department_id" value="{{ $inventory->department_id }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                        <option value="">Please select</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="asset_location">Asset Location</label>
                                    <input name="asset_location" id="asset_location" value="{{ $inventory->asset_location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Asset To -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="asset_to">Asset To</label>
                                    <input name="asset_to" id="asset_to" value="{{ $inventory->asset_to }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Asset Code -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="asset_code">Asset Code</label>
                                    <input name="asset_code" id="asset_code" value="{{ $inventory->asset_code }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Asset Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="asset_cat">Category</label>
                                    <input name="asset_cat" id="asset_cat" value="{{ $inventory->asset_cat }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Asset Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="asset_type">Asset Type</label>
                                    <input name="asset_type" id="asset_type" value="{{ $inventory->asset_type }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Item Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="item_location">Item Location</label>
                                    <input name="item_location" id="item_location" value="{{ $inventory->item_location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Item -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="item">Item</label>
                                    <input name="item" id="item" value="{{ $inventory->item }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                            </div>
                        </div>

                        <!-- OTHERS INFORMATION -->
                        <div class="border border-black-200 rounded-md p-4 mb-6">
                            <h3 class="text-lg font-bold mb-4 text-black-700">Others Informations</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Asset Serial Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="serial_num">Asset Serial Number</label>
                                    <input type="text" name="serial_num" id="serial_num" value="{{ $inventory->serial_num }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Microsoft Office -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="microsoft_office">Microsoft Office</label>
                                    <input type="text" name="microsoft_office" id="microsoft_office" value="{{ $inventory->microsoft_office }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Tel Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="tel_number">Tel Number</label>
                                    <input type="text" name="tel_number" id="tel_number" value="{{ $inventory->tel_number }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                                
                                <!-- NOS -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="nos">NOS</label>
                                    <input type="text" name="nos" id="nos" value="{{ $inventory->nos }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="amount">Asset Value (RM)</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ $inventory->amount }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                                    <input type="text" name="description" id="description" value="{{ $inventory->description }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <x-primary-button>Update Item</x-primary-button>
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