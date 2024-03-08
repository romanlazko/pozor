<x-layout>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select type of announcement:') }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        <div class="p-4 space-y-3">
            <x-responsive-nav-link wire:navigate :href="route('profile.dashboard')" :active="request()->routeIs('profile.dashboard')">
				{{ __('Dashboard') }}
			</x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate :href="route('profile.announcements')" :active="request()->routeIs('profile.announcements')">
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

    <div class="p-4 md:p-12 md:flex md:space-x-12 w-full space-y-6 md:space-y-0">
        <a href="{{ route('profile.marketplace.create') }}" wire:navigate class="block w-full bg-white rounded-xl shadow-2xl p-6 space-y-4 group hover:bg-gray-100 hover:scale-105 transition ease-in-out duration-150">
            <div class="flex space-x-1 items-center">
                <i class="fa-solid fa-store text-2xl group-hover:text-indigo-600"></i>
                <h2 class="font-bold">{{ __("Marketplace") }}</h2>
            </div>
            <p class="text-gray-500 text-sm">
                {{ __("Announcement for marketplace") }}
            </p>
        </a>
        <a href="{{ route('profile.real-estate.create') }}" wire:navigate class="block w-full bg-white rounded-xl shadow-2xl p-6 space-y-4 group hover:bg-gray-100 hover:scale-105 transition ease-in-out duration-150">
            <div class="flex space-x-1 items-center">
                <i class="fa-solid fa-house-circle-check text-2xl group-hover:text-indigo-600"></i>
                <h2 class="font-bold">{{ __("Real Estate") }}</h2>
            </div>
            <p class="text-gray-500 text-sm">
                {{ __("Announcement for sosedi") }}
            </p>
        </a>
        <a href="" class="block w-full bg-white rounded-xl shadow-2xl p-6 space-y-4 group hover:bg-gray-100 hover:scale-105 transition ease-in-out duration-150">
            <div class="flex space-x-1 items-center">
                <i class="fa-solid fa-briefcase text-2xl group-hover:text-indigo-600"></i>
                <h2 class="font-bold">{{ __("Prace") }}</h2>
            </div>
            <p class="text-gray-500 text-sm">
                {{ __("Announcement for prace") }}
            </p>
        </a>
    </div>
</x-layout>