<x-body-layout>
    <x-slot name="meta">
        {{-- @if(isset($announcement?->meta['description']))
            <meta name="description" content="{{ $announcement?->meta['description'] }}" data-rh="true">
            <meta name="mrc__share_title" content="{{ $announcement?->meta['description'] }}" data-rh="true">
            <meta property="og:description" content="{{ $announcement?->meta['description'] }}" data-rh="true">
        @endif

        @if(isset($announcement?->meta['meta_title']))
            <meta name="mrc__share_title" content="{{ $announcement?->meta['meta_title'] }}" data-rh="true">
            <meta property="og:title" content="{{ $announcement?->meta['meta_title'] }}" data-rh="true">
        @endif

        @if(isset($announcement?->meta['image_url']) AND isset($announcement?->meta['image_alt']))
            <meta property="og:image" content="{{ $announcement?->meta['image_url'] }}" data-rh="true">
            <meta property="og:image:alt" content="{{ $announcement?->meta['image_alt'] }}" data-rh="true">
        @endif
        
        
        <meta property="og:url" content="{{ route('announcement.show', $announcement->slug) }}" data-rh="true">
        @if(isset($announcement?->meta['price']) AND isset($announcement?->meta['currency']))
            <meta property="product:price:amount" content="{{ $announcement?->meta['price']}}" data-rh="true">
            <meta property="product:price:currency" content="{{ $announcement?->meta['currency'] }}" data-rh="true">
        @endif --}}
        {{-- {!!  !!} --}}

        {{-- @dump($announcement?->seo ?? null) --}}

        {!! seo()->for($announcement) !!}
    </x-slot>

    <x-slot name="headerNavigation">
        @include('layouts.header')
    </x-slot>

    <x-slot name="header">
        <x-buttons.back 
            onclick="if (document.referrer == '' && !document.referrer.includes('announcement') && '{{ redirect()->back()->getTargetUrl() }}' != '{{ route('announcement.index') }}') { window.location.href = '{{ route('announcement.index') }}'; } else { window.history.back(); }"
        />

        <div class="flex space-x-3">
            <livewire:components.like-dislike :announcement="$announcement"/>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="lg:flex w-full mx-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
            <div class="w-full lg:w-2/3 bg-white rounded-lg shadow-md overflow-hidden">
                <x-slider :medias="$announcement->getMedia('announcements')"/>
            </div>
            <div class="w-full lg:w-1/3 bg-white rounded-lg shadow-md overflow-hidden h-min">
                <div class="w-full space-y-1 px-4 md:px-6 py-6">
                    <h1 class="font-bold text-lg lg:text-2xl">
                        {{ ucfirst($announcement->getFeatureByName('title')?->value) }} 
                    </h1>
                    <span class="text-xl text-indigo-600">{{ $announcement->getFeatureByName('current_price')?->value }}</span>
                    
                    <p class="text-sm text-gray-500">
                        {{ $announcement->geo?->country }}, {{ $announcement->geo?->name }} -
                        {{ $announcement->created_at->diffForHumans() }}
                    </p>
                </div>
                <hr>
                <div class="space-y-6 bg-white p-4 py-6 h-min">
                    <x-user-card :user="$announcement->user"/>
                    <div class="w-full flex space-x-3 items-center justify-between">
                        <x-buttons.primary class="w-full whitespace-nowrap justify-center" x-data="" x-on:click.prevent="$dispatch('open-modal', 'send-message')">
                            {{ __("Message") }}
                        </x-buttons.primary>
                        @if ($announcement?->user?->isProfileFilled() AND $announcement?->user?->hasVerifiedEmail())
                            <x-buttons.secondary class="w-full whitespace-nowrap justify-center" x-data="" x-on:click.prevent="$dispatch('open-modal', 'show-contact')">
                                {{ __("Call") }}
                            </x-buttons.secondary>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section class="lg:flex w-full mx-auto space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
            <div class="w-full lg:w-2/3 bg-white rounded-lg shadow-md overflow-hidden">
                @if ($description = $announcement->getFeatureByName('description'))
                    <div class="space-y-4 px-4 md:px-6 py-6">
                        <h3 class="font-bold text-2xl">{{ $description->label }}</h3>
                        <x-markdown class="html">
                            {{ $description->value }}
                        </x-markdown>
                    </div>
                @endif
                @if ($announcement->features->where('attribute.is_feature')->isNotEmpty())
                    <hr>
                    <div class="space-y-3 px-4 md:px-6 py-6 sm:space-y-0 sm:gap-6 grid grid-cols-1 md:grid-cols-2">
                        @foreach ($announcement->features->where('attribute.is_feature')->sortBy('attribute.section.order_number')->groupBy('attribute.section.name') as $section_name => $feature_section)
                            <div class="space-y-2">
                                <h4 class="font-bold text-md">
                                    {{ $section_name }}:
                                </h4>
                                
                                <div class="w-full space-y-1 ">
                                    @foreach ($feature_section->sortBy('attribute.section.order_number') as $feature)
                                        <div class="w-full grid grid-cols-2 space-x-2 text-base ">
                                            <span class="text-gray-500 inline-block">{{ $feature->label }}:</span>
                                            <span class="">
                                                {{ $feature->value }} {{ $feature->suffix }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="w-full lg:w-1/3 space-y-6 sticky top-0">
                <div>
                </div>
            </div>
        </section>
    
        <section class="lg:flex w-full space-x-0 space-y-6 lg:space-x-6 lg:space-y-0">
            <div class="w-full lg:w-2/3 space-y-6">
                @if (!empty($similar_announcements) AND $similar_announcements->isNotEmpty())
                    <div class="space-y-6 ">
                        <h2 class="text-2xl font-bold">
                            {{ __("Similar announcements") }}
                        </h2>
                        <div class="w-full grid grid-cols-1 gap-6" >
                            @foreach ($similar_announcements as $index => $similar_announcement)
                                <x-announcement-card :announcement="$similar_announcement" />
                            @endforeach
                        </div>
                        <x-a-buttons.secondary href="{{ route('announcement.index', ['category' => $announcement->categories?->last()->slug]) }}">
                            {{ __("Show more") }}
                        </x-a-buttons.secondary>
                    </div>
                @endif
    
                @if (!empty($user_announcements) AND $user_announcements->isNotEmpty())
                    <div class="space-y-6 bg-white p-4 py-6 shadow-md rounded-lg">
                        <h2 class="text-2xl font-bold">
                            User announcements
                        </h2>
                        <div class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2" >
                            @foreach ($user_announcements as $index => $user_announcement)
                                <x-announcement-card :announcement="$user_announcement" />
                            @endforeach
                        </div>
                        <x-a-buttons.secondary href="{{ route('announcement.index', ['category' => $announcement->categories?->last()->slug]) }}">
                            {{ __("Show more") }}
                        </x-a-buttons.secondary>
                    </div>
                @endif 
    
            </div>
            <div class="w-full lg:w-1/3 space-y-6">
            </div>
        </section>
    </div>
    
    <x-modal name="send-message">
        <x-send-message :announcement="$announcement"/>
    </x-modal>

    @if ($announcement?->user?->isProfileFilled() AND $announcement?->user?->hasVerifiedEmail())
        <x-modal name="show-contact">
            <livewire:components.show-contact :user_id="$announcement->user->id"/>
        </x-modal>
    @endif

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>

