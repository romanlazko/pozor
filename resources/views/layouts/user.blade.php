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
        {{-- <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('recaptcha', {
                    'sitekey' : '6LcRmXkpAAAAADxtOrri4hJzlW5jnwvHb_rIgb2N'
                });
            };
        </script> --}}
        <script async src="https://www.google.com/recaptcha/api.js"></script>

        @stack('library')

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6305828784588130"
     crossorigin="anonymous"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body>
        <livewire:components.empty-component/>
        <div x-data="{ sidebarOpen: false }" class="flex h-dvh bg-gray-200 font-roboto">
            <div class="flex-1 flex flex-col ">
                {{ $slot }}
            </div>
        </div>
        
        @if (session('ok') === true)
            <x-notifications.small class="bg-green-400 z-50" :title="session('description')"/>
        @elseif (session('ok') === false)
            <x-notifications.small class="bg-red-400 z-50" :title="session('description')"/>
        @endif
        {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
        </script> --}}
    </body>
    @stack('scripts')
</html>