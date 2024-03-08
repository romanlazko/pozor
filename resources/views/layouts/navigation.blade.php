<nav class="bg-white border-b border-gray-100 px-2">
    <!-- Primary Navigation Menu -->
    <div class="w-full m-auto">
        <div class="flex justify-between h-16 sm:px-0 items-center space-x-3">
            {{-- <div class="shrink-0">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div> --}}
            <div class="flex w-full max-w-lg m-auto justify-between">
                <x-header.link href="{{ route('marketplace.index') }}" wire:navigate :active="request()->routeIs('marketplace.*')" class="items-center flex text-center w-min ">
                    <i class="fa-solid fa-store md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Marketplace') }}
                    </span>
                </x-header.link>
                <x-header.link href="{{ route('real-estate.index') }}" wire:navigate :active="request()->routeIs('real-estate.*')"  class="items-center flex text-center w-min ">
                    <i class="fa-solid fa-house-circle-check md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Real Estate') }}
                    </span>
                </x-header.link>
                <x-header.link :active="request()->routeIs('admin.telegram_bot.edit.*')" class="items-center flex text-center w-min ">
                    <i class="fa-solid fa-briefcase md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Prace') }}
                    </span>
                </x-header.link>
                <x-header.link href="{{ route('profile.dashboard') }}" wire:navigate :active="request()->routeIs('profile.*')" class="items-center flex text-center w-min ">
                    <i class="fa-solid fa-address-card md:mr-1"></i>
                    <span  class="hidden md:block">
                        {{ __('Profile') }}
                    </span>
                </x-header.link>
            </div>

            {{-- <!-- Settings Dropdown -->
            <div class="flex items-center space-x-3">
                <div x-data="{ dropdownOpen: false }"  class="relative">
                    <button @click="dropdownOpen = ! dropdownOpen" class="flex text-gray-500 hover:text-indigo-700">
                        <i class="fa-solid fa-gear text-lg"></i>
                    </button>
        
                    <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>
        
                    <div x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-xl border">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                            <div class="whitespace-nowrap">
                                <div class="font-medium text-base">{{ __("Profile") }}</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.marketplace.announcement.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                            <div class="whitespace-nowrap">
                                <div class="font-medium text-base">{{ __("Admin") }}</div>
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white w-full text-left whitespace-nowrap">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</nav>
