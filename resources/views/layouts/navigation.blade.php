<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-sm border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity duration-300">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(session()->has('impersonator_id'))
                    <form action="{{ route('stop.impersonating') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            Stop Impersonating
                        </button>
                    </form>
                    @endif

                    @php $pos = Auth::user()->position; @endphp

                    @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Inventory') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('inventory')">
                                    {{ __('View Record') }}
                                </x-dropdown-link>
                                @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
                                <x-dropdown-link :href="route('itemForm')">
                                    {{ __('Add Item') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('inventories.deleted')">
                                    {{ __('Inventory Disposal') }}
                                </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @elseif($pos === 'Staff')
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ __('Inventory') }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('inventory')">
                                    {{ __('View Record') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif

                    @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
                        <x-nav-link :href="route('user')" :active="request()->routeIs('user')">
                            {{ __('User') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @php $pos = Auth::user()->position; @endphp
            @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
            <div class="pt-2 pb-3 space-y-1">
                <div class="px-4 py-2 text-sm text-gray-500">{{ __('Inventory') }}</div>
                <x-responsive-nav-link :href="route('inventory')" :active="request()->routeIs('inventory')">
                    {{ __('View Record') }}
                </x-responsive-nav-link>
                @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
                <x-responsive-nav-link :href="route('itemForm')" :active="request()->routeIs('itemForm')">
                    {{ __('Add Item') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inventories.deleted')" :active="request()->routeIs('inventories.deleted')">
                    {{ __('Inventory Disposal') }}
                </x-responsive-nav-link>
                @endif
            </div>
            @elseif($pos === 'Staff')
            <div class="pt-2 pb-3 space-y-1">
                <div class="px-4 py-2 text-sm text-gray-500">{{ __('Inventory') }}</div>
                <x-responsive-nav-link :href="route('inventory')" :active="request()->routeIs('inventory')">
                    {{ __('View Record') }}
                </x-responsive-nav-link>
            </div>
            @endif
            @if($pos === 'Admin System' || in_array($pos, ['HOD', 'AM', 'OM', 'GM', 'MD']))
            <x-responsive-nav-link :href="route('user')" :active="request()->routeIs('user')">
                {{ __('User') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-red-600 hover:text-red-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

