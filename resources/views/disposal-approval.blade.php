
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Disposal Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Inventory Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p><strong>ID Tag:</strong><br>{{ $deletedInventory->id_tag }}</p>
                            <p class="mt-4"><strong>Serial Number:</strong><br>{{ $deletedInventory->serial_num }}</p>
                            <p class="mt-4"><strong>Description:</strong><br>{{ $deletedInventory->description }}</p>
                        </div>
                        <div>
                            <p><strong>Asset Category:</strong><br>{{ $deletedInventory->asset_cat }}</p>
                            <p class="mt-4"><strong>Asset Type:</strong><br>{{ $deletedInventory->asset_type }}</p>
                            <p class="mt-4"><strong>Original Cost:</strong><br>RM{{ number_format($disposal->oriCost, 2) }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mt-6 mb-4">Disposal Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p><strong>Justification:</strong><br>{{ $disposal->justification }}</p>
                            <p class="mt-4"><strong>Disposal Method:</strong><br>{{ $disposal->disposalMethod }}</p>
                        </div>
                        <div>
                            <p><strong>State of Asset:</strong><br>{{ $disposal->stateAsset }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('disposal.approve', $disposal->id) }}" method="POST" class="mt-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="supervisor1" class="block font-medium text-sm text-gray-700">Supervisor</label>
                                <select id="supervisor1" name="supervisor1" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Select a supervisor</option>
                                    @foreach($hods as $hod)
                                        <option value="{{ $hod->id }}">{{ $hod->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="name1" class="block font-medium text-sm text-gray-700">Approved By</label>
                                <input type="text" id="name1" name="name1" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('name1') }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="remarks1" class="block font-medium text-sm text-gray-700">Remarks</label>
                            <select id="remarks1" name="remarks1" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="" disabled selected>Select approval status</option>
                                <option value="1" {{ old('remarks1') == '1' ? 'selected' : '' }}>Approve</option>
                                <option value="2" {{ old('remarks1') == '2' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Approve
                            </button>
                            <a href="{{ url()->previous() }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 