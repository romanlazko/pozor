<x-body-layout>
    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>
    
    <x-slot name="sidebar">
        <div class="p-4 space-y-3">
            <x-responsive-nav-link  :href="route('profile.announcement.index')" :active="request()->routeIs('profile.announcement.*')">
                {{ __('My Announcements') }}
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
                <x-responsive-nav-link  :href="route('admin.announcement')">
                    {{ __("Admin") }}
                </x-responsive-nav-link>
            @endhasrole
        </div>
    </x-slot>

    @if (isset($header))
        <x-slot name="header">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="flex items-center justify-between space-x-3">
                {{ $header }}
            </div>
        </x-slot>
    @endif
    
    {{ $slot }}

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>

</x-body-layout>