<x-admin-layout>
    <div class="lg:flex w-full space-y-6 lg:space-y-0 lg:space-x-6 h-full " x-data="{ current: 0, photos: {{ $marketplaceAnnouncement->photos->pluck('src')->toJson() }} }">
        <div class="w-full lg:w-2/3 flex-1 flex flex-col overflow-hidden bg-gray-300 relative">
            @if ($marketplaceAnnouncement->photos)
                <div class="absolute inset-0 bg-cover bg-center filter blur-2xl border-none" x-show="photos && photos.length > 0" x-bind:style="'background-image: url(/storage/' + photos[current] + ')'">
                    <div class="bg-black opacity-60 h-full w-full"></div>
                </div>
            @endif
            <div class="flex-1 aspect-square lg:aspect-auto z-10 overflow-hidden">
                <div class="flex relative h-full object-contain justify-center">
                    <div class="absolute z-50 left-0 content-center h-full flex items-center px-1">
                        <button x-on:click="current = (current - 1 + photos.length) % photos.length" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="h-full">
                        @if ($marketplaceAnnouncement->photos)
                            <img x-show="photos && photos.length > 0" x-bind:src="'/storage/'+photos[current]" alt="" class="object-contain w-full h-full " >
                        @endif
                    </div>
                    <div class="absolute z-50 right-0 content-center h-full flex items-center px-1">
                        <button x-on:click="current = (current + 1) % photos.length" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full z-10">
                <div class="py-2 px-3 flex items-center space-x-3 justify-between">
                    <div class="flex w-full items-center justify-between">
                        <div class="flex m-auto w-full justify-center overflow-hidden">
                            <template x-for="(photo, index) in photos" :key="index">
                                <img x-bind:class="{ 'border-blue-500': index == current, 'border-transparent': index != current }" x-bind:src="'/storage/'+photo" class="w-16 h-16 border-2 rounded-lg object-cover">
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-1/3 space-y-6 overflow-y-auto ">
            <div class="space-y-6">
                <div class="space-y-1">
                    <h2 @class(['text-2xl', 'font-bold', 'text-gray-400' => ! $marketplaceAnnouncement->title])>
                        {{ $marketplaceAnnouncement->title ?: __("Title will be here") }}
                    </h2>
                    <p @class(['text-lg', 'text-gray-400' => ! $marketplaceAnnouncement->price])>
                        {{ $marketplaceAnnouncement->price ?: __("Price") }} {{ $marketplaceAnnouncement->currency }}
                    </p>
                    <p @class(['text-xs', 'text-gray-400' => ! $marketplaceAnnouncement->caption])>
                        {{ __("Created 1 minute ago") }}
                    </p>
                </div>
    
                <hr>
    
                <div>
                    <x-badge color="blue">
                        {{ $marketplaceAnnouncement->category_id ?? __("category")  }}
                    </x-badge>
                    <x-badge color="blue">
                        {{ $marketplaceAnnouncement->subcategory_id ?? __("subcategory")  }}
                    </x-badge>
                </div>
    
                <div class="space-y-1">
                    <div @class(['flex' => $marketplaceAnnouncement->condition, 'hidden' => ! $marketplaceAnnouncement->condition, 'justify-between'])>
                        <p class="font-bold">
                            {{ __("Condition:") }}
                        </p>
                        <p class="text-gray-600">
                            {{ $marketplaceAnnouncement->condition }}
                        </p>
                    </div>
                    <div @class(['flex' => $marketplaceAnnouncement->shipping, 'hidden' => ! $marketplaceAnnouncement->shipping, 'justify-between'])>
                        <p class="font-bold">
                            {{ __("Shipping:") }}
                        </p>
                        <p class="text-gray-600">
                            {{ $marketplaceAnnouncement->shipping }}
                        </p>
                    </div>
                </div>
    
                <hr>
                
                <p @class(['text-base', 'text-gray-400' => ! $marketplaceAnnouncement->caption])>
                    {{ $marketplaceAnnouncement->caption ?: __("Caption will be here") }}
                </p>
            </div>
        </div>
    </div>
</x-admin-layout>
