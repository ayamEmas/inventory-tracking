<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Disposal') }}
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
                    <!-- Search Form -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Search Inventory by ID Tag</h3>
                        <form method="POST" action="{{ route('pelupusan.search') }}" class="space-y-4">
                            @csrf
                            <div class="flex gap-4 items-end">
                                <div class="flex-1">
                                    <x-input-label for="id_tag" value="Inventory ID Tag" />
                                    <x-text-input id="id_tag" name="id_tag" type="text" class="mt-1 block w-full" 
                                        placeholder="Enter inventory ID tag" value="{{ old('id_tag') }}" required />
                                    <x-input-error :messages="$errors->get('id_tag')" class="mt-2" />
                                </div>
                                <x-primary-button type="submit">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <!-- Inventory Display -->
                    @if(isset($inventory))
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Inventory Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Basic Information -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 border-b pb-2">Basic Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">ID Tag:</span>
                                            <p class="text-gray-900 font-semibold">{{ $inventory->id_tag }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Item:</span>
                                            <p class="text-gray-900">{{ $inventory->item }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Description:</span>
                                            <p class="text-gray-900">{{ $inventory->description }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Quantity:</span>
                                            <p class="text-gray-900">{{ $inventory->nos }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Amount:</span>
                                            <p class="text-gray-900">RM {{ number_format($inventory->amount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Asset Information -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 border-b pb-2">Asset Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Asset Code:</span>
                                            <p class="text-gray-900">{{ $inventory->asset_code }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Asset Category:</span>
                                            <p class="text-gray-900">{{ $inventory->asset_cat }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Asset Type:</span>
                                            <p class="text-gray-900">{{ $inventory->asset_type }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Serial Number:</span>
                                            <p class="text-gray-900">{{ $inventory->serial_num }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Asset Location:</span>
                                            <p class="text-gray-900">{{ $inventory->asset_location }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location & Department -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 border-b pb-2">Location & Department</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Item Location:</span>
                                            <p class="text-gray-900">{{ $inventory->item_location }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Asset To:</span>
                                            <p class="text-gray-900">{{ $inventory->asset_to }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Department:</span>
                                            <p class="text-gray-900">{{ $inventory->department->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Date:</span>
                                            <p class="text-gray-900">{{ $inventory->date }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Supplier Information -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 border-b pb-2">Supplier Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Supplier Name:</span>
                                            <p class="text-gray-900">{{ $inventory->supplier_name }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Supplier Email:</span>
                                            <p class="text-gray-900">{{ $inventory->supplier_email }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Supplier Contact:</span>
                                            <p class="text-gray-900">{{ $inventory->supplier_contactno }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Purchase Order No:</span>
                                            <p class="text-gray-900">{{ $inventory->purchase_order_no }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Technical Information -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-700 border-b pb-2">Technical Information</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Microsoft Office:</span>
                                            <p class="text-gray-900">{{ $inventory->microsoft_office }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Telephone Number:</span>
                                            <p class="text-gray-900">{{ $inventory->tel_number }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Supplier Address:</span>
                                            <p class="text-gray-900">{{ $inventory->supplier_address }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Supplier Fax:</span>
                                            <p class="text-gray-900">{{ $inventory->supplier_faxno }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Disposal Action Buttons -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex gap-4">
                                    <x-primary-button class="bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Mark for Disposal
                                    </x-primary-button>
                                    <x-secondary-button>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download PDF
                                    </x-secondary-button>
                                </div>
                            </div>

                            <!-- Disposal Form -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Disposal Form</h3>
                                
                                @if(session('success'))
                                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('pelupusan.store') }}" class="space-y-6">
                                    @csrf
                                    
                                    <!-- Asset Information Section -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h4 class="font-semibold text-gray-700 mb-4">Asset Information</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <div>
                                                <x-input-label for="registrationSerialNum" value="Registration Serial Number" />
                                                <x-text-input id="registrationSerialNum" name="registrationSerialNum" type="text" 
                                                    class="mt-1 block w-full" value="{{ old('registrationSerialNum') }}" required />
                                                <x-input-error :messages="$errors->get('registrationSerialNum')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="assetDescrip" value="Asset Description" />
                                                <x-text-input id="assetDescrip" name="assetDescrip" type="text" 
                                                    class="mt-1 block w-full" value="{{ old('assetDescrip') }}" required />
                                                <x-input-error :messages="$errors->get('assetDescrip')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="acquisitionDate" value="Acquisition Date" />
                                                <x-text-input id="acquisitionDate" name="acquisitionDate" type="date" 
                                                    class="mt-1 block w-full" value="{{ old('acquisitionDate') }}" required />
                                                <x-input-error :messages="$errors->get('acquisitionDate')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="assetAge" value="Asset Age (Years)" />
                                                <x-text-input id="assetAge" name="assetAge" type="number" min="0" 
                                                    class="mt-1 block w-full" value="{{ old('assetAge') }}" required />
                                                <x-input-error :messages="$errors->get('assetAge')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="oriCost" value="Original Cost (RM)" />
                                                <x-text-input id="oriCost" name="oriCost" type="number" step="0.01" min="0" 
                                                    class="mt-1 block w-full" value="{{ old('oriCost') }}" required />
                                                <x-input-error :messages="$errors->get('oriCost')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="currentValue" value="Current Value (RM)" />
                                                <x-text-input id="currentValue" name="currentValue" type="number" step="0.01" min="0" 
                                                    class="mt-1 block w-full" value="{{ old('currentValue') }}" required />
                                                <x-input-error :messages="$errors->get('currentValue')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Disposal Details Section -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h4 class="font-semibold text-gray-700 mb-4">Disposal Details</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="stateAsset" value="State of Asset" />
                                                <select id="stateAsset" name="stateAsset" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="">Select State</option>
                                                    <option value="Good" {{ old('stateAsset') == 'Good' ? 'selected' : '' }}>Good</option>
                                                    <option value="Fair" {{ old('stateAsset') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                                    <option value="Poor" {{ old('stateAsset') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                                    <option value="Damaged" {{ old('stateAsset') == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                                                    <option value="Obsolete" {{ old('stateAsset') == 'Obsolete' ? 'selected' : '' }}>Obsolete</option>
                                                </select>
                                                <x-input-error :messages="$errors->get('stateAsset')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="disposalMethod" value="Disposal Method" />
                                                <select id="disposalMethod" name="disposalMethod" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="">Select Method</option>
                                                    <option value="Sale" {{ old('disposalMethod') == 'Sale' ? 'selected' : '' }}>Sale</option>
                                                    <option value="Donation" {{ old('disposalMethod') == 'Donation' ? 'selected' : '' }}>Donation</option>
                                                    <option value="Destruction" {{ old('disposalMethod') == 'Destruction' ? 'selected' : '' }}>Destruction</option>
                                                    <option value="Transfer" {{ old('disposalMethod') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                                    <option value="Scrap" {{ old('disposalMethod') == 'Scrap' ? 'selected' : '' }}>Scrap</option>
                                                </select>
                                                <x-input-error :messages="$errors->get('disposalMethod')" class="mt-2" />
                                            </div>
                                            
                                            <div class="md:col-span-2">
                                                <x-input-label for="justification" value="Justification for Disposal" />
                                                <textarea id="justification" name="justification" rows="3" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                    placeholder="Provide justification for disposal..." required>{{ old('justification') }}</textarea>
                                                <x-input-error :messages="$errors->get('justification')" class="mt-2" />
                                            </div>
                                            
                                            <div class="md:col-span-2">
                                                <x-input-label for="notes" value="Additional Notes" />
                                                <textarea id="notes" name="notes" rows="3" 
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                    placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Supervisor Approval Section -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h4 class="font-semibold text-gray-700 mb-4">Supervisor Approval</h4>
                                        
                                        <div class="p-4 border border-gray-200 rounded-lg">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <x-input-label for="supervisor1" value="Supervisor Name" />
                                                    <x-text-input id="supervisor1" name="supervisor1" type="text" 
                                                        class="mt-1 block w-full" value="{{ old('supervisor1') }}" required />
                                                    <x-input-error :messages="$errors->get('supervisor1')" class="mt-2" />
                                                </div>
                                                <div>
                                                    <x-input-label for="name1" value="Name" />
                                                    <x-text-input id="name1" name="name1" type="text" 
                                                        class="mt-1 block w-full" value="{{ old('name1') }}" required />
                                                    <x-input-error :messages="$errors->get('name1')" class="mt-2" />
                                                </div>
                                                <div>
                                                    <x-input-label for="remarks1" value="Remarks" />
                                                    <select id="remarks1" name="remarks1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                        <option value="">Select</option>
                                                        <option value="1" {{ old('remarks1') == '1' ? 'selected' : '' }}>Approved</option>
                                                        <option value="0" {{ old('remarks1') == '0' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('remarks1')" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex justify-end">
                                        <x-primary-button type="submit" class="bg-green-600 hover:bg-green-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Submit Disposal Form
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
