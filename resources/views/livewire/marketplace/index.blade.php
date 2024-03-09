<x-layout>
    {{-- @dump($form) --}}
    <div class="relative">
        <x-slot name="header">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="flex items-center">
                <h2 class="text-xl font-bold">
                    Marketplace
                </h2>
                <select wire:model.live="form.filter" class="w-min border-none shadow-none focus:ring-0 text-indigo-700 text-lg fotn-light">
                    @foreach (App\Enums\Filter::cases() as $filter)
                        <option value="{{ $filter->name }}">{{ $filter->value }}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>

        <x-slot name="sidebar">
            <form wire:submit="submit" class="flex-1 flex flex-col overflow-hidden h-full">

                <div class="flex-1 overflow-y-auto space-y-6 pb-12 bg-gray-100 p-2 sm:p-3">
                    <div class="space-y-2">
                        <x-form.input wire:model="form.search" type="search" class="w-full p-4 hover:border-indigo-400" placeholder="Search" />
                        <label class="w-full flex items-center space-x-5 text-gray-500 has-[:checked]:text-indigo-900 cursor-pointer"> 
                            <x-form.checkbox wire:model.live="form.search_in_caption" class=" hover:border-indigo-400" />
                            <span>{{ "Search in caption" }}</span>
                        </label>
                        <div class="w-full flex space-x-3">
                            <x-form.input wire:model="form.priceMin" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="Price min" />
                            <x-form.input wire:model="form.priceMax" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="Price max" />
                        </div>
                    </div>
                    <hr>
                    <div class="w-full space-y-3">
                        <livewire:components.create.location wire:model.live="form.location" />
                        <x-form.select wire:model="form.radius.live" class="h-min">
                            <option value="10">Radius</option>
                            <option value="20">20 km</option>
                            <option value="30">30 km</option>
                            <option value="40">40 km</option>
                        </x-form.select>
                    </div>
                    <hr>
    
                    <div class="space-y-2">
                        <h2 class="text-xl font-bold">
                            Condition:
                        </h2>
                        <div class="grid grid-cols-3 gap-1">
                            @foreach (App\Enums\Marketplace\Condition::cases() as $condition)
                                <label for="{{ $condition->name }}" class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ $condition->trans() }}</span>
                                    <x-form.checkbox id="{{ $condition->name }}" wire:model.live="form.condition" value="{{$condition->value}}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>
    
                    <hr>
    
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <h2 class="text-xl font-bold"> 
                                Categories:
                            </h2>
                        </div>
    
                        <div class="space-y-2 w-full p-2 bg-white rounded-lg">
                            <label class="flex justify-between items-center ">
                                {{ __('All') }}
                                <x-form.radio wire:model.live="form.category" value="0" class="hover:border-indigo-400" />
                            </label>
                        </div>
                        
                        @foreach ($category_items as $category_item)
                            <div class="space-y-2 w-full bg-white rounded-lg" wire:key="{{$category_item->slug}}">
                                <label class="flex justify-between items-center p-2">
                                    {{ $category_item->name }}
                                    <x-form.radio wire:model.live="form.category" value="{{ $category_item->id }}" class="hover:border-indigo-400" />
                                </label> 
                                
                                @if ($category_item->id == $form->category)
                                    <div class="space-y-2 px-2 pb-2">
                                        @foreach ($category_item->subcategories as $subcategory)
                                            <label wire:key="{{$subcategory->slug}}" class="w-full flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                                <span>{{ $subcategory->name }}</span>
                                                <x-form.checkbox wire:model.live="form.subcategories" value="{{ $subcategory->id }}" class=" hover:border-indigo-400" />
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
        
                <div class="bg-white w-full p-2 border-t text-right">
                    <x-buttons.primary type="submit" @click="sidebarOpen = false">
                        Show results
                    </x-buttons.primary>
                </div>
            </form>
        </x-slot>
        <div id="start-of-page" class="w-full grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 mb-6" >
            @foreach ($announcements as $index => $announcement)
                <a href="{{ route('marketplace.show', $announcement) }}" wire:navigate class="overflow-hidden hover:scale-[1.02] transition ease-in-out duration-150 m-1 sm:m-2 md:m-3" onclick="localStorage.setItem('previousUrl', window.location.href);">
                    <img class="w-full aspect-square object-cover rounded-lg" src="{{ $announcement->photos->first() ? asset('storage/'.$announcement->photos->first()?->src) : '' }}" alt="">
                    <div class="">
                        <h2 class="text-base font-bold w-full">
                            {{ $announcement->price }} {{ $announcement->currency }} 
                        </h2>
                        <p class="text-sm">
                            {{ $announcement->title }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $announcement->location['name'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="p-4">
            {{ $announcements->links(data: ['scrollTo' => '#start-of-page']) }}
        </div>
    </div>
</x-layout>
