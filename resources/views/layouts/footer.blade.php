<nav class="bg-white border-b border-gray-100 px-2">
    <div class="flex w-full max-w-lg m-auto justify-between shrink-0 items-center py-1">
        <x-header.link href="{{ route('announcement.index') }}" wire:navigate :active="request()->routeIs('announcement.index')" class="border-none">
            <div class="grid">
                <i class="fa-solid fa-store"></i>
                <small class="text-[8px]">{{ __('Marketplace') }}</small>
            </div>
        </x-header.link>
        <x-header.link href="" wire:navigate :active="request()->routeIs('profile.message.*')" class="border-none">
            <div class="grid">
                <i class="fa-solid fa-heart"></i>
                <small class="text-[8px]">{{ __('Wishlist') }}</small>
            </div>
        </x-header.link>
        <x-header.link href="{{ route('profile.announcement.create') }}" wire:navigate :active="request()->routeIs('profile.announcement.*')" class="border-none">
            <div class="grid">
                <i class="fa-solid fa-circle-plus"></i>
                <small class="text-[8px]">{{ __('Create') }}</small>
            </div>
        </x-header.link>
        <x-header.link href="{{ route('profile.message.index') }}" wire:navigate :active="request()->routeIs('profile.message.index')" class="border-none">
            <div class="grid relative">
                @if (auth()->user()?->unreadMessagesCount > 0)
					<p class="absolute text-[8px] text-white w-3 h-3 rounded-full bg-red-500 top-1 text-center content-center items-center">{{ auth()->user()->unreadMessagesCount }}</p>
				@endif
                <i class="fa-solid fa-comments"></i>
                <small class="text-[8px]">{{ __('Messages') }}</small>
            </div>
        </x-header.link>
        <x-header.link href="{{ route('profile.edit') }}" wire:navigate :active="request()->routeIs('profile.edit')" class="border-none">
            <div class="grid">
                <i class="fa-solid fa-address-card"></i>
                <small class="text-[8px]">{{ __('Profile') }}</small>
            </div>
        </x-header.link>
    </div>
</nav>
