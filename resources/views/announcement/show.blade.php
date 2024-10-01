<x-body-layout>
    <x-slot name="meta">
        {!! seo($announcement->getDynamicSEOData()) !!}
    </x-slot>

    <x-slot name="navigation">
        @include('layouts.navigation')
    </x-slot>

    <div class="space-y-6 py-6">
        <section class="grid w-full md:grid-cols-3 grid-cols-1 md:gap-6">
            <div class="order-1 col-span-2 ">
                <x-slider :medias="$announcement->getMedia('announcements')" :h="500" />
            </div>
                
            <div class="w-full overflow-hidden space-y-4 order-3 col-span-2 p-2 md:p-0">
                <hr class="lg:hidden">
                @if ($description = $announcement->getFeatureByName('description'))
                    <div class="space-y-4 ">
                        <h3 class="font-bold text-xl">{{ $description->label }}</h3>
                        <x-markdown class="html">
                            {{ $description->value }}
                        </x-markdown>
                    </div>
                @endif

                @if ($announcement->features->where('attribute.is_feature')->isNotEmpty())
                    <hr>
                    
                    <div class="space-y-3 sm:space-y-0 sm:gap-6 grid grid-cols-1 ">
                        <h3 class="font-bold text-xl">{{ __("Details") }}</h3>
                        @foreach ($announcement->features->where('attribute.is_feature')->sortBy('attribute.showSection.order_number')->groupBy('attribute.showSection.name') as $section_name => $feature_section)
                            <div class="space-y-2">
                                <h4 class="font-bold text-sm lg:text-base">
                                    {{ $section_name }}:
                                </h4>
                                
                                <ul class="w-full list-inside list-disc">
                                    @foreach ($feature_section->sortBy('attribute.show_layout.order_number') as $feature)
                                        <li class="w-full grid grid-cols-2 space-x-2 text-sm lg:text-base">
                                            <span class="text-gray-500 inline-block">• {{ $feature->label }}:</span>
                                            <span class="">
                                                {{ $feature->value }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full h-min space-y-5 py-6 md:sticky top-0 order-2 col-span-1 p-2 md:px-0">
                <div class="space-y-5">
                    <div class="h-full flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            {{ $announcement->geo?->name }} - {{ $announcement->created_at->diffForHumans() }}
                        </span>
                        
                        <livewire:components.like-dislike :announcement="$announcement"/>
                    </div>
    
                    <div class="w-full space-y-4">
                        <h1 class="font-medium text-lg lg:text-xl">
                            {{ $announcement->getSectionByName('title')->pluck('value')->implode(', ') }}
                        </h1>
                        <p class="font-bold text-3xl">
                            {{ $announcement->getSectionByName('price')->pluck('value')->implode(' ') }}
                        </p>
                    </div>
    
                    <div class="w-full flex space-x-3 items-center justify-between">
                        @if ($announcement?->user?->isProfileFilled() AND $announcement?->user?->hasVerifiedEmail())
                            <x-buttons.secondary class="w-full whitespace-nowrap justify-center" x-data="" x-on:click.prevent="$dispatch('open-modal', 'show-contact')">
                                {{ __("Call") }}
                            </x-buttons.secondary>
                        @endif
                    </div>
    
                    <x-user-card :user="$announcement->user" :announcement_id="$announcement->id"/>
                </div>

                <div>
                    
                </div>
            </div>
        </section>

        <section class="lg:flex w-full mx-auto space-x-0 space-y-12 lg:space-x-6 lg:space-y-0 px-2 xl:px-0">
            <div class="w-full lg:w-1/3 space-y-6 sticky top-0">
                <div>
                </div>
            </div>
        </section>
    
        <section class="lg:flex w-full space-x-0 space-y-6 lg:space-x-6 lg:space-y-0 px-2 ">
            <div class="w-full lg:w-2/3 space-y-6">
                @if (!empty($similar_announcements) AND $similar_announcements->isNotEmpty())
                    <div class="space-y-6 ">
                        <h2 class="text-2xl font-bold">
                            {{ __("Similar announcements") }}
                        </h2>
                        <div class="w-full grid grid-cols-1 gap-6" >
                            @foreach ($similar_announcements as $index => $similar_announcement)
                                <x-announcement-card :announcement="$similar_announcement" @class(['rounded-b-lg' => $loop->last, 'rounded-t-lg' => $loop->first])/>
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
                                <x-announcement-card :announcement="$user_announcement" @class(['rounded-b-lg' => $loop->last, 'rounded-t-lg' => $loop->first])/>
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

    @if ($announcement?->user?->isProfileFilled() AND $announcement?->user?->hasVerifiedEmail())
        <x-modal name="show-contact">
            <x-white-block>
                <div class="w-full space-y-6">
                    <div class="space-y-2">
                        <x-user-card :user="$announcement?->user" />
                    </div>
                    <livewire:components.show-contact :user_id="$announcement->user->id"/>
                </div>
            </x-white-block>
        </x-modal>
    @endif

    <x-slot name="footerNavigation">
        @include('layouts.footer')
    </x-slot>
</x-body-layout>

