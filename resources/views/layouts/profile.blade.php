<x-base-layout>
    <div class="w-full hidden lg:block fixed top-0 h-10 bg-black">
        @include('layouts.header')
    </div>
    
    <div class="pb-10 pt-0 lg:pt-10 lg:pb-0 min-h-screen flex w-full h-full">
        <aside id="default-sidebar" class="fixed left-0 z-40 h-full" aria-label="Sidebar">
            <x-sidebar>
                <div class="p-4 space-y-3">
                    <x-responsive-nav-link wire:navigate :href="route('profile.announcement.index')" :active="request()->routeIs('profile.announcement.*')">
                        {{ __('My Announcements') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link wire:navigate :href="route('profile.message.index')" :active="request()->routeIs('profile.message.*')" class="flex items-center space-x-3">
                        <p>
                            {{ __('Messages') }} 
                        </p>
                        @if (auth()->user()->unreadMessagesCount > 0)
                            <p class="text-xs text-white w-5 h-5 rounded-full bg-blue-500 text-center content-center items-center">{{ auth()->user()->unreadMessagesCount }}</p>
                        @endif
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
                        <x-responsive-nav-link wire:navigate :href="route('admin.announcement')">
                            {{ __("Admin") }}
                        </x-responsive-nav-link>
                    @endhasrole
                </div>
            </x-sidebar>
        </aside>
        
        <div class="w-full lg:ml-72 xl:ml-96 h-full flex-1 flex flex-col">
            @if (isset($header))
                <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 sticky lg:top-10 top-0 bg-gray-50" x-data="{ headerOpen: false }">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="flex items-center justify-between space-x-3">
                        {{ $header }}
                    </div>
                </div>
            @endif
            
            <main id="main-block" class="w-full space-y-4 h-full flex-1" >
                {{ $slot }}
            </main>

            @if (isset($footer))
                <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white sticky bottom-10 md:bottom-0">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>

    <div class="w-full lg:hidden block fixed bottom-0 h-10">
        @include('layouts.footer')
    </div>
</x-base-layout>