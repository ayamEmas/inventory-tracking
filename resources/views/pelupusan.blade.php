<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
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
                    @php
                        // Asset Category Mapping
                        $assetCategories = [
                            'B' => 'Building',
                            'MV' => 'Motor Vehicle',
                            'M' => 'Machinery',
                            'FF' => 'Furniture & Fitting',
                            'SE' => 'Site Equipment',
                            'OE' => 'Office Equipment',
                            'C' => 'Computer'
                        ];
                        
                        // Function to get full category name with code in brackets
                        function getAssetCategoryName($code, $categories) {
                            $fullName = $categories[$code] ?? $code;
                            return $fullName . ' (' . $code . ')';
                        }
                    @endphp
                    
                    @php
                        $record = $record ?? null;
                        $showForm = $showForm ?? false;
                        $showStatus = $showStatus ?? false;
                        $disposalRejected = $disposalRejected ?? false;
                        $isDisposed = $isDisposed ?? false;
                    @endphp
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-6 bg-green-50 border-2 border-green-200 text-green-800 rounded-lg shadow-sm" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; min-width: 400px; max-width: 600px;">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-lg font-semibold text-green-800">Success!</h4>
                                    <p class="text-green-700 mt-1">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <script>
                            setTimeout(function() {
                                var successDiv = document.querySelector('.bg-green-50');
                                if (successDiv) {
                                    successDiv.style.opacity = '0';
                                    successDiv.style.transition = 'opacity 0.5s';
                                    setTimeout(function() {
                                        successDiv.remove();
                                    }, 500);
                                }
                            }, 5000);
                        </script>
                    @endif

                    @if(session('error') || $errors->any())
                        <div class="mb-6 p-6 bg-red-50 border-2 border-red-200 text-red-800 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-lg font-semibold text-red-800">Error!</h4>
                                    @if(session('error'))
                                        <p class="text-red-700 mt-1">{{ session('error') }}</p>
                                    @endif
                                    @if($errors->any())
                                        <ul class="text-red-700 mt-1 list-disc list-inside">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

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
                    @if(isset($inventory) && $showForm)
                        @if($disposalRejected)
                            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                The previous disposal request for this asset was rejected. Please review the details and resubmit the form.
                            </div>
                        @endif

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
                                            <p class="text-gray-900">{{ getAssetCategoryName($inventory->asset_cat, $assetCategories) }}</p>
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

                            <!-- Disposal Form -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-800 mb-6">Disposal Form</h3>

                                <form method="POST" action="{{ route('pelupusan.store') }}" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    
                                    <!-- Asset Information Section -->
                                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                                        <h4 class="font-semibold text-gray-700 mb-4">Asset Information</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <div>
                                                <x-input-label for="registrationSerialNum" value="Registration Serial Number" />
                                                <x-text-input id="registrationSerialNum" name="registrationSerialNum" type="text" 
                                                    class="mt-1 block w-full bg-gray-200 border-gray-300" value="{{ old('registrationSerialNum', $inventory->serial_num) }}" readonly required />
                                                <x-input-error :messages="$errors->get('registrationSerialNum')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="id_tag" value="ID Tag" />
                                                <x-text-input id="id_tag" name="id_tag" type="text" 
                                                    class="mt-1 block w-full bg-gray-200 border-gray-300" value="{{ old('id_tag', $inventory->id_tag) }}" readonly required />
                                                <x-input-error :messages="$errors->get('id_tag')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="assetDescrip" value="Asset Description" />
                                                <x-text-input id="assetDescrip" name="assetDescrip" type="text" 
                                                    class="mt-1 block w-full bg-gray-200 border-gray-300" value="{{ old('assetDescrip', $inventory->description) }}" readonly required />
                                                <x-input-error :messages="$errors->get('assetDescrip')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="acquisitionDate" value="Acquisition Date" />
                                                <x-text-input id="acquisitionDate" name="acquisitionDate" type="date" 
                                                    class="mt-1 block w-full bg-gray-200 border-gray-300" value="{{ old('acquisitionDate', $inventory->date) }}" readonly required />
                                                <x-input-error :messages="$errors->get('acquisitionDate')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                 <x-input-label for="assetAge" value="Asset Age (Years)" />
                                                 <x-text-input id="assetAge" name="assetAge" type="number" min="0" 
                                                     class="mt-1 block w-full bg-gray-200 border-gray-300" 
                                                     value="{{ old('assetAge', floor(\Carbon\Carbon::parse($inventory->date)->diffInYears(now()))) }}" required />
                                                 <x-input-error :messages="$errors->get('assetAge')" class="mt-2" />
                                             </div>
                                            
                                            <div>
                                                <x-input-label for="oriCost" value="Original Cost (RM)" />
                                                <x-text-input id="oriCost" name="oriCost" type="number" step="0.01" min="0" 
                                                    class="mt-1 block w-full bg-gray-200 border-gray-300" value="{{ old('oriCost', $inventory->amount) }}" readonly required />
                                                <x-input-error :messages="$errors->get('oriCost')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="currentValue" value="Current Value (RM)" />
                                                <x-text-input id="currentValue" name="currentValue" type="number" step="0.01" min="0" 
                                                    class="mt-1 block w-full bg-white border-gray-300" value="{{ old('currentValue') }}" required />
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
                                                <select id="stateAsset" name="stateAsset" class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="">Select State</option>
                                                    <option value="Good" {{ old('stateAsset') == 'Good' ? 'selected' : '' }}>Good (Baik)</option>
                                                    <option value="Poor" {{ old('stateAsset') == 'Poor' ? 'selected' : '' }}>Poor (Kurang Baik)</option>
                                                    <option value="Damaged" {{ old('stateAsset') == 'Damaged' ? 'selected' : '' }}>Damaged (Rosak)</option>
                                                    <option value="Obsolete" {{ old('stateAsset') == 'Obsolete' ? 'selected' : '' }}>Obsolete (Tidak Digunakan Lagi / Usang)</option>
                                                </select>
                                                <x-input-error :messages="$errors->get('stateAsset')" class="mt-2" />
                                            </div>
                                            
                                            <div>
                                                <x-input-label for="disposalMethod" value="Disposal Method" />
                                                <select id="disposalMethod" name="disposalMethod" class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
                                                    class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                    placeholder="Provide justification for disposal..." required>{{ old('justification') }}</textarea>
                                                <x-input-error :messages="$errors->get('justification')" class="mt-2" />
                                            </div>
                                            
                                            <div class="md:col-span-2">
                                                <x-input-label for="notes" value="Additional Notes" />
                                                <textarea id="notes" name="notes" rows="3" 
                                                    class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                    placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                            </div>
                                            
                                            <div class="md:col-span-2">
                                                <x-input-label for="picture" value="Asset Picture" />
                                                <input
                                                    id="picture"
                                                    name="picture"
                                                    type="file"
                                                    accept="image/*"
                                                    class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700"
                                                />
                                                <p class="mt-2 text-xs text-gray-500">Supported formats: JPG, PNG, GIF, WEBP. Max size 10MB.</p>
                                                <x-input-error :messages="$errors->get('picture')" class="mt-2" />
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

                    @if(isset($disposalData) && $disposalData && $showStatus)
                        <div class="max-w-4xl mx-auto my-8">
                            @php
                                // Check if all supervisors have approved
                                $allApproved = !empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1) &&
                                              !empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2) &&
                                              !empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3);
                                
                                // Check if any supervisor has rejected
                                $hasRejection = (!empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1) && $disposalData->remarks1 == 2) ||
                                               (!empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2) && $disposalData->remarks2 == 2) ||
                                               (!empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3) && $disposalData->remarks3 == 2);
                                
                                // Check if all supervisors have responded (either approved or rejected)
                                $allResponded = !empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1) &&
                                               !empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2) &&
                                               !empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3);
                            @endphp
                            
                            @if($hasRejection)
                                 <div class="rounded-xl border-2 border-red-500 bg-white shadow-lg p-8 relative">
                                     <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex items-center gap-2">
                                         <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-500 text-white font-bold text-sm shadow">
                                             <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                             </svg>
                                             Disposal Rejected
                                         </span>
                                     </div>
                                     <h2 class="text-2xl font-bold text-red-600 mb-2 text-center mt-4">This disposal has been rejected by supervisor</h2>
                                    <p class="text-center text-gray-700 mb-8">ID Tag: <span class="font-semibold">{{ $record?->id_tag }}</span></p>
                                     
                                     <!-- Approval Status Section - Only show for rejection case -->
                                     <div class="mb-8">
                                         <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Approval Status</h3>
                                         
                                         <!-- Supervisor 1 Status - Only show if responded -->
                                         @if(!empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1))
                                         <div class="mb-4 p-4 border rounded-lg {{ $disposalData->remarks1 == 1 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                             <div class="flex items-center justify-between">
                                                 <div>
                                                     <h4 class="font-semibold text-gray-700">Approval by Finance Manager</h4>
                                                     <p class="text-sm text-gray-600">
                                                         {{ $disposalData->name1 }} 
                                                         <span class="font-medium">({{ $disposalData->remarks1 == 1 ? 'Approve' : 'Reject' }})</span>
                                                     </p>
                                                 </div>
                                                 <div class="flex items-center">
                                                     @if($disposalData->remarks1 == 1)
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                             </svg>
                                                             Approved
                                                         </span>
                                                     @else
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                             </svg>
                                                             Rejected
                                                         </span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                         @endif

                                         <!-- Supervisor 2 Status - Only show if responded -->
                                         @if(!empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2))
                                         <div class="mb-4 p-4 border rounded-lg {{ $disposalData->remarks2 == 1 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                             <div class="flex items-center justify-between">
                                                 <div>
                                                     <h4 class="font-semibold text-gray-700">Approval by General Manager</h4>
                                                     <p class="text-sm text-gray-600">
                                                         {{ $disposalData->name2 }}
                                                         <span class="font-medium">({{ $disposalData->remarks2 == 1 ? 'Approve' : 'Reject' }})</span>
                                                     </p>
                                                 </div>
                                                 <div class="flex items-center">
                                                     @if($disposalData->remarks2 == 1)
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                             </svg>
                                                             Approved
                                                         </span>
                                                     @else
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                             </svg>
                                                             Rejected
                                                         </span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                         @endif

                                         <!-- Supervisor 3 Status - Only show if responded -->
                                         @if(!empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3))
                                         <div class="mb-4 p-4 border rounded-lg {{ $disposalData->remarks3 == 1 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                             <div class="flex items-center justify-between">
                                                 <div>
                                                     <h4 class="font-semibold text-gray-700">Approval by Managing Director</h4>
                                                     <p class="text-sm text-gray-600">
                                                         {{ $disposalData->name3 }}
                                                         <span class="font-medium">({{ $disposalData->remarks3 == 1 ? 'Approve' : 'Reject' }})</span>
                                                     </p>
                                                 </div>
                                                 <div class="flex items-center">
                                                     @if($disposalData->remarks3 == 1)
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                             </svg>
                                                             Approved
                                                         </span>
                                                     @else
                                                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                             <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                             </svg>
                                                             Rejected
                                                         </span>
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                         @endif
                                     </div>
                                     
                                     <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Inventory Details</h3>
                                            <ul class="text-gray-800 space-y-1">
                                                <li><span class="font-medium text-gray-500">Item:</span> {{ $record?->item }}</li>
                                                <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $record?->id_tag }}</li>
                                                <li><span class="font-medium text-gray-500">Description:</span> {{ $record?->description }}</li>
                                                <li><span class="font-medium text-gray-500">Quantity:</span> {{ $record?->nos }}</li>
                                                <li><span class="font-medium text-gray-500">Amount:</span> RM {{ number_format(optional($record)->amount ?? 0, 2) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Code:</span> {{ $record?->asset_code }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Category:</span> {{ getAssetCategoryName(optional($record)->asset_cat, $assetCategories) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Type:</span> {{ $record?->asset_type }}</li>
                                                <li><span class="font-medium text-gray-500">Serial Number:</span> {{ $record?->serial_num }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Location:</span> {{ $record?->asset_location }}</li>
                                                <li><span class="font-medium text-gray-500">Department:</span> {{ optional(optional($record)->department)->name ?? 'N/A' }}</li>
                                                <li><span class="font-medium text-gray-500">Date:</span> {{ optional(optional($record)->date)->format('Y-m-d') ?? optional($record)->date }}</li>
                                            </ul>
                                        </div>
                                         @if(isset($disposalData) && $disposalData)
                                         <div>
                                             <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Disposal Record</h3>
                                             <ul class="text-gray-800 space-y-1">
                                                 <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $disposalData->id_tag }}</li>
                                                 <li><span class="font-medium text-gray-500">Registration Serial Number:</span> {{ $disposalData->registrationSerialNum }}</li>
                                                 <li><span class="font-medium text-gray-500">Asset Description:</span> {{ $disposalData->assetDescrip }}</li>
                                                 <li><span class="font-medium text-gray-500">Acquisition Date:</span> {{ $disposalData->acquisitionDate }}</li>
                                                 <li><span class="font-medium text-gray-500">Asset Age (Years):</span> {{ $disposalData->assetAge }}</li>
                                                 <li><span class="font-medium text-gray-500">Original Cost (RM):</span> {{ $disposalData->oriCost }}</li>
                                                 <li><span class="font-medium text-gray-500">Current Value (RM):</span> {{ $disposalData->currentValue }}</li>
                                                 <li><span class="font-medium text-gray-500">State of Asset:</span> {{ $disposalData->stateAsset }}</li>
                                                 <li><span class="font-medium text-gray-500">Disposal Method:</span> 
                                                     <span class="inline-block px-2 py-0.5 rounded bg-red-200 text-red-800 text-xs font-semibold">
                                                         {{ $disposalData->disposalMethod }}
                                                     </span>
                                                 </li>
                                                 <li><span class="font-medium text-gray-500">Justification:</span> {{ $disposalData->justification }}</li>
                                                 <li><span class="font-medium text-gray-500">Notes:</span> {{ $disposalData->notes }}</li>
                                                 @if(!empty($disposalData->picture_path))
                                                 <li class="space-y-2">
                                                     <span class="font-medium text-gray-500 block">Asset Picture:</span>
                                                     <img src="{{ asset('storage/' . $disposalData->picture_path) }}" alt="Asset picture" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                                     <a href="{{ asset('storage/' . $disposalData->picture_path) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                                         <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                         </svg>
                                                         View full size
                                                     </a>
                                                 </li>
                                                 @endif
                                             </ul>
                                         </div>
                                         @endif
                                     </div>
                                     <div class="text-center mt-6">
                                         <span class="inline-block px-4 py-2 rounded bg-red-50 text-red-700 font-semibold border border-red-200">
                                             Disposal has been rejected. This item cannot be disposed and should be restored to active inventory.
                                         </span>
                                     </div>
                                 </div>
                            @elseif($allApproved && $isDisposed && $record)
                                <div class="rounded-xl border-2 border-green-500 bg-white shadow-lg p-8 relative">
                                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex items-center gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-500 text-white font-bold text-sm shadow">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Fully Approved Disposal
                                        </span>
                                    </div>
                                    <h2 class="text-2xl font-bold text-green-600 mb-2 text-center mt-4">This item has been fully approved and disposed</h2>
                                    <p class="text-center text-gray-700 mb-8">ID Tag: <span class="font-semibold">{{ $record?->id_tag }}</span></p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Inventory Details</h3>
                                            <ul class="text-gray-800 space-y-1">
                                                <li><span class="font-medium text-gray-500">Item:</span> {{ $record?->item }}</li>
                                                <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $record?->id_tag }}</li>
                                                <li><span class="font-medium text-gray-500">Description:</span> {{ $record?->description }}</li>
                                                <li><span class="font-medium text-gray-500">Quantity:</span> {{ $record?->nos }}</li>
                                                <li><span class="font-medium text-gray-500">Amount:</span> RM {{ number_format(optional($record)->amount ?? 0, 2) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Code:</span> {{ $record?->asset_code }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Category:</span> {{ getAssetCategoryName(optional($record)->asset_cat, $assetCategories) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Type:</span> {{ $record?->asset_type }}</li>
                                                <li><span class="font-medium text-gray-500">Serial Number:</span> {{ $record?->serial_num }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Location:</span> {{ $record?->asset_location }}</li>
                                                <li><span class="font-medium text-gray-500">Department:</span> {{ optional(optional($record)->department)->name ?? 'N/A' }}</li>
                                                <li><span class="font-medium text-gray-500">Date:</span> {{ optional(optional($record)->date)->format('Y-m-d') ?? optional($record)->date }}</li>
                                            </ul>
                                        </div>
                                        @if(isset($disposalData) && $disposalData)
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Disposal Record</h3>
                                            <ul class="text-gray-800 space-y-1">
                                                <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $disposalData->id_tag }}</li>
                                                <li><span class="font-medium text-gray-500">Registration Serial Number:</span> {{ $disposalData->registrationSerialNum }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Description:</span> {{ $disposalData->assetDescrip }}</li>
                                                <li><span class="font-medium text-gray-500">Acquisition Date:</span> {{ $disposalData->acquisitionDate }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Age (Years):</span> {{ $disposalData->assetAge }}</li>
                                                <li><span class="font-medium text-gray-500">Original Cost (RM):</span> {{ $disposalData->oriCost }}</li>
                                                <li><span class="font-medium text-gray-500">Current Value (RM):</span> {{ $disposalData->currentValue }}</li>
                                                <li><span class="font-medium text-gray-500">State of Asset:</span> {{ $disposalData->stateAsset }}</li>
                                                <li><span class="font-medium text-gray-500">Disposal Method:</span> 
                                                    <span class="inline-block px-2 py-0.5 rounded bg-red-200 text-red-800 text-xs font-semibold">
                                                        {{ $disposalData->disposalMethod }}
                                                    </span>
                                                </li>
                                                <li><span class="font-medium text-gray-500">Justification:</span> {{ $disposalData->justification }}</li>
                                                <li><span class="font-medium text-gray-500">Notes:</span> {{ $disposalData->notes }}</li>
                                                @if(!empty($disposalData->picture_path))
                                                <li class="space-y-2">
                                                    <span class="font-medium text-gray-500 block">Asset Picture:</span>
                                                    <img src="{{ asset('storage/' . $disposalData->picture_path) }}" alt="Asset picture" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                                    <a href="{{ asset('storage/' . $disposalData->picture_path) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        View full size
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-6">
                                        @if($hasRejection)
                                            <span class="inline-block px-4 py-2 rounded bg-red-50 text-red-700 font-semibold border border-red-200">
                                                Disposal has been rejected. This item cannot be disposed and should be restored to active inventory.
                                            </span>
                                        @else
                                            <span class="inline-block px-4 py-2 rounded bg-green-50 text-green-700 font-semibold border border-green-200">
                                                All approvals complete. No further disposal actions can be performed on this item.
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="rounded-xl border-2 border-yellow-500 bg-white shadow-lg p-8 relative">
                                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 flex items-center gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-500 text-white font-bold text-sm shadow">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pending Approval
                                        </span>
                                    </div>
                                    <h2 class="text-2xl font-bold text-yellow-600 mb-2 text-center mt-4">Disposal request pending supervisor approval</h2>
                                    <p class="text-center text-gray-700 mb-8">ID Tag: <span class="font-semibold">{{ $record?->id_tag }}</span></p>
                                    
                                    <!-- Approval Status Section -->
                                    <div class="mb-8">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4 text-center">Approval Status</h3>
                                        
                                        <!-- Supervisor 1 Status -->
                                        <div class="mb-4 p-4 border rounded-lg {{ !empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1) ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-semibold text-gray-700">Approval by Finance Manager</h4>
                                                    <p class="text-sm text-gray-600">
                                                        @if(!empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1))
                                                            Approved by: {{ $disposalData->name1 }} 
                                                            <span class="font-medium">({{ $disposalData->remarks1 == 1 ? 'Approve' : 'Reject' }})</span>
                                                        @else
                                                            Pending approval
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex items-center">
                                                    @if(!empty($disposalData->supervisor1) && !empty($disposalData->name1) && !empty($disposalData->remarks1))
                                                        @if($disposalData->remarks1 == 1)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                Approved
                                                            </span>
                                                        @else

                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supervisor 2 Status -->
                                        <div class="mb-4 p-4 border rounded-lg {{ !empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2) ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-semibold text-gray-700">Approval by General Manager</h4>
                                                    <p class="text-sm text-gray-600">
                                                        @if(!empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2))
                                                            Approved by: {{ $disposalData->name2 }}
                                                            <span class="font-medium">({{ $disposalData->remarks2 == 1 ? 'Approve' : 'Reject' }})</span>
                                                        @else
                                                            Pending approval
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex items-center">
                                                    @if(!empty($disposalData->supervisor2) && !empty($disposalData->name2) && !empty($disposalData->remarks2))
                                                        @if($disposalData->remarks2 == 1)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                Approved
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Supervisor 3 Status -->
                                        <div class="mb-4 p-4 border rounded-lg {{ !empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3) ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="font-semibold text-gray-700">Approval by Managing Director</h4>
                                                    <p class="text-sm text-gray-600">
                                                        @if(!empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3))
                                                            Approved by: {{ $disposalData->name3 }}
                                                            <span class="font-medium">({{ $disposalData->remarks3 == 1 ? 'Approve' : 'Reject' }})</span>
                                                        @else
                                                            Pending approval
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex items-center">
                                                    @if(!empty($disposalData->supervisor3) && !empty($disposalData->name3) && !empty($disposalData->remarks3))
                                                        @if($disposalData->remarks3 == 1)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                Approved
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Rejected
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Inventory Details</h3>
                                            <ul class="text-gray-800 space-y-1">
                                                <li><span class="font-medium text-gray-500">Item:</span> {{ $record?->item }}</li>
                                                <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $record?->id_tag }}</li>
                                                <li><span class="font-medium text-gray-500">Description:</span> {{ $record?->description }}</li>
                                                <li><span class="font-medium text-gray-500">Quantity:</span> {{ $record?->nos }}</li>
                                                <li><span class="font-medium text-gray-500">Amount:</span> RM {{ number_format(optional($record)->amount ?? 0, 2) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Code:</span> {{ $record?->asset_code }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Category:</span> {{ getAssetCategoryName(optional($record)->asset_cat, $assetCategories) }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Type:</span> {{ $record?->asset_type }}</li>
                                                <li><span class="font-medium text-gray-500">Serial Number:</span> {{ $record?->serial_num }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Location:</span> {{ $record?->asset_location }}</li>
                                                <li><span class="font-medium text-gray-500">Department:</span> {{ optional(optional($record)->department)->name ?? 'N/A' }}</li>
                                                <li><span class="font-medium text-gray-500">Date:</span> {{ optional(optional($record)->date)->format('Y-m-d') ?? optional($record)->date }}</li>
                                            </ul>
                                        </div>
                                        @if(isset($disposalData) && $disposalData)
                                        <div>
                                            <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Disposal Record</h3>
                                            <ul class="text-gray-800 space-y-1">
                                                <li><span class="font-medium text-gray-500">ID Tag:</span> {{ $disposalData->id_tag }}</li>
                                                <li><span class="font-medium text-gray-500">Registration Serial Number:</span> {{ $disposalData->registrationSerialNum }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Description:</span> {{ $disposalData->assetDescrip }}</li>
                                                <li><span class="font-medium text-gray-500">Acquisition Date:</span> {{ $disposalData->acquisitionDate }}</li>
                                                <li><span class="font-medium text-gray-500">Asset Age (Years):</span> {{ $disposalData->assetAge }}</li>
                                                <li><span class="font-medium text-gray-500">Original Cost (RM):</span> {{ $disposalData->oriCost }}</li>
                                                <li><span class="font-medium text-gray-500">Current Value (RM):</span> {{ $disposalData->currentValue }}</li>
                                                <li><span class="font-medium text-gray-500">State of Asset:</span> {{ $disposalData->stateAsset }}</li>
                                                <li><span class="font-medium text-gray-500">Disposal Method:</span> 
                                                    <span class="inline-block px-2 py-0.5 rounded bg-red-200 text-red-800 text-xs font-semibold">
                                                        {{ $disposalData->disposalMethod }}
                                                    </span>
                                                </li>
                                                <li><span class="font-medium text-gray-500">Justification:</span> {{ $disposalData->justification }}</li>
                                                <li><span class="font-medium text-gray-500">Notes:</span> {{ $disposalData->notes }}</li>
                                                @if(!empty($disposalData->picture_path))
                                                <li class="space-y-2">
                                                    <span class="font-medium text-gray-500 block">Asset Picture:</span>
                                                    <img src="{{ asset('storage/' . $disposalData->picture_path) }}" alt="Asset picture" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
                                                    <a href="{{ asset('storage/' . $disposalData->picture_path) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        View full size
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-6">
                                        <span class="inline-block px-4 py-2 rounded bg-yellow-50 text-yellow-700 font-semibold border border-yellow-200">
                                            This disposal is pending approval from supervisors.
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
