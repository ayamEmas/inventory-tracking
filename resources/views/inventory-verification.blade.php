<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Inventory Verification') }}
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.656 0 3-1.567 3-3.5S13.656 4 12 4 9 5.567 9 7.5 10.344 11 12 11zm-7 9a7 7 0 0114 0H5z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Pending Verification</h3>
                </div>

                <form id="bulkVerificationForm" method="POST" action="{{ route('inventory.verification.bulk') }}">
                    @csrf
                    <div class="flex justify-between items-center px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <p class="text-sm text-gray-600">Select inventories to verify in bulk.</p>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition disabled:opacity-50"
                                id="bulkVerifyButton" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Verify Selected
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Tag</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Submitted On</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Value (RM)</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pendingInventories as $index => $inventory)
                                <tr class="hover:bg-indigo-50/40 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <input type="checkbox" name="inventory_ids[]" value="{{ $inventory->id }}" class="inventory-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $inventory->id_tag }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $inventory->item }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inventory->department->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($inventory->created_at)->format('M d, Y') ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">RM {{ number_format($inventory->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('inventories.edit', $inventory->id) }}"
                                               class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold uppercase rounded-md border border-indigo-200 text-indigo-600 hover:bg-indigo-50 transition"
                                               title="View and manage inventory details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Details
                                            </a>
                                            <form action="{{ route('inventory.verification.mark', $inventory) }}" method="POST" class="inline-flex items-center">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Verify
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-2m3 2v-2m-7 4h8a2 2 0 002-2V9a2 2 0 00-.6-1.4L13 3.6A2 2 0 0011.6 3H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <p>No inventories are awaiting verification.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.inventory-checkbox');
                const bulkButton = document.getElementById('bulkVerifyButton');

                function toggleBulkButton() {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    bulkButton.disabled = !anyChecked;
                }

                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        checkboxes.forEach(cb => cb.checked = selectAll.checked);
                        toggleBulkButton();
                    });
                }

                checkboxes.forEach(cb => cb.addEventListener('change', function () {
                    if (!this.checked && selectAll.checked) {
                        selectAll.checked = false;
                    }
                    toggleBulkButton();
                }));
            });
        </script>
    @endpush
</x-app-layout>

