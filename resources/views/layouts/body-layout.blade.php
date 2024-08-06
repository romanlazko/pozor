<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ ($title ? $title." | ": null) . config('app.name') }}</title> --}}

        <meta http-equiv="cleartype" content="on">
        <meta data-rh="true" property="og:type" content="website">
        <meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}">
        <meta data-rh="true" property="og:locale" content="{{ app()->getLocale() }}">

        @if (isset($meta))
            {{ $meta }}
        @else
            {!! seo() !!}
        @endif

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/f4c6764ec6.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @stack('headerScripts')
        @livewireStyles
        @filamentStyles
        @vite(['resources/css/app.css'])
    </head>
    
    <body class="font-roboto bg-gray-50 min-h-dvh flex flex-col flex-1" x-data="{ sidebarOpen: false }" :class="sidebarOpen ? 'overflow-hidden' : ''">
        <livewire:components.empty-component/>

        <div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity  bg-black opacity-50 lg:hidden"></div>

        @if (isset($headerNavigation))
            <div class="w-full  bg-gray-900 block fixed top-0 h-12 z-40 px-3">
                {{ $headerNavigation }}
            </div>
        @endif
        
        <div @class(['w-full max-w-7xl mx-auto h-full relative flex flex-1 flex-col px-0 lg:px-2', 'pt-12 lg:pt-24' => isset($headerNavigation), 'pb-24 lg:pb-0' => isset($footerNavigation)])>
            @if (isset($header))
                <div class="flex w-full min-h-10 items-center space-x-2 z-30 bg-gray-50 px-2 lg:px-0" x-data="{ headerOpen: false }">
                    {{ $header }}
                </div>
            @endif
            <div class='flex flex-1 flex-col relative lg:py-6 h-full'>
                @if (isset($sidebar))
                    <aside x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="lg:py-6 fixed lg:absolute inset-y-0 left-0 z-50 lg:z-30 w-full lg:w-[18rem] xl:w-[24rem] transition duration-300 transform lg:translate-x-0 lg:inset-0" aria-label="Sidebar">
                        <x-sidebar class="lg:rounded-lg border bg-white h-full lg:h-min">
                            {{ $sidebar }}
                        </x-sidebar>
                    </aside>
                @endif
    
                <div @class(['w-full h-full flex-1 flex flex-col relative space-y-6', 'lg:pl-[19rem] xl:pl-[25rem]' => isset($sidebar)])>
    
                    <main id="main-block" class="w-full space-y-4 flex-1 flex-col flex">
                        {{ $slot }}
                    </main>
    
                    @if (isset($footer))
                        <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white sticky bottom-0 lg:rounded-lg shadow-lg border">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (isset($footerNavigation))
            <div class="w-full lg:hidden block fixed bottom-0 h-12 z-40 border-t ">
                {{ $footerNavigation }}
            </div>
        @endif
        
        @if (session('ok') === true)
            <x-notifications.small class="bg-green-600 z-50" :title="session('description')"/>
        @elseif (session('ok') === false)
            <x-notifications.small class="bg-red-600 z-50" :title="session('description')"/>
        @endif
    </body>

    @livewireScripts
    @filamentScripts
    @vite(['resources/js/app.js'])
    @stack('scripts')
</html>