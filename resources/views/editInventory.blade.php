<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Inventory Form') }}
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
                    <!-- Back Button with Animation -->
                    <div x-data="{ show: false }" 
                         x-init="setTimeout(() => show = true, 200)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform -translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('inventory') }}" class="inline-flex items-center gap-2 bg-red-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-red-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Cancel
                            </a>
                            <a href="{{ route('inventories.download-single-pdf', $inventory->id) }}" class="inline-flex items-center gap-2 bg-gray-600 text-white text-sm px-6 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('inventories.update', $inventory->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- GENERAL INFORMATION -->
                        <div x-data="{ show: false }" 
                             x-init="setTimeout(() => show = true, 400)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-bold text-gray-800">General Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Purchase Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="date">Purchase Date</label>
                                    <input type="date" name="date" id="date" value="{{ $inventory->date }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Purchase Order No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="purchase_order_no">Purchase Order No</label>
                                    <input type="text" name="purchase_order_no" id="purchase_order_no" value="{{ $inventory->purchase_order_no }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>
                            </div>
                        </div>

                        <!-- SUPPLIER INFORMATION -->
                        <div x-data="{ show: false }" 
                             x-init="setTimeout(() => show = true, 600)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-lg font-bold text-gray-800">Supplier Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Supplier Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="supplier_name">Supplier Name</label>
                                    <input type="text" name="supplier_name" id="supplier_name" value="{{ $inventory->supplier_name }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="supplier_email">Email</label>
                                    <input type="email" name="supplier_email" id="supplier_email" value="{{ $inventory->supplier_email }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="supplier_address">Address</label>
                                    <textarea name="supplier_address" id="supplier_address" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>{{ $inventory->supplier_address }}</textarea>
                                </div>

                                <!-- Contact No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="supplier_contactno">Contact No</label>
                                    <input type="text" name="supplier_contactno" id="supplier_contactno" value="{{ $inventory->supplier_contactno }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Fax No -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="supplier_faxno">Fax No</label>
                                    <input type="text" name="supplier_faxno" id="supplier_faxno" value="{{ $inventory->supplier_faxno }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>
                            </div>
                        </div>

                        <!-- ASSET INFORMATION -->
                        <div x-data="{ show: false }" 
                             x-init="setTimeout(() => show = true, 800)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h3 class="text-lg font-bold text-gray-800">Asset Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Department -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="department_id">Asset Department</label>
                                    <select name="department_id" id="department_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                        <option value="">Please select</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ $inventory->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="asset_location">Asset Location</label>
                                    <input name="asset_location" id="asset_location" value="{{ $inventory->asset_location }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Asset To -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="asset_to">Asset To</label>
                                    <input name="asset_to" id="asset_to" value="{{ $inventory->asset_to }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Asset Code -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="asset_code">Asset Code</label>
                                    <input name="asset_code" id="asset_code" value="{{ $inventory->asset_code }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Asset Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="asset_cat">Category</label>
                                    <input name="asset_cat" id="asset_cat" value="{{ $inventory->asset_cat }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Asset Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="asset_type">Asset Type</label>
                                    <input name="asset_type" id="asset_type" value="{{ $inventory->asset_type }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Item Location -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="item_location">Item Location</label>
                                    <input name="item_location" id="item_location" value="{{ $inventory->item_location }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Item -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="item">Item</label>
                                    <input name="item" id="item" value="{{ $inventory->item }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>
                            </div>
                        </div>

                        <!-- OTHERS INFORMATION -->
                        <div x-data="{ show: false }" 
                             x-init="setTimeout(() => show = true, 1000)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="border border-gray-200 rounded-lg p-6 mb-6 shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <h3 class="text-lg font-bold text-gray-800">Others Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Asset Serial Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="serial_num">Asset Serial Number</label>
                                    <input type="text" name="serial_num" id="serial_num" value="{{ $inventory->serial_num }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Microsoft Office -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="microsoft_office">Microsoft Office</label>
                                    <input type="text" name="microsoft_office" id="microsoft_office" value="{{ $inventory->microsoft_office }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Tel Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="tel_number">Tel Number</label>
                                    <input type="text" name="tel_number" id="tel_number" value="{{ $inventory->tel_number }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>
                                
                                <!-- NOS -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nos">NOS</label>
                                    <input type="text" name="nos" id="nos" value="{{ $inventory->nos }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Amount -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="amount">Asset Value (RM)</label>
                                    <input type="number" step="0.01" name="amount" id="amount" value="{{ $inventory->amount }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="description">Description</label>
                                    <input type="text" name="description" id="description" value="{{ $inventory->description }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300" required>
                                </div>

                                <!-- Current Image Display -->
                                @if($inventory->image)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Image</label>
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/images/' . $inventory->image) }}" 
                                             alt="{{ $inventory->item }}" 
                                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 hover:scale-105 transition-transform duration-200 cursor-pointer"
                                             onclick="openImageModal('{{ asset('storage/images/' . $inventory->image) }}', '{{ $inventory->item }}')">
                                        <div class="text-sm text-gray-600">
                                            <p><strong>Current image:</strong> {{ $inventory->image }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Click image to view full size</p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Image Upload -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="image">Update Item Image</label>
                                    <input type="file" name="image" id="image" accept="image/*" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                                    <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the current one (JPG, PNG, GIF). Max size: 10MB. Leave empty to keep current image.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div x-data="{ show: false }" 
                             x-init="setTimeout(() => show = true, 1200)"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform -translate-y-4"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 transition-all duration-300 hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Item
                            </button>
                        </div>

                        @if (session('success'))
                            <div 
                                x-data="{ show: true }" 
                                x-show="show" 
                                x-init="setTimeout(() => show = false, 3000)" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-8 py-4 rounded-lg shadow-xl z-50"
                            >
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-4 max-w-2xl max-h-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-800"></h3>
                <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, title) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>