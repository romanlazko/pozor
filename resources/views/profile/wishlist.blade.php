<x-body-layout :title="__('components.navigation.wishlist')" class="w-full max-w-7xl m-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('components.navigation.wishlist') }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        <x-nav.profile/>
    </x-slot>

    <x-announcement.list :announcements="$announcements" :cols="4" class="py-5"/>
</x-body-layout>