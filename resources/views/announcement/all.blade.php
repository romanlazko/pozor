@php
    $title = $category?->translated_name ?? __("Latest announcements:");
@endphp

<x-body-layout :title="$title">
    @if ($category)
        <x-slot name="meta">
            {!! seo()->for($category) !!}
        </x-slot>
    @endif
    
    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <x-slot name="sidebar">
        <livewire:announcement.filters :filters="$request->filters ?? null" :category="$category"/>
    </x-slot>
    
    <x-slot name="header">
        <div class="w-full space-y-6">
            <div class="max-w-2xl m-auto">
                <x-search :category="$category" :search="$request->search ?? null" :filterButton="true" :location="$request->location ?? null"/>
            </div>
        
            <x-breadcrumbs :category="$category"/>
            
            <x-categories :categories="$categories" :category="$category"/>
        </div>
    </x-slot>

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-12 lg:relative lg:top-0 z-20 p-2 lg:p-0 border-b lg:border-none bg-white">
        <div class="w-full text-start">
            <div class="w-full flex justify-between items-center">
                <h2 class="text-xl lg:text-3xl font-bold ">
                    {{ $category?->name ?? __("All announcements:") }} <span class="text-gray-500">{{ $paginator->total() }}</span>
                </h2>
                <form action="{{ route('announcement.search', ['category' => $category?->slug]) }}">
                    <div class="w-full flex items-center space-x-2 ">
                        <label for="sort" class="text-gray-500 text-sm">{{ __('Sort by:') }}</label>
                        <select name="sort" class="border-none py-0 pl-0 shadow-none focus:ring-0 text-gray-800 font-bold bg-transparent text-sm" onchange="this.form.submit()">
                            @foreach ($sortableAttributes as $attribute)
                                <option value="{{ $attribute->name }}:desc" @selected($request->sort == $attribute->name.":desc")>{{ $attribute->label }}: {{ __('from high to low') }} </option>
                                <option value="{{ $attribute->name }}:asc" @selected($request->sort == $attribute->name.":asc")>{{ $attribute->label }}: {{ __('from low to high') }} </option>
                            @endforeach
                        </select>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <x-announcement-list :announcements="$announcements" :cols="3" :paginator="$paginator"/>
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>