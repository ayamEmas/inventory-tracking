<x-app-layout>
    <x-slot name="header">
        <div class="mt-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight animate-fade-in">
                    {{ __('Profile') }}
                </h2>
            </div>
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
            <!-- Profile Information -->
            <div x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 200)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="p-6 sm:p-8 bg-white/90 backdrop-blur-sm shadow-lg sm:rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 400)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="p-6 sm:p-8 bg-white/90 backdrop-blur-sm shadow-lg sm:rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account 
            <div x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 600)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="p-6 sm:p-8 bg-white/90 backdrop-blur-sm shadow-lg sm:rounded-xl border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>-->
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
    </style>
</x-app-layout>
