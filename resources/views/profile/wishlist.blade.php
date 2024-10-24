<x-body-layout :title="__('Wishlist')" class="w-full max-w-7xl m-auto">
    <x-slot name="sidebar">
        <x-profile-nav/>
    </x-slot>
    <x-announcement-list :announcements="$announcements" :cols="4">
        <x-slot name="header">
            <h2 class="text-xl lg:text-3xl font-bold">
                {{ __("Wishlist") }}
            </h2>
        </x-slot>
    </x-announcement-list>
</x-body-layout>