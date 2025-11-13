<aside class="w-64 h-screen bg-gray-50 border-r border-gray-200 fixed top-0 left-0 z-40 flex flex-col pt-16 shadow-lg">
    <nav class="flex-1 px-4 py-8 space-y-4 flex flex-col">
        <div class="mb-6 w-full text-center">
            <span class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Menu</span>
        </div>
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
            <!-- Dashboard Icon: Squares 2x2 -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z"/>
            </svg>
            <span>Dashboard</span>
        </a>
        @php
            $role = Auth::user()->role;
            $departmentId = Auth::user()->department_id;

            $inventoryRoutes = ['inventory', 'itemForm'];
            $disposalRoutes = ['inventories.deleted', 'pelupusan', 'pelupusan.search', 'pelupusan.store', 'info.disposal', 'disposal.approval'];

            $inventoryActive = request()->routeIs($inventoryRoutes);
            $disposalActive = request()->routeIs($disposalRoutes);

            $canAccessInventory = in_array($role, ['Admin System', 'HOD', 'AM', 'OM', 'GM', 'MD', 'Staff']);
            $canAddItem = $canAccessInventory;
            $canAccessDisposal = $canAccessInventory;
            $canViewDisposalOverview = in_array($role, ['Admin System', 'HOD', 'AM', 'OM', 'GM', 'MD', 'Staff']);
            $canManageUsers = ($role === 'Admin System') || in_array($role, ['HOD', 'AM', 'OM', 'GM', 'MD']);
        @endphp

        @if($canAccessInventory)
            <div x-data="{ open: {{ $inventoryActive ? 'true' : 'false' }} }" class="space-y-2">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between gap-2 rounded-lg px-3 py-2 text-sm font-semibold transition
                        {{ $inventoryActive ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2zm0 4h6m-6 4h6m-6 4h6"/>
                        </svg>
                        <span>Inventory</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-9 space-y-1 text-sm" x-cloak>
                    <a href="{{ route('inventory') }}"
                       class="flex items-center rounded-md px-3 py-2 transition {{ request()->routeIs('inventory') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                        Inventory Record
                    </a>
                    @if($canAddItem)
                        <a href="{{ route('itemForm') }}"
                           class="flex items-center rounded-md px-3 py-2 transition {{ request()->routeIs('itemForm') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                            Add Item
                        </a>
                    @endif
                    @php
                        $pendingSidebarCount = $sidebarPendingCount ?? App\Models\Inventory::where('check', 0)->count();
                    @endphp
                    @if(Auth::user()->department_id === 4)
                        <a href="{{ route('inventory.verification') }}"
                           class="flex items-center justify-between rounded-md px-3 py-2 transition {{ request()->routeIs('inventory.verification') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                            <span>Pending Verification</span>
                            @if($pendingSidebarCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold bg-yellow-500 text-white rounded-full">
                                    {{ $pendingSidebarCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if($canAccessDisposal)
            <div x-data="{ open: {{ $disposalActive ? 'true' : 'false' }} }" class="space-y-2">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between gap-2 rounded-lg px-3 py-2 text-sm font-semibold transition
                        {{ $disposalActive ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22"/>
                        </svg>
                        <span>Disposal</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-9 space-y-1 text-sm" x-cloak>
                    <a href="{{ route('inventories.deleted') }}"
                       class="flex items-center rounded-md px-3 py-2 transition {{ request()->routeIs('inventories.deleted') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                        Disposal Record
                    </a>
                    <a href="{{ route('pelupusan') }}"
                       class="flex items-center rounded-md px-3 py-2 transition {{ request()->routeIs('pelupusan') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                        Disposal Form
                    </a>
                    @if($canViewDisposalOverview)
                        <a href="{{ route('info.disposal') }}"
                           class="flex items-center rounded-md px-3 py-2 transition {{ request()->routeIs('info.disposal') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                            Disposal Overview
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if($canManageUsers)
            <a href="{{ route('user') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('user') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                </svg>
                <span>User Management</span>
            </a>
        @endif
    </nav>
</aside>