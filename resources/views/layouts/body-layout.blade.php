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

        <!-- Scripts -->
        <script async src="https://www.google.com/recaptcha/api.js"></script>
        <script src="https://telegram.org/js/telegram-web-app.js"></script>
        @livewireStyles
        @filamentStyles
        @vite(['resources/css/app.css'])
    </head>
    
    <body class="font-roboto bg-gray-50 min-h-dvh flex flex-col flex-1" x-data="{ sidebarOpen: false }" :class="sidebarOpen ? 'overflow-hidden' : ''">
        <livewire:components.empty-component/>
        
        @if (isset($headerNavigation))
            <div class="w-full hidden lg:block fixed top-0 h-12 bg-black z-40">
                {{ $headerNavigation }}
            </div>
        @endif

        <div @class(['flex w-full flex-1 flex-col', 'pt-0 lg:pt-12' => isset($headerNavigation), 'pb-10 lg:pb-0' => isset($footerNavigation)])>
            @if (isset($sidebar))
                <div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity  bg-black opacity-50 lg:hidden"></div>
                <aside x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="lg:mt-12 fixed inset-y-0 left-0 z-50 w-full sm:w-72 xl:w-96 transition duration-300 transform lg:translate-x-0 lg:inset-0 bg-gray-100 border-r" aria-label="Sidebar">
                    <x-sidebar>
                        {{ $sidebar }}
                    </x-sidebar>
                </aside>
            @endif

            <div @class(['w-full h-full flex-1 flex flex-col', 'lg:pl-72 xl:pl-96' => isset($sidebar)])>
                @if (isset($header))
                    <div class="flex w-full px-2 min-h-10 items-center py-1 space-x-2 bg-gray-50 z-30 sticky lg:top-12 top-0" x-data="{ headerOpen: false }">
                        <div class="flex items-center justify-between space-x-3 w-full">
                            {{ $header }}
                        </div>
                    </div>
                @endif

                <main id="main-block" class="w-full space-y-4 flex-1 h-full p-2">
                    {{ $slot }}
                </main>

                @if (isset($footer))
                    <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white sticky bottom-0">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>

        @if (isset($footerNavigation))
            <div class="w-full lg:hidden block fixed bottom-0 h-10 z-40">
                {{ $footerNavigation }}
            </div>
        @endif
        
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