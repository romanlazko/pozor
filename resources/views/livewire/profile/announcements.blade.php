<x-layout>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="flex items-center">
            <h2 class="text-xl font-bold">
                {{ __('My Announcements') }}
            </h2>
            <select wire:model.live="filter" class="w-min border-none shadow-none focus:ring-0 text-indigo-700 text-lg fotn-light" wire:change="resetPage">
                <option value="all">All</option>
                <option value="marketplace">Marketplace</option>
                <option value="real_estate">Real Estate</option>
            </select>
        </div>
    </x-slot>

    <x-slot name="sidebar">
        <div class="p-4 space-y-3">
            <x-responsive-nav-link wire:navigate :href="route('profile.dashboard')" :active="request()->routeIs('profile.dashboard')">
				{{ __('Dashboard') }}
			</x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate :href="route('profile.announcements')" :active="true">
				{{ __('My Announcements') }}
			</x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
				{{ __('Profile') }}
			</x-responsive-nav-link>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link>
                    <button type="submit">
                        {{ __('Log Out') }}
                    </button>
                </x-responsive-nav-link>
            </form>

            @hasrole('super-duper-admin')
                <hr>
                <x-responsive-nav-link wire:navigate :href="route('admin.marketplace.announcement.index')">
                    {{ __("Admin") }}
                </x-responsive-nav-link>
            @endhasrole
        </div>
    </x-slot>

    <div id="start-of-page" class="p-2 md:p-12 space-y-4 max-w-3xl m-auto">
        @foreach ($announcements as $announcement)
            <livewire:profile.announcements.marketplace-announcement wire:key="{{ $announcement->slug }}" :announcement="$announcement">
        @endforeach
    </div>

    <div class="p-4">
        {{ $announcements->links(data: ['scrollTo' => '#start-of-page']) }}
    </div>
</x-layout>