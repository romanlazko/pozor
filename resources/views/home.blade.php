<x-body-layout>
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>
    
    <x-slot name="header">
        <div class="w-full space-y-24 py-12">
            <div class="max-w-2xl m-auto space-y-12">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-500 to-purple-800 text-transparent bg-clip-text">
                    {{ __("Buy, Sell, Discover") }} <br> {{ __("Everything you need in one place") }}
                </h1>

                <x-search :location="$request->location"/>
            </div>
            
            <div class="space-y-6">
                <h2 class="text-xl text-gray-800 text-left font-semibold">
                    View our range of <span class="text-indigo-700 font-bold">categories</span>:
                </h2>
                
                <x-categories :categories="$categories"/>
            </div>
        </div>
    </x-slot>

    <x-announcement-list :announcements="$announcements" :cols="5">
        <x-slot name="header">
            <h2 class="text-xl lg:text-3xl font-bold">
                {{ __("All announcements:") }} <span class="text-gray-500">{{ $announcements->total() }}</span>
            </h2>
        </x-slot>
    </x-announcement-list>


    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>