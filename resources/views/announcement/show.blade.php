<x-body-layout>
    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>

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

    <section class="lg:flex w-full max-w-6xl m-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
        <div class="w-full lg:w-2/3 space-y-6">
            <x-slider :medias="$announcement->getMedia('announcements')"/>
            <div class="space-y-6 p-4 py-6 bg-white rounded-lg shadow-md">
                <div class="space-y-1 ">
                    <p class="font-extrabold text-indigo-600 text-2xl">
                        {{ $announcement->current_price }}
                    </p>
                    <h2 class="text-xl">
                        {{ ucfirst($announcement->translated_title) }}
                    </h2>
                    
                    <p class="text-sm text-gray-400">
                        {{ $announcement->created_at->diffForHumans() }}:  
                        {{-- {{ $announcement->location['country'] }}, {{ $announcement->location['name'] }}  --}}
                    </p>
                </div>
    
                @if ($announcement->features->isNotEmpty())
                    <hr>
                    <div class="space-y-4">
                        <h4 class="font-bold text-2xl">{{ __("Features:") }}</h4>
                        <div class="w-full gap-3 grid grid-cols-1 lg:grid-cols-2">
                            @foreach ($announcement->features->sortBy('section.order_number') as $feature)
                                <p><span class="text-gray-500">{{ $feature->label }}</span>: <span>{{ $feature->value }}</span></p>
                            @endforeach
                        </div>
                    </div>
                @endif
    
                @if ($announcement->description)
                    <hr>
                    <div class="space-y-4">
                        <h4 class="font-bold text-2xl">{{ __("Description:") }}</h4>
                        <p class="max-w-lg whitespace-pre-wrap">{{ $announcement->translated_description }}</p>
                    </div>
                @endif
                
            </div>
        </div>
        <div class="w-full lg:w-1/3 space-y-6 sticky top-24">
            {{-- <div class="w-full bg-red-400 sticky top-3 h-[300px] lg:rounded-xl ">
                <!-- Content of the sticky element -->
            </div> --}}
            <div class="space-y-6 bg-white p-4 py-6 shadow-md rounded-lg ">
                <div class="flex space-x-4 items-center">
                    <img src="{{ $announcement->user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 lg:w-16 lg:h-16 aspect-square">
                    <div class="w-full">
                        <span class="block font-bold">{{ $announcement->user?->name }}</span>
                        <a class="block text-gray-700 hover:underline cursor-pointer">{{ $announcement->user?->email }}</a>
                        <span class="block text-gray-500 text-xs">{{ __("Registered") }} {{ $announcement->user?->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="w-full flex space-x-3 items-center justify-between">
                    <x-a-buttons.primary class="w-full whitespace-nowrap" x-data="" x-on:click.prevent="$dispatch('open-modal', 'send-message')">
                        {{ __("Message") }}
                    </x-a-buttons.primary>
                    @if ($announcement?->user?->phone)
                        <x-a-buttons.secondary class="w-full whitespace-nowrap" x-data="" x-on:click.prevent="$dispatch('open-modal', 'show-contact')">
                            {{ __("Call") }}
                        </x-a-buttons.secondary>
                    @endif
                </div>
            </div>
            <div>
                @if ($user_announcements->isNotEmpty())
                    <div class="space-y-6 bg-white p-4 py-6 shadow-md rounded-lg">
                        <h2 class="text-2xl font-bold">
                            User announcements:
                        </h2>
                        <div class="w-full grid grid-cols-2 gap-2" >
                            @foreach ($user_announcements as $index => $user_announcement_item)
                                <x-announcement-card :announcement="$user_announcement_item" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="lg:flex w-full max-w-6xl m-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0 py-6">
        <div class="w-full lg:w-2/3 space-y-6">
            @if ($announcements?->isNotEmpty())
                <div class="space-y-6 bg-white p-4 py-6 shadow-md rounded-lg">
                    <h2 class="text-2xl font-bold">
                        Similar announcements
                    </h2>
                    <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2" >
                        @foreach ($announcements as $index => $announcement_item)
                            <x-announcement-card :announcement="$announcement_item" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="w-full lg:w-1/3 space-y-6">
            
        </div>
    </section>

    <x-modal name="send-message">
        <x-send-message :announcement="$announcement"/>
    </x-modal>

    @if ($announcement?->user?->phone)
        <x-modal name="show-contact">
            <livewire:components.show-contact :user_id="$announcement->user->id"/>
        </x-modal>
    @endif

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>

