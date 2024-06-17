<div class="announcement-card group transition ease-in-out duration-150 w-full sm:flex space-x-0 sm:space-x-3 sm:space-y-0">
    <div {{ $attributes->merge(['class' => "w-full sm:flex space-x-0 sm:space-x-3 sm:space-y-0 bg-white border p-3 hover:border-gray-900"]) }} >
        <div class="w-full sm:w-1/3 rounded-lg overflow-hidden h-min">
            <x-slider :medias="$announcement->getMedia('announcements')" :h="250" :thumb="false"/>
        </div>
    
        <a href="{{ route('announcement.show', $announcement) }}" class="w-full sm:w-2/3 flex py-2">
            <div class="flex flex-col w-full">
                <div class="flex-1 ">
                    <div>
                        <p class="sm:text-xl sm:font-bold text-indigo-700 hover:text-indigo-800 hover:underline" >
                            {{ $announcement->getFeatureByName('title')->value }}
                        </p>
                        <p class="font-bold sm:text-2xl w-full">
                            {{ $announcement->getFeatureByName('current_price')?->value }} <span class="font-light text-gray-400 line-through">{{ $announcement->getFeatureByName('old_price')?->value }}</span>
                        </p>
                        <p class="text-xs block text-gray-500 md:hidden">
                            {{ $announcement->user?->name }}
                        </p>
                    </div>
            
                    <div class="overflow-hidden max-h-20">
                        <x-markdown class="text-xs text-gray-600 hidden sm:block">
                            {{ $announcement->getFeatureByName('description')->value }}
                        </x-markdown>
                    </div>
            
                    <div class="text-xs text-gray-500">
                        @foreach ($announcement->features->where('attribute.searchable')->where('attribute.is_feature')->sortBy('attribute.order_number') as $feature)
                            <x-badge class="block text-xs px-1 py-1 my-1">
                                <p class="text-[10px] text-gray-500 text-left">
                                    {{ $feature->label }}:  
                                </p>
                                <p class="text-left">
                                    {{ $feature->value }} {{ $feature->suffix }}
                                </p>
                            </x-badge>
                        @endforeach
                    </div>
                </div>
                <div class="">
                    <p class="text-xs text-gray-500">
                        {{ $announcement->geo?->country }}, {{ $announcement->geo?->name }} - {{ $announcement->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
            <livewire:components.like-dislike :announcement="$announcement"/>
        </a>
    </div>
    
    
    {{-- <div class="w-full md:w-1/4 md:order-4 hidden md:block lg:hidden xl:block bg-white rounded-lg shadow-lg p-3">
        <div class="space-y-2 m-auto text-center">
            <img src="{{ $announcement->user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 min-h-14 min-w-14 aspect-square m-auto">
            <div class="w-full">
                <span class="text-sm block font-bold">{{ $announcement->user?->name }}</span>
                <span class="text-gray-500 text-xs ">{{ __("Registered") }} {{ $announcement->user?->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div> --}}
</div>