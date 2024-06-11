<nav {{ $attributes->merge(['class' => 'p-4 space-y-6']) }}>
    {{-- <x-responsive-nav-link  :href="route('profile.announcement.index')" :active="request()->routeIs('profile.announcement.index')">
        {{ __('My announcements') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link  :href="route('profile.announcement.wishlist')" :active="request()->routeIs('profile.announcement.wishlist')">
        {{ __('Wishlist') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link  :href="route('profile.message.index')" :active="request()->routeIs('profile.message.*')" class="flex items-center space-x-3">
        <p>
            {{ __('Messages') }} 
        </p>
        @if (auth()->user()->unreadMessagesCount > 0)
            <p class="text-xs text-white w-5 h-5 rounded-full bg-blue-500 text-center content-center items-center">{{ auth()->user()->unreadMessagesCount }}</p>
        @endif
    </x-responsive-nav-link>
    <x-responsive-nav-link  :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
        {{ __('Profile') }}
    </x-responsive-nav-link> --}}

    <a href="{{ route('profile.edit') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.edit')])>
        <i class="fa-solid fa-address-card w-4"></i>
        <span class="font-medium text-base">{{ __("Profile") }}</span>
    </a>

    <a href="{{ route('profile.announcement.index') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.announcement.index')])>
        <i class="fa-solid fa-clipboard-list w-4"></i>
        <span class="font-medium">{{ __("My announcements") }}</span>
    </a>

    <a href="{{ route('profile.announcement.wishlist') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.announcement.wishlist')])>
        <i class="fa-solid fa-heart w-4"></i>
        <span class="font-medium">{{ __("Wishlist") }}</span>
    </a>

    <a href="{{ route('profile.message.index') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.message.*')])>
        <div class="relative leading-3">
            @if ($unreadMessagesCount > 0)
                <p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-3 text-center content-center items-center">{{ $unreadMessagesCount }}</p>
            @endif
            <i class="fa-solid fa-comments w-4"></i>
        </div>
        <span class="font-medium">{{ __("Messages") }}</span>
    </a>

    @hasrole('super-duper-admin')
        <hr>
        <a href="{{ route('admin.announcements') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('admin.announcements')])>
            <i class="fa-solid fa-user-tie"></i>
            <span class="font-medium">{{ __("Admin") }}</span>
        </a>
    @endhasrole
</nav>