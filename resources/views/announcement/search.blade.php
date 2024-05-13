<x-user-layout>
    <x-slot name="header">
        <div class="w-full relative">
            <div class="w-full">
                <div class="flex flex-nowrap">
                    <a href="{{ route('announcement.index') }}" class="text-xs text-gray-500">
                        <span class="hover:underline hover:text-indigo-700">
                            Main page
                        </span>
                        >
                    </a>
                    @foreach ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
                        @if (!$loop->last)
                            <a href="{{ route('announcement.search', $parent->slug) }}" class="text-xs text-gray-500">
                                <span class="hover:underline hover:text-indigo-700">
                                    {{ $parent->name }}
                                </span>
                                >
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="w-full items-center justify-between flex space-x-3">
                <div class="flex items-center space-x-2">
                    <a href="{{ $category?->parent ? route('announcement.search', $category?->parent?->slug) : route('announcement.index') }}" class="my-0.5 inline-block p-1.5 bg-gray-800 rounded-lg text-white text-xs xl:text-sm hover:bg-gray-600 h-min">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    
                    <h2 class="text-xl font-bold">
                        {{ $category?->name ?? __("Latest announcements:")}}
                    </h2> 
                </div>
                <button @click="sidebarOpen = true" class="text-xs text-gray-900 focus:outline-none lg:hidden whitespace-nowrap">
                    <i class="fa-solid fa-filter"></i>
                    <span>
                        Filters
                    </span>
                </button>
            </div>
        </div>
    </x-slot>

    <x-slot name="sidebar">
        <livewire:announcement.index :search="$data" :category="$category"/>
    </x-slot>

    <div class="p-2 space-y-3">
        <div class="w-full overflow-auto space-x-1 whitespace-nowrap">
            @foreach ($categories as $child)
                <a href="{{ route('announcement.search', $child->slug) }}" class="m-0.5 bg-gray-200 rounded-lg border-2 text-black text-sm hover:border-indigo-700 overflow-hidden inline-block h-24">
                    <div class="flex-col h-full flex pt-2 pl-2">
                        <div class="flex flex-1 pr-2">
                            {{ $child->translated_name }}
                        </div>
                        <div class="w-full">
                            <div class="w-24 float-right">
                                <img src="{{ $child->getFirstMediaUrl('categories') }}" alt="" class="hover:scale-105 float-right">
                            </div>
                        </div>
                    </div>
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
    