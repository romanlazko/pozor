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

    @if ($category)
        <x-slot name="sidebar">
            <livewire:announcement.filters :filters="$data['filters'] ?? null" :category="$category"/>
        </x-slot>
    @endif
    
    <x-slot name="header">
        <x-category-list :data="$data ?? null" :category="$category ?? null" :categories="$categories ?? null" />
    </x-slot>

    <div class="w-full items-center justify-between flex space-x-3 lg:space-x-0 sticky top-12 lg:relative lg:top-0 z-30 p-2 lg:p-0 border-b lg:border-none bg-gray-50">
        <div class="w-full text-start">
            <div class="w-full justify-between">
                <h2 class="text-xl lg:text-3xl font-bold ">
                    {{ $category?->name ?? __("All announcements:") }} <span class="text-gray-500">{{ $category?->announcements_count }}</span>
                </h2>
                <form action="{{ route('announcement.search', ['category' => $category?->slug]) }}">
                    <select name="sort" class="border-none py-0 pl-0 shadow-none focus:ring-0 text-indigo-700 fotn-light bg-transparent" onchange="this.form.submit()">
                        @foreach (App\Enums\Sort::cases() as $sort)
                            <option value="{{ $sort->value }}" @selected($data['sort'] == $sort)>{{ $sort->getLabel() }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="space-y-6 px-2 lg:px-0">
        <x-announcement-list :announcements="$announcements" :cols="$category ? 3 : 4"/>
    </div>

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>