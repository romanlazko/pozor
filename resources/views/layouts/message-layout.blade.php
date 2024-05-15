<x-base-layout>
    <div class="w-full hidden lg:block fixed top-0 h-10 bg-black">
        @include('layouts.header')
    </div>
    
    <div class="pb-0 pt-0 lg:pt-10 lg:pb-0 min-h-screen flex w-full h-full">
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
        
        <div class="w-full sm:ml-72 xl:ml-96 h-full min-h-screen flex-1 flex flex-col">
            @if (isset($header))
                <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 sticky md:top-10 top-0 bg-gray-50">
                    <div class="flex items-center justify-between space-x-3">
                        {{ $header }}
                    </div>
                </div>
            @endif
            
            <main id="main-block" class="w-full space-y-4 min-h-full flex-1" >
                {{ $slot }}
            </main>

            @if (isset($footer))
                <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white sticky bottom-0">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</x-base-layout>