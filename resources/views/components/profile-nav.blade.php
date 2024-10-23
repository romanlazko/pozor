<nav {{ $attributes->merge(['class' => 'p-4 space-y-6']) }}>

    <a href="{{ route('profile.edit') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.edit')])>
        <x-heroicon-s-user class="size-5"/>
        <span class="font-medium text-sm">{{ __("Profile") }}</span>
    </a>

    {{-- <a href="{{ route('profile.announcement.index') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.announcement.index')])>
        <i class="fa-solid fa-clipboard-list w-4"></i>
        <span class="font-medium text-sm">{{ __("My announcements") }}</span>
    </a> --}}

    <a href="{{ route('profile.wishlist') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.wishlist')])>
        <x-heroicon-s-heart class="size-5"/>
        <span class="font-medium text-sm">{{ __("Wishlist") }}</span>
    </a>

    <a @click="$dispatch('open-chat')" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('profile.message.*')])>
        <div class="relative leading-3">
            @if ($unreadMessagesCount > 0)
                <p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-3 text-center content-center items-center">{{ $unreadMessagesCount }}</p>
            @endif
            <x-heroicon-s-chat-bubble-left-right class="size-5"/>
        </div>
        <span class="font-medium text-sm">{{ __("Messages") }}</span>
    </a>

    {{ $slot }}

    @hasrole('super-duper-admin')
        <hr>
        <a href="{{ route('admin.announcement.moderation') }}" @class(['flex text-gray-700 hover:text-indigo-600 whitespace-nowrap items-center space-x-3', 'text-indigo-600' => request()->routeIs('admin.announcements.inde')])>
            <x-heroicon-o-adjustments-horizontal class="size-5"/>
            <span class="font-medium text-sm">{{ __("Admin") }}</span>
        </a>
    @endhasrole
</nav>