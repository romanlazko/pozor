<nav class="px-2 py-1 flex w-full justify-between items-center bg-white border-b border-gray-100 h-12">
    <x-header.link href="{{ route('announcement.index') }}"  :active="request()->routeIs('announcement.index')" class="border-none">
        <div class="grid">
            <i class="fa-solid fa-store"></i>
            <small class="text-[8px]">{{ __('Marketplace') }}</small>
        </div>
    </x-header.link>
    <x-header.link href="{{ route('profile.announcement.wishlist') }}" :active="request()->routeIs('profile.announcement.wishlist')" class="border-none">
        <div class="grid">
            <i class="fa-solid fa-heart"></i>
            <small class="text-[8px]">{{ __('Wishlist') }}</small>
        </div>
    </x-header.link>
    <x-header.link href="{{ route('profile.announcement.create') }}" :active="request()->routeIs('profile.announcement.create')" class="border-none">
        <div class="grid">
            <i class="fa-solid fa-circle-plus"></i>
            <small class="text-[8px]">{{ __('Create') }}</small>
        </div>
    </x-header.link>
    <x-header.link href="{{ route('profile.message.index') }}" :active="request()->routeIs('profile.message.index')" class="border-none">
        <div class="grid relative">
            @if ($unreadMessagesCount > 0)
                <p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-1 text-center content-center items-center">{{ $unreadMessagesCount }}</p>
            @endif
            <i class="fa-solid fa-comments"></i>
            <small class="text-[8px]">{{ __('Messages') }}</small>
        </div>
    </x-header.link>
    <x-header.link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.edit')" class="border-none">
        <div class="grid">
            <i class="fa-solid fa-address-card"></i>
            <small class="text-[8px]">{{ __('Profile') }}</small>
        </div>
    </x-header.link>
</nav>
