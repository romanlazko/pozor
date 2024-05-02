<x-user-layout>
    <x-slot name="header">
        <x-a-buttons.back 
            onclick="if (document.referrer == '' && !document.referrer.includes('announcement') && '{{ redirect()->back()->getTargetUrl() }}' != '{{ route('announcement.index') }}') { window.location.href = '{{ route('announcement.index') }}'; } else { window.history.back(); }"
            {{-- onclick="window.location.href = '{{ route('announcement.index') }}'" --}}
            {{-- href="{{ redirect()->back()->getTargetUrl() }}" --}}
        />
        <div class="flex space-x-3">
            {{-- <x-a-buttons.secondary class="">
                <i class="fa-solid fa-share"></i>
            </x-a-buttons.secondary>
            <x-a-buttons.secondary >
                <i class="fa-regular fa-bookmark"></i>
            </x-a-buttons.secondary> --}}
            <x-dropdown>
                <x-slot name="trigger">
                    <x-a-buttons.secondary class="" >
                        <i class="fa-solid fa-ellipsis"></i>
                    </x-a-buttons.secondary> 
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link>
                        {{ __("Report") }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            
        </div>
    </x-slot>

    <div class="lg:flex w-full max-w-6xl m-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
        <div class="w-full lg:w-2/3 space-y-6">
            <x-slider :medias="$announcement->getMedia('announcements')"/>
            <div class="space-y-6 p-6 bg-white rounded-lg shadow-md">
                <div class="space-y-1 ">
                    <p class="font-extrabold text-indigo-600 text-2xl">
                        {{ $announcement->current_price }} {{ $announcement->currency->name }} 
                    </p>
                    <h2 class="text-xl">
                        {{ ucfirst($announcement->translated_title) }}
                    </h2>
                    
                    <p class="text-sm text-gray-400">
                        {{ $announcement->created_at->diffForHumans() }}:  
                        {{-- {{ $announcement->location['country'] }}, {{ $announcement->location['name'] }}  --}}
                    </p>
                </div>
    
                @if ($announcement->attributes->isNotEmpty())
                    <hr>
                    <div class="space-y-4">
                        <h4 class="font-bold text-2xl">{{ __("Features:") }}</h4>
                        <div class="w-full gap-3 grid grid-cols-1 lg:grid-cols-2">
                            @foreach ($announcement->attributes->sortBy('section.order_number') as $attribute)
                                <p><span class="text-gray-500">{{ $attribute->label }}</span>: <span>{{ $attribute->pivot->value }}</span></p>
                            @endforeach
                        </div>
                    </div>
                @endif
    
                @if ($announcement->description)
                    <hr>
                    <div class="space-y-4">
                        <h4 class="font-bold text-2xl">{{ __("Description:") }}</h4>
                        <p class="text-base">
                            {{ $announcement->translated_description }}
                        </p>
                    </div>
                @endif
    
                {{-- <hr> --}}
    
                
            </div>
        </div>
        <div class="w-full lg:w-1/3 space-y-6">
            {{-- <div class="w-full bg-red-400 sticky top-3 h-[300px] lg:rounded-xl ">
                <!-- Content of the sticky element -->
            </div> --}}
            <div class="space-y-6 sticky top-0 bg-white p-6 shadow-md rounded-lg">
                <div class="flex space-x-4 items-center">
                    <img src="{{ asset($announcement->user->avatar) }}" alt="" class="rounded-full w-14 h-14 lg:w-16 lg:h-16 aspect-square">
                    <div class="w-full">
                        <span class="block font-bold">{{ $announcement->user->name }}</span>
                        <a class="block text-gray-700 hover:underline cursor-pointer">{{ $announcement->user->email }}</a>
                        <span class="block text-gray-500 text-xs">{{ __("Registered") }} {{ $announcement->user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="w-full lg:flex lg:space-x-3 lg:space-y-0 space-y-3 items-center">
                    <x-a-buttons.primary class="w-full whitespace-nowrap" x-data="" x-on:click.prevent="$dispatch('open-modal', 'send-message')">
                        <i class="fa-solid fa-comment mr-1"></i>
                        Send message
                    </x-a-buttons.primary>
                    <livewire:components.show-contact :user_id="$announcement->user->id"/>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:flex w-full max-w-6xl m-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0 py-6">
        <div class="w-full lg:w-2/3 space-y-6">
            @if ($announcements?->isNotEmpty())
                <div class="space-y-6 bg-white p-6 shadow-md rounded-lg">
                    <h2 class="text-2xl font-bold">
                        Similar announcements
                    </h2>
                    <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2" >
                        @foreach ($announcements as $index => $announcement)
                            <x-announcement-card :announcement="$announcement" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="w-full lg:w-1/3 space-y-6">
            
        </div>
    </div>

    <x-modal name="send-message">
        <x-send-message :announcement="$announcement"/>
    </x-modal>
</x-user-layout>

