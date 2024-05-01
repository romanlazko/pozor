<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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
    
    <body>
        <livewire:components.empty-component/>
        <div x-data="{ sidebarOpen: false }" class="flex h-dvh bg-gray-200 font-roboto">
            @include('layouts.sidebar')
            
            <div class="flex-1 flex flex-col overflow-hidden">
                @if (isset($header))
                    <div class="bg-white" x-data="{ headerOpen: false }">
                        <div class="flex lg:grid w-full px-2 md:px-4 min-h-[50px] items-center py-1 space-x-2 lg:space-x-0 justify-between lg:justify-normal">
                            {{ $header }}
                        </div>
                        <hr>
                    </div>
                @endif
                
                <main class="flex-1 overflow-y-auto bg-gray-200">
                    <div class="mx-auto p-1">
                        {{ $slot }}
                    </div>
                </main>

                @if (isset($footer))
                    <div class="bg-white">
                        <div class="flex w-full m-auto px-4 sm:px-6 lg:px-8 items-center justify-between">
                            {{ $footer }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
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