<x-body-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>
    
    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>


    @if (isset($header))
        <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-0 z-30 p-2 lg:p-0 border-b lg:border-none bg-white">
            <div class="flex items-center justify-between space-x-3">
                {{ $header }}
            </div>
            <div x-data="{ dropdownOpen: false }"  class="relative lg:hidden">
                <button @click="dropdownOpen = ! dropdownOpen" class="text-gray-900 hover:text-indigo-700 text-xl ">
                    <i class="fa-solid fa-bars"></i>
                </button>
    
                <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>
    
                <x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
            </div>
        </div>
    @endif

    <div class="space-y-6 px-2 lg:px-0">
        {{ $slot }}
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>

</x-body-layout>