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
        <div class="w-full relative">
            <div class="w-full">
                <div class="flex flex-nowrap">
                    @if ($category)
                        <a href="{{ route('announcement.index') }}" class="text-xs text-gray-500">
                            <span class="hover:underline hover:text-indigo-700">
                                {{ __("Main page") }}
                            </span>
                            >
                        </a>
                    @endif
                    
                    @foreach ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
                        @if (!$loop->last)
                            <a href="{{ route('announcement.index', ['category' => $parent->slug]) }}" class="text-xs text-gray-500">
                                <span class="hover:underline hover:text-indigo-700">
                                    {{ $parent->translated_name }}
                                </span>
                                >
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="w-full items-center justify-between flex space-x-3">
                <div class="flex items-center space-x-2">
                    @if ($category)
                        <a href="{{ route('announcement.index', ['category' => $category?->parent?->slug]) }}" class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    @endif

                    <h2 class="text-xl font-bold">
                        {{ $category?->translated_name ?? __("Latest announcements:")}} <span class="text-gray-500">{{ $category?->announcements_count }}</span>
                    </h2>
                </div>

                <button @click="sidebarOpen = true" class="text-xs text-gray-900 focus:outline-none lg:hidden whitespace-nowrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>
                        {{ __("Search") }}
                    </span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-3">
        <div class="w-full overflow-auto space-x-1 whitespace-nowrap">
            @foreach ($categories as $child)
                <a href="{{ route('announcement.index', ['category' => $child->slug]) }}" class="p-2 bg-gray-800 rounded-lg text-white text-sm hover:bg-gray-700 overflow-hidden inline-block">
                    <div class="flex-col h-full flex ">
                        <div class="flex flex-1">
                            {{ $child->translated_name }}
                        </div>
                        {{-- <div class="w-full">
                            <div class="w-24 float-right ">
                                <img src="{{ $child->getFirstMediaUrl('categories', 'thumb') }}" alt="" class="float-right">
                            </div>
                        </div> --}}
                    </div>
                </a>
            @endforeach
        </div>

        <div class="w-full grid grid-cols-1 gap-6 sm:w-4/5" >
            @foreach ($announcements as $index => $announcement)
                <x-announcement-card :announcement="$announcement" />
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