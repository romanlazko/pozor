<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Wishlist") }}
        </h2>
    </x-slot>

    <section class="lg:flex w-full space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
        <x-announcement-list :announcements="$announcements" :cols="3"/>
    </section>
</x-profile-layout>