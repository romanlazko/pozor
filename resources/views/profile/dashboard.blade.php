<div>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        <div class="p-4 space-y-3">
            <x-responsive-nav-link wire:navigate :href="route('profile.dashboard')" :active="request()->routeIs('profile.dashboard')">
				{{ __('Dashboard') }}
			</x-responsive-nav-link>
            {{-- <x-responsive-nav-link wire:navigate :href="route('profile.announcement')" :active="request()->routeIs('profile.announcement')">
				{{ __('My Announcements') }}
			</x-responsive-nav-link> --}}
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
                <x-responsive-nav-link wire:navigate :href="route('admin.category.index')">
                    {{ __("Admin") }}
                </x-responsive-nav-link>
            @endhasrole
        </div>
    </x-slot>

    <div class="py-12">
    </div>
</div>