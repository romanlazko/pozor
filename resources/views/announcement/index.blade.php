<x-user-layout>
    <x-slot name="header">
        <div class="w-full relative">
            <div class="w-full items-center justify-between flex space-x-3">
                <h2 class="text-xl font-bold">
                    {{ __("Latest announcements:") }}
                </h2>
            </div>
        </div>
    </x-slot>

    <x-slot name="sidebar">
    </x-slot>

    <div class="p-2 space-y-3 w-full">
        
        <div class="w-full overflow-auto lg:overflow-hidden flex flex-nowrap lg:flex-wrap">
            @foreach ($categories as $child)
                <a href="{{ route('announcement.search', $child->slug) }}" class="m-0.5 p-1.5 xl:p-2.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 whitespace-nowrap">
                    {{ $child->name }}
                </a>
            @endforeach
        </div>

        <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2" >
            @foreach ($announcements as $index => $announcement)
                <x-announcement-card :announcement="$announcement" />
            @endforeach
        </div>
        <div class="p-4">
            {{ $announcements->onEachSide(1)->links() }}
        </div>
    </div>
</x-user-layout>