{{-- <div class="announcement-card w-full sm:flex space-x-0 sm:space-x-3 sm:space-y-0">
    <div {{ $attributes->merge(['class' => "w-full sm:flex bg-white border hover:border-indigo-700 group transition ease-in-out duration-150 p-3 space-x-0 space-y-3 lg:space-x-3 lg:space-y-0"]) }} >
        <div class="w-full sm:w-1/3 rounded-lg overflow-hidden h-min">
            <x-slider :medias="$announcement->getMedia('announcements')" :h="250" :thumb="false"/>
        </div>
    
        <a href="{{ route('announcement.show', $announcement) }}" class="w-full sm:w-2/3 flex">
            <div class="flex flex-col w-full space-y-1">
                <div class="flex-1 space-y-1">
                    <div class="w-full">
                        <p class="sm:text-xl sm:font-bold text-indigo-700 hover:text-indigo-800 hover:underline" >
                            {{ $announcement->getFeatureByName('title')?->value }}
                        </p>
                        
                        <p class="font-bold sm:text-2xl w-full">
                            {{ $announcement->getFeatureByName('current_price')?->value }} <span class="font-light text-gray-400 line-through">{{ $announcement->getFeatureByName('old_price')?->value }}</span>
                        </p>
                    </div>
            
                    <div class="overflow-hidden max-h-20 w-full">
                        <x-markdown class="text-xs text-gray-600 hidden sm:block">
                            {{ $announcement->getFeatureByName('description')?->value }}
                        </x-markdown>
                    </div>
            
                    <div class="text-xs text-gray-500 w-full">
                        @foreach ($announcement->features?->where('attribute.searchable')->where('attribute.is_feature')->sortBy('attribute.order_number') as $feature)
                            <x-badge class="block text-xs px-1 py-1 my-1">
                                <p class="text-[10px] text-gray-500 text-left">
                                    {{ $feature?->label }}:  
                                </p>
                                <p class="text-left">
                                    {{ $feature?->value }} {{ $feature?->suffix }}
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
        </a>
        <div class="h-full">
            <livewire:components.like-dislike :announcement="$announcement"/>
        </div>
    </div>
</div> --}}



@if ($layout == 'sm')
    <div class="announcement-card w-full space-x-0">
        <div {{ $attributes->merge(['class' => "w-full bg-white border hover:border-indigo-700 group transition ease-in-out duration-150 p-3 space-x-0 space-y-3"]) }} >
            <div class="w-full rounded-lg overflow-hidden h-min">
                <x-slider :medias="$announcement->getMedia('announcements')" :h="250" :thumb="false"/>
            </div>
        
            <a href="{{ route('announcement.show', $announcement) }}" class="w-full flex">
                <div class="flex flex-col w-full space-y-1">
                    <div class="flex-1 space-y-1">
                        <div class="w-full">
                            <p class="sm:text-xl sm:font-bold text-indigo-700 hover:text-indigo-800 hover:underline" >
                                {{ $announcement->getFeatureByName('title')?->value }}
                            </p>
                            
                            <p class="font-bold sm:text-2xl w-full">
                                {{ $announcement->getFeatureByName('current_price')?->value }} <span class="font-light text-gray-400 line-through">{{ $announcement->getFeatureByName('old_price')?->value }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="">
                        <p class="text-xs text-gray-500">
                            {{ $announcement->geo?->country }}, {{ $announcement->geo?->name }} - {{ $announcement->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </a>
            <div class="h-full">
                <livewire:components.like-dislike :announcement="$announcement"/>
            </div>
        </div>
    </div>
@endif