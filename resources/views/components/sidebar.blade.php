<aside class="w-64 h-screen bg-gray-50 border-r border-gray-200 fixed top-0 left-0 z-40 flex flex-col pt-16 shadow-lg">
    <nav class="flex-1 px-4 py-8 space-y-4 flex flex-col">
        <div class="mb-6 w-full text-center">
            <span class="text-xs font-semibold text-gray-400 tracking-widest uppercase">Menu</span>
        </div>
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" font-size="text-lg"
            class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
            <!-- Dashboard Icon: Squares 2x2 -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z"/>
            </svg>
            <span class="block text-justify w-full">{{ __('Dashboard') }}</span>
        </x-nav-link>
        @php $pos = Auth::user()->position; @endphp
        @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
            <x-nav-link :href="route('inventory')" :active="request()->routeIs('inventory')" font-size="text-lg"
                class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('inventory') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
                <!-- Inventory Icon: Clipboard List -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2zm0 4h6m-6 4h6m-6 4h6"/>
                </svg>
                <span class="block text-justify w-full">{{ __('Inventory') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('itemForm')" :active="request()->routeIs('itemForm')" font-size="text-lg"
                class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('itemForm') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
                <!-- Add Item Icon: Plus Circle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="block text-justify w-full">{{ __('Add Item') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('inventories.deleted')" :active="request()->routeIs('inventories.deleted')" font-size="text-lg"
                class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('inventories.deleted') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
                <!-- Disposal Icon: Trash -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22"/>
                </svg>
                <span class="block text-justify w-full">{{ __('Inventory Disposal') }}</span>
            </x-nav-link>
            <x-nav-link :href="route('user')" :active="request()->routeIs('user')" font-size="text-lg"
                class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('user') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
                <!-- User Icon: Users Group -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                </svg>
                <span class="block text-justify w-full">{{ __('User') }}</span>
            </x-nav-link>
        @elseif($pos === 'Staff')
            <x-nav-link :href="route('inventory')" :active="request()->routeIs('inventory')" font-size="text-lg"
                class="block w-full rounded-lg py-2 transition hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-3 {{ request()->routeIs('inventory') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : '' }}">
                <!-- Inventory Icon: Clipboard List -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2zm0 4h6m-6 4h6m-6 4h6"/>
                </svg>
                <span class="block text-justify w-full">{{ __('Inventory') }}</span>
            </x-nav-link>
        @endif
    </nav>
</aside>