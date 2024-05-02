<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-hidden">
    <head>
        {{ header('Access-Control-Allow-Origin: http://127.0.0.1:8001'); }}
        {{-- {{header('Access-Control-Allow-Origin', '*');}} --}}
        {{header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');}}
        {{header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/f4c6764ec6.js" crossorigin="anonymous"></script>
        <script async src="https://www.google.com/recaptcha/api.js"></script>
        @livewireStyles
        @filamentStyles
        @vite(['resources/css/app.css'])
    </head>
    
    <body x-data="{ sidebarOpen: false }" class="flex h-dvh font-roboto bg-gray-50">
        
        {{-- <div > --}}
            <div class="flex-1 flex flex-col ">
                <div class="w-full hidden lg:block">
                    @include('layouts.header')
                </div>
                
                <div class="flex overflow-hidden grow mx-auto w-[100vw] h-full">
                    <x-sidebar>
                        <div class="p-4 space-y-3">
                            <x-responsive-nav-link wire:navigate :href="route('profile.dashboard')" :active="request()->routeIs('profile.dashboard')">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link wire:navigate :href="route('profile.announcement.index')" :active="request()->routeIs('profile.announcement.*')">
                                {{ __('My Announcements') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link wire:navigate :href="route('message.index')" :active="request()->routeIs('message.*')">
                                {{ __('Messages') }}
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
                    
                    <div class="flex flex-1 flex-col overflow-hidden">
                        
                        @if (isset($header))
                            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between" x-data="{ headerOpen: false }">
                                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                {{ $header }}
                            </div>
                        @else 
                            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between" x-data="{ headerOpen: false }">
                                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $title ?? __('Profile') }}
                                </h2>
                            </div>
                        @endif
                        
                        <main id="main-block"  class="w-full overflow-y-auto p-2 sm:p-4 space-y-4 h-full">
                            {{ $slot }}
                        </main>

                        @if (isset($footer))
                            <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white ">
                                {{ $footer }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-full lg:hidden block">
                    @include('layouts.footer')
                </div>
            </div>
        {{-- </div> --}}
        
        @if (session('ok') === true)
            <x-notifications.small class="bg-green-400 z-50" :title="session('description')"/>
        @elseif (session('ok') === false)
            <x-notifications.small class="bg-red-400 z-50" :title="session('description')"/>
        @endif
    </body>
    @livewireScripts
    @filamentScripts
    @vite(['resources/js/app.js'])
    @stack('scripts')
</html>