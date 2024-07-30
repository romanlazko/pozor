<x-body-layout>
    

    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>
    
    <x-slot name="header">
        
        <div class="w-full space-y-3">
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach ($categories as $child)
                    <a 
                        href="{{ route('announcement.index', ['category' => $child->slug]) }}"
                        @class([
                            'p-2 bg-white rounded-lg text-sm border hover:border-indigo-700 items-center ',
                        ])
                    >
                        <div class="flex items-center space-x-2 m-auto h-full">
                            <div class="w-12 h-12 min-h-12 min-w-12">
                                <img src="{{ $child->getFirstMediaUrl('categories', 'thumb') }}" alt="" class="float-right">
                            </div>
                            <div class="grid">
                                <span class="w-full font-bold">
                                    {{ $child->name }}
                                </span>
                                <span class="w-full text-xs text-gray-500">
                                    {{ $child->announcements_count }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-0 z-30 p-2 lg:p-0 border-b lg:border-none bg-gray-50">
        <button @click="sidebarOpen = true" class="text-gray-900 hover:text-indigo-700 text-xl lg:hidden">
            <i class="fa-solid fa-magnifying-glass text-xl "></i>
        </button>

        <div class="w-full text-center lg:text-start">
            <div class="w-full lg:flex items-center lg:justify-between">
                <h2 class="text-xl lg:text-3xl font-bold ">
                    {{ __("Latest announcements:") }}
                </h2>
            </div>
        </div>

        <div x-data="{ dropdownOpen: false }"  class="relative lg:hidden">
            <button @click="dropdownOpen = ! dropdownOpen" class="text-gray-900 hover:text-indigo-700 text-xl ">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

            <x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <x-announcement-list :announcements="$announcements" />

        <div class="p-4">
            {{ $announcements->onEachSide(1)->links() }}
        </div>
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>