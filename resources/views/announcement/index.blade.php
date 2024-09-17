@php
    $title = $category?->translated_name ?? __("Latest announcements:");
@endphp

<x-body-layout :title="$title">
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>
    
    <x-slot name="header">
        <div class="w-full space-y-24 py-12">
            <div class="max-w-2xl m-auto space-y-12">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-500 to-purple-800 text-transparent bg-clip-text">
                    Buy, Sell, Discover<br> Everything you need in one place
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

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-12 lg:relative lg:top-0 z-30 p-2 lg:p-0 border-b lg:border-none bg-white">
        <div class="w-full text-start">
            <div class="w-full justify-between">
                <h2 class="text-xl lg:text-3xl font-bold ">
                    {{ __("All announcements:") }} <span class="text-gray-500">{{ $announcements->total() }}</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <x-announcement-list :announcements="$announcements" :cols="4"/>
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>