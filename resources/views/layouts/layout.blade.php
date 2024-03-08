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

        @stack('library')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body>
        <div x-data="{ sidebarOpen: false }" class="flex h-dvh bg-gray-200 font-roboto">
            <div class="flex-1 flex flex-col ">
                @include('layouts.navigation')
                {{ $slot }}
            </div>
        </div>
        
        @if (session('ok') === true)
            <x-notifications.small class="bg-green-400 z-50" :title="session('description')"/>
        @elseif (session('ok') === false)
            <x-notifications.small class="bg-red-400 z-50" :title="session('description')"/>
        @endif
        
    </body>
    @stack('scripts')
</html>