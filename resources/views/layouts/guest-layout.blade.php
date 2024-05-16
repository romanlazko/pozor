<x-body-layout>
    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>
    
    {{ $slot }}

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>