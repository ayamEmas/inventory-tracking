
<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                {{ __('Disposal Approval Details') }}
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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <button onclick="history.back()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Previous Page
                </button>
            </div>

            <!-- Status Banner -->
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
                $approvedNames = [];
                if ($disposal->remarks1 == 1 && $disposal->name1) {
                    $approvedNames[] = $disposal->name1;
                }
                if ($disposal->remarks2 == 1 && $disposal->name2) {
                    $approvedNames[] = $disposal->name2;
                }
                if ($disposal->remarks3 == 1 && $disposal->name3) {
                    $approvedNames[] = $disposal->name3;
                }
                
                $rejectedNames = [];
                if ($disposal->remarks1 == 2 && $disposal->name1) {
                    $rejectedNames[] = $disposal->name1;
                }
                if ($disposal->remarks2 == 2 && $disposal->name2) {
                    $rejectedNames[] = $disposal->name2;
                }
                if ($disposal->remarks3 == 2 && $disposal->name3) {
                    $rejectedNames[] = $disposal->name3;
                }
            @endphp

            @php
                $totalApprovals = 3; // Total number of supervisors
                $approvedCount = count($approvedNames);
                $isFullyApproved = $approvedCount === $totalApprovals;
            @endphp

            @if($approvedCount > 0 && !$isFullyApproved)
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Pending Approval - {{ $approvedCount }}/{{ $totalApprovals }} Supervisors Approved
                            </h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Approved by {{ count($approvedNames) == 1 ? $approvedNames[0] : implode(', ', array_slice($approvedNames, 0, -1)) . ' and ' . end($approvedNames) }}. Waiting for all supervisors to approve.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($isFullyApproved)
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                Fully Approved by All Supervisors
                            </h3>
                            <p class="text-sm text-green-700 mt-1">
                                Approved by {{ implode(', ', array_slice($approvedNames, 0, -1)) . ' and ' . end($approvedNames) }}. This disposal has been fully approved.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif(count($rejectedNames) > 0)
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Rejected by {{ count($rejectedNames) == 1 ? $rejectedNames[0] : implode(', ', array_slice($rejectedNames, 0, -1)) . ' and ' . end($rejectedNames) }}
                            </h3>
                            <p class="text-sm text-red-700 mt-1">
                                This disposal has been rejected and cannot proceed.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Pending Approval</h3>
                            <p class="text-sm text-yellow-700 mt-1">This disposal is waiting for approval.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Inventory Information -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Inventory Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">ID Tag</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $deletedInventory->id_tag }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Serial Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->serial_num }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Item Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->item }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->description }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Category</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ getAssetCategoryName($deletedInventory->asset_cat, $assetCategories) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Type</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->asset_type }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Department</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->department->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Location</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->asset_location }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Purchase Order No</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->purchase_order_no }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Quantity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->nos }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Original Amount</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">RM {{ number_format($deletedInventory->amount, 2) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Date</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Supplier Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->supplier_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Supplier Contact</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->supplier_contactno }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Supplier Address</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->supplier_address }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Supplier Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->supplier_email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Supplier Fax</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->supplier_faxno }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Code</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->asset_code }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Item Location</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->item_location }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Microsoft Office</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->microsoft_office }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Telephone Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->tel_number }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Application Disposal Submitted At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $deletedInventory->deleted_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disposal Information -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Disposal Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Registration Serial Number</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $disposal->registrationSerialNum }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->assetDescrip }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Acquisition Date</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->acquisitionDate->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Asset Age</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->assetAge }} years</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Original Cost</label>
                                    <p class="mt-1 text-sm text-gray-900 font-medium">RM {{ number_format($disposal->oriCost, 2) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Current Value</label>
                                    <p class="mt-1 text-sm text-gray-900">RM {{ number_format($disposal->currentValue, 2) }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">State of Asset</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->stateAsset }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Disposal Method</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->disposalMethod }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Justification</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $disposal->justification }}</p>
                            </div>
                            
                            @if($disposal->notes)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Notes</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $disposal->notes }}</p>
                                </div>
                            @endif

                            @php
                                $approvals = [
                                    ['remarks' => $disposal->remarks1, 'name' => $disposal->name1, 'label' => 'Approval 1'],
                                    ['remarks' => $disposal->remarks2, 'name' => $disposal->name2, 'label' => 'Approval 2'],
                                    ['remarks' => $disposal->remarks3, 'name' => $disposal->name3, 'label' => 'Approval 3'],
                                ];
                                $hasApproval = collect($approvals)->contains(fn($a) => $a['remarks'] == 1);
                            @endphp

                            @if(!$hasApproval)
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-md font-medium text-gray-800 mb-3">Approval Details</h4>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Status</label>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @foreach($approvals as $index => $approval)
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-md font-medium text-gray-800 mb-3">{{ $approval['label'] }} Details</h4>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Reviewed By</label>
                                                <p class="mt-1 text-sm text-gray-900">
                                                    {{ $approval['name'] ?? '-' }}
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600">Status</label>
                                                @if($approval['remarks'] == 1)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Approved
                                                    </span>
                                                @elseif($approval['remarks'] == 2)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approval Form (only show if pending) -->
            @if(auth()->id() == 5)
                @if(!$disposal->remarks1)
                    <div class="mt-8 bg-white rounded-lg shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Approval Form</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('disposal.approve', $disposal->id) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <input type="hidden" id="supervisor1" name="supervisor1" value="{{ auth()->id() }}" required>
                                        <input type="hidden" id="name1" name="name1" value="{{ auth()->user()->name }}" required>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="remarks1" class="block text-sm font-medium text-gray-700">Decision</label>
                                    <select id="remarks1" name="remarks1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" disabled selected>Select approval status</option>
                                        <option value="1" {{ old('remarks1') == '1' ? 'selected' : '' }}>Approve</option>
                                        <option value="2" {{ old('remarks1') == '2' ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-end mt-6 space-x-3">
                                    <a href="{{ route('info.disposal') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                        Cancel
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 transition ease-in-out duration-150">
                                        Submit Decision
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @elseif(auth()->id() == 7)
                @if($disposal->remarks1 == 1)
                    @if(!$disposal->remarks2)
                        <div class="mt-8 bg-white rounded-lg shadow-md">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">Approval Form</h3>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('disposal.approve2', $disposal->id) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <input type="hidden" id="supervisor2" name="supervisor2" value="{{ auth()->id() }}" required>
                                            <input type="hidden" id="name2" name="name2" value="{{ auth()->user()->name }}" required>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <label for="remarks2" class="block text-sm font-medium text-gray-700">Decision</label>
                                        <select id="remarks2" name="remarks2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="" disabled selected>Select approval status</option>
                                            <option value="1" {{ old('remarks2') == '1' ? 'selected' : '' }}>Approve</option>
                                            <option value="2" {{ old('remarks2') == '2' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                    </div>

                                    <div class="flex items-center justify-end mt-6 space-x-3">
                                        <a href="{{ route('info.disposal') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                            Cancel
                                        </a>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 transition ease-in-out duration-150">
                                            Submit Decision
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            @elseif(auth()->id() == 8)
                @if($disposal->remarks2 == 1)
                    @if(!$disposal->remarks3)
                        <div class="mt-8 bg-white rounded-lg shadow-md">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">Approval Form</h3>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('disposal.approve3', $disposal->id) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <input type="hidden" id="supervisor3" name="supervisor3" value="{{ auth()->id() }}" required>
                                            <input type="hidden" id="name3" name="name3" value="{{ auth()->user()->name }}" required>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <label for="remarks3" class="block text-sm font-medium text-gray-700">Decision</label>
                                        <select id="remarks3" name="remarks3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="" disabled selected>Select approval status</option>
                                            <option value="1" {{ old('remarks3') == '1' ? 'selected' : '' }}>Approve</option>
                                            <option value="2" {{ old('remarks3') == '2' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                    </div>

                                    <div class="flex items-center justify-end mt-6 space-x-3">
                                        <a href="{{ route('info.disposal') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 transition ease-in-out duration-150">
                                            Cancel
                                        </a>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 transition ease-in-out duration-150">
                                            Submit Decision
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
</x-app-layout> 