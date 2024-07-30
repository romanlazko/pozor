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
        
        <div class="w-full space-y-3">
            <div class="sticky top-0 z-30 bg-gray-50">
                <div class="w-full overflow-auto">
                    <div class="space-x-1 text-sm w-full whitespace-nowrap">
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
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @foreach ($categories as $child)
                    <a 
                        href="{{ route('announcement.index', ['category' => $child->slug]) }}"
                        @class([
                            'p-2 bg-white rounded-lg text-sm border hover:border-indigo-700 items-center ', 
                            'border-indigo-700' => $category?->slug === $child->slug
                        ])
                    >
                        <div class="flex items-center space-x-2 m-auto h-full">
                            <div class="w-12 h-12 min-h-12 min-w-12">
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

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-0 z-30 p-2 lg:p-0 border-b lg:border-none bg-gray-50">
        <button @click="sidebarOpen = true" class="text-gray-900 hover:text-indigo-700 text-xl lg:hidden">
            <i class="fa-solid fa-magnifying-glass text-xl "></i>
        </button>

        <div class="w-full text-center lg:text-start">
            <p class="text-gray-500">{{ $category?->children->isEmpty() ? $category?->parent?->name : '' }}</p>
            <div class="w-full lg:flex items-center lg:justify-between">
                <h2 class="text-xl lg:text-3xl font-bold ">
                    {{ $category?->name ?? __("Latest announcements:") }} <span class="text-gray-500">{{ $category?->announcements_count }}</span>
                </h2>
                <form action="{{ route('announcement.index', ['category' => $category?->slug]) }}" method="get">
                    <select name="sort" class="border-none py-0 shadow-none focus:ring-0 text-indigo-700 fotn-light bg-transparent" onchange="this.form.submit()">
                        @foreach (App\Enums\Sort::cases() as $sort)
                            <option value="{{ $sort->name }}" @selected(request('sort') == $sort->name)>{{ $sort->getLabel() }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            
        </div>

        <div x-data="{ dropdownOpen: false }"  class="relative lg:hidden">
            <button @click="dropdownOpen = ! dropdownOpen" class="text-gray-900 hover:text-indigo-700 text-xl ">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"></div>

            <x-profile-nav x-cloak x-show="dropdownOpen" class="absolute right-0 z-20 mt-2 p-0 overflow-hidden bg-white rounded-md shadow-xl border"/>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <div class="w-full grid grid-cols-1 sm:w-4/5 gap-3" >
            @foreach ($announcements as $index => $announcement)
                <x-announcement-card :announcement="$announcement" @class(['rounded-lg'])/>
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