<x-body-layout>
    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>
    
    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>

    @if (isset($header))
        <x-slot name="header">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="flex items-center justify-between space-x-3">
                {{ $header }}
            </div>
        </x-slot>
    @endif
    
    {{ $slot }}

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>

</x-body-layout>