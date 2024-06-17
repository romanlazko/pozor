@php
    $title = $category?->translated_name ?? __("Latest announcements:");
@endphp
<x-body-layout :title="$title">

    @if ($category)
        <x-slot name="meta">
            {!! seo($category) !!}
        </x-slot>
    @endif
    

    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>

    <x-slot name="sidebar">
        <livewire:announcement.filters :search="$data" :category="$category"/>
    </x-slot>
    
    <x-slot name="header">
        
        <div class="w-full space-y-3 p-2 md:p-0">
            <div class="sticky top-0 z-30 bg-white ">
                <div class="w-full">
                    <div class="space-x-1 text-sm w-full">
                        <a href="{{ route('announcement.index') }}" class="text-blue-500 inline-block">
                            <span class="hover:underline">
                                {{ __("Main page") }}
                            </span>
                        </a>
                        
                        @foreach ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
                            <a href="{{ route('announcement.index', ['category' => $parent->slug]) }}" class="text-gray-500 space-x-1 inline-block">
                                <span>
                                    >
                                </span>
                                <span class="hover:underline hover:text-blue-500">
                                    {{ $parent->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- @if ($category ) 
                <a href="{{ route('announcement.index', ['category' => $category?->parent?->slug]) }}" class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            @endif --}}
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach ($categories as $child)
                    <a 
                        href="{{ route('announcement.index', ['category' => $child->slug]) }}"
                        @class([
                            'p-2 bg-white rounded-lg text-sm border overflow-hidden inline-block hover:border-gray-800', 
                            'border-gray-800' => $category?->slug === $child->slug
                        ])
                    >
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 min-h-8 min-w-8">
                                <img src="{{ $child->getFirstMediaUrl('categories', 'thumb') }}" alt="" class="float-right">
                            </div>
                            <div class="grid">
                                <span class="w-full font-bold">
                                    {{ $child->name }}
                                </span>
                                <span class="w-full text-xs text-gray-500">
                                    {{ $child->announcements_count }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </x-slot>

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-0 z-30 bg-white p-2 md:p-0 border-b lg:border-none">
        <button @click="sidebarOpen = true" class="text-gray-900 hover:text-indigo-700 text-xl lg:hidden">
            <i class="fa-solid fa-magnifying-glass text-xl "></i>
        </button>
        <h2 class="text-xl lg:text-3xl font-bold">
            {{ $category?->name ?? __("Latest announcements")}} <span class="text-gray-500">{{ $category?->announcements_count }}</span>
        </h2>
        <div x-data="{ dropdownOpen: false }"  class="relative lg:hidden">
            <button @click="dropdownOpen = ! dropdownOpen" class="text-gray-900 hover:text-indigo-700 text-xl ">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

            <x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <div class="w-full grid grid-cols-1 sm:w-4/5" >
            @foreach ($announcements as $index => $announcement)
                <x-announcement-card :announcement="$announcement" @class(['rounded-b-lg' => $loop->last, 'rounded-t-lg' => $loop->first])/>
            @endforeach
        </div>

        <div class="p-4">
            {{ $announcements->onEachSide(1)->links() }}
        </div>
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>