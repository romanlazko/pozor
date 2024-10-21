<x-profile-layout>
    <x-announcement-list :announcements="$announcements" :cols="4">
        <x-slot name="header">
            <h2 class="text-xl lg:text-3xl font-bold">
                {{ __("Wishlist") }}
            </h2>
        </x-slot>
    </x-announcement-list>
</x-profile-layout>