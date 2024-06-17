<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Wishlist") }}
        </h2>
    </x-slot>

    <section class="lg:flex w-full space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
        <div class="w-full space-y-6">
            <div class="w-full grid grid-cols-1 gap-6">
                @foreach ($announcements as $index => $announcement)
                    <x-announcement-card :announcement="$announcement" @class(['rounded-b-lg' => $loop->last, 'rounded-t-lg' => $loop->first])/>
                @endforeach
            </div>
        </div>
    </section>
</x-profile-layout>