<nav class="bg-white border-b border-gray-100 px-2">
    <div class="flex w-full max-w-lg m-auto justify-between shrink-0 items-center py-1">
        <x-header.link href="{{ route('announcement.index') }}" wire:navigate :active="request()->routeIs('announcement.index')">
            <i class="fa-solid fa-store"></i>
        </x-header.link>
        <x-header.link href="{{ route('profile.announcement.create') }}" wire:navigate :active="request()->routeIs('profile.announcement.create')" class="bg-indigo-700 text-white">
            <i class="fa-solid fa-plus"></i>
        </x-header.link>
        <x-header.link href="{{ route('profile.edit') }}" wire:navigate :active="request()->routeIs('profile.*')">
            <i class="fa-solid fa-address-card"></i>
        </x-header.link>
    </div>
</nav>
