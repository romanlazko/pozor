<x-user-layout>
<x-layout>
    <x-slot name="header">
        <x-a-buttons.close onclick="if (document.referrer == '' && !document.referrer.includes('marketplace') && '{{ redirect()->back()->getTargetUrl() }}' != '{{ route('marketplace.index') }}') { window.location.href = '{{ route('marketplace.index') }}'; } else { window.history.back(); }"/>
        <div class="flex space-x-3">
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
    <div class="lg:flex w-full max-w-6xl m-auto lg:py-12 lg:space-x-3 lg:px-3 space-x-0 space-y-6 lg:space-y-0">
        <div class="w-full lg:w-2/3 space-y-3 lg:space-y-6">
            <div x-data="{
                photos: {{ $announcement->photos->pluck('src')->toJson() }},
                current: 0,
                prev() {
                    this.current = (this.current - 1 + this.photos.length) % this.photos.length;
                },
                next() {
                    this.current = (this.current + 1) % this.photos.length;
                },
            }">
                <div class="relative bg-gray-200 overflow-hidden lg:rounded-xl shadow-xl">
                    <div class="absolute z-0 inset-0 bg-cover bg-center filter blur-2xl border-none h-full w-full"
                        x-bind:style="'background-image: url(\{{ asset('storage') }}/' + photos[current]+')'">
                        <div class="bg-black opacity-60 h-full w-full"></div>
                    </div>
                    <div class="w-full m-auto items-center h-[400px] z-30">
                        <div class="flex relative h-full justify-center items-center">
                            <div class="absolute z-50 left-0 content-center h-full flex items-center px-1">
                                <button x-on:click="prev" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                            </div>
                            <img x-bind:src="'{{ asset('storage') }}/' + photos[current]" alt="" class="object-contain w-full h-full">
                            <div class="absolute z-50 right-0 content-center h-full flex items-center px-1">
                                <button x-on:click="next" class="m-auto whitespace-nowrap items-center cursor-pointer grid bg-gray-50 hover:bg-gray-200 aspect-square w-8 h-8 rounded-full content-center">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="py-2 px-3 flex items-center space-x-3 justify-between">
                            <div class="flex w-full items-center justify-between z-30">
                                <div class="flex m-auto w-full justify-center overflow-hidden">
                                    <template x-for="(photo, index) in photos" :key="index">
                                        <img x-bind:src="'{{ asset('storage') }}/' + photo" class="bg-gray-200 w-16 h-16 border-2 rounded-lg object-cover mx-2"
                                            :class="{ 'border-blue-500': index === current, 'border-transparent': index !== current }">
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6 p-6 bg-white lg:rounded-xl shadow-xl">
                <div class="space-y-2">
                    <h2 class="font-bold text-2xl">
                        {{ $announcement->title }}
                    </h2>
                    <p class="font-bold text-gray-600 text-xl">
                        {{ $announcement->price }} {{ $announcement->currency ?? "Kc" }} 
                    </p>
                    <p class="text-xs text-gray-400">
                        {{-- {{ $announcement->created_at->diffForHumans() }}:  {{ $announcement->location['country'] }}, {{ $announcement->location['name'] }}  --}}
                    </p>
                </div>
                <hr>
                <div class="max-w-md">
                    @if ($announcement->shipping)
                        <div class="flex justify-between">
                            <h4 class="font-bold">{{ __("Shipping:") }}</h4>
                            <p>{{ __($announcement->shipping) }}</p>
                        </div>
                    @endif
                    
                    @if ($announcement->condition)
                        <div class="flex justify-between">
                            <h4 class="font-bold">{{ __("Condition:") }}</h4>
                            <p>{{ __($announcement->condition) }}</p>
                        </div>
                    @endif

                    @if ($announcement->payment)
                        <div class="flex justify-between">
                            <h4 class="font-bold">{{ __("Peyment:") }}</h4>
                            <p>{{ __($announcement->payment) }}</p>
                        </div>
                    @endif
                </div>
                <hr>
                <div>
                    <h4 class="font-bold">{{ __("Caption:") }}</h4>
                    <p class="text-base">
                        {{ $announcement->description }}
                    </p>
                </div>
            </div>
            <div class="space-y-6 p-6 py-4 bg-white lg:rounded-xl shadow-xl">
                <div class="flex space-x-4 items-center">
                    <img src="" alt="" class="rounded-full w-14 h-14 lg:w-16 lg:h-16 aspect-square bg-red-600">
                    <div class="w-full">
                        <span class="block font-bold">{{ $announcement->user->name }}</span>
                        <a class="block text-gray-700 hover:underline cursor-pointer">{{ $announcement->user->email }}</a>
                        <span class="block text-gray-500 text-xs">{{ $announcement->user->created_at->diffForHumans() }}</span>
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
        <div class="w-full lg:w-1/3 space-y-6">
            {{-- <div class="w-full bg-red-400 sticky top-3 h-[300px] lg:rounded-xl ">
                <!-- Content of the sticky element -->
            </div> --}}
        </div>
    </div>

    <x-modal name="send-message">
        <x-white-block>
            <div class="w-full space-y-4">
                <div class="flex space-x-4 items-center">
                    <img src="" alt="" class="rounded-full w-14 h-14 lg:w-16 lg:h-16 aspect-square bg-red-600">
                    <div class="w-full">
                        <span class="block font-bold">{{ $announcement->user->name }}</span>
                        <a class="block text-gray-700 hover:underline cursor-pointer">{{ $announcement->user->email }}</a>
                        <span class="block text-gray-500 text-xs">{{ $announcement->user->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <livewire:components.send-message :announcement="$announcement"/>
            </div>
        </x-white-block>
    </x-modal>
</x-layout>
</x-user-layout>

