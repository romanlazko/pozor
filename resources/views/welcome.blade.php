<x-user-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full gap-2">
            <h2 class="text-xl font-bold">
                Latest announcements:
            </h2>
        </div>
    </x-slot>

    <x-slot name="sidebar">
    </x-slot>

    <div class="relative p-2 space-y-3">
        @foreach ($categories as $child)
            <a href="{{ route('announcement.index', $child->slug) }}" class="my-0.5 inline-block p-1.5 xl:p-2.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600">
                {{ $child->name }}
            </a>
        @endforeach

        <div id="start-of-page" class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2" >
            @foreach ($announcements as $index => $announcement)
                <a class="overflow-hidden group transition ease-in-out duration-150 rounded-lg" href="{{ route('announcement.show', $announcement) }}">
                    <img class="w-full aspect-square object-cover rounded-lg bg-white group-hover:border-2 border-indigo-700" 
                        src="{{ asset('storage/' . ($announcement->attachments->first()?->src ?? '')) }}" 
                        alt=""
                    >

                    <div class="">
                        <h2 class="text-base font-bold w-full">
                            {{ $announcement->current_price }} {{ $announcement->currency->name }} 
                        </h2>
                        <p class="text-sm">
                            {{ $announcement->title }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $announcement->location['name'] ?? null }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="p-4">
            {{ $announcements->onEachSide(1)->links() }}
        </div>
    </div>
</x-user-layout>
    