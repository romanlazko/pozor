<nav class="bg-white border-b border-gray-100 px-2 sticky top-0">
    <div class="w-full m-auto">
        <div class="flex w-full h-16 sm:px-0 items-center">
            <div class="flex-1 items-center justify-start hidden lg:flex">
                <x-application-logo class="h-9 w-9" />
            </div>
           
            <div class="flex w-full max-w-lg m-auto justify-between shrink-0 items-center">
                <x-header.link href="{{ route('marketplace.index') }}"  :active="request()->routeIs('marketplace.index')">
                    <i class="fa-solid fa-store md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Marketplace') }}
                    </span>
                </x-header.link>
                <x-header.link href="{{ route('real-estate.index') }}"  :active="request()->routeIs('real-estate.*')" >
                    <i class="fa-solid fa-house-circle-check md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Real Estate') }}
                    </span>
                </x-header.link>
                <x-header.link :active="request()->routeIs('admin.telegram_bot.edit.*')">
                    <i class="fa-solid fa-briefcase md:mr-1"></i>
                    <span class="hidden md:block">
                        {{ __('Prace') }}
                    </span>
                </x-header.link>
                <x-header.link href="{{ route('profile.dashboard') }}"  :active="request()->routeIs('profile.*')">
                    <i class="fa-solid fa-address-card md:mr-1"></i>
                    <span  class="hidden md:block">
                        {{ __('Profile') }}
                    </span>
                </x-header.link>
                <x-a-buttons.create href="{{ route('create') }}"  class="h-min lg:hidden">
                    {{ __("Create announcement") }}
                </x-a-buttons.create>
            </div>

            <div class="hidden flex-1 items-center space-x-3 justify-end lg:flex">
                <x-a-buttons.create href="{{ route('create') }}"  class="">
                    {{ __("Create announcement") }}
                </x-a-buttons.create>
            </div>
        </div>
    </div>
</nav>
