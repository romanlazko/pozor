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
                    @if (isset($sidebar))
                        <x-sidebar>
                            {{ $sidebar }}
                        </x-sidebar>
                    @endif
                    
                    
                    <div class="flex flex-1 flex-col overflow-hidden ">
                        
                        @if (isset($header))
                            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between" x-data="{ headerOpen: false }">
                                {{ $header }}
                            </div>
                        @endif
                        
                        <main id="main-block"  class="w-full overflow-y-auto max-w-[1800px] mx-auto" wire:scroll>
                            {{ $slot }}
                        </main>
                
                        @if (isset($footer))
                            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between bg-white ">
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