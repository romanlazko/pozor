<x-body-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>
    
    {{ $slot }}

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>