<x-body-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>
    
    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>


    @if (isset($header))
        <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 p-2 lg:p-0 border-b lg:border-none">
            <div class="flex items-center justify-between space-x-3">
                {{ $header }}
            </div>
        </div>
    @endif

    <div class="space-y-6 px-2 lg:px-0 py-6">
        {{ $slot }}
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>

</x-body-layout>