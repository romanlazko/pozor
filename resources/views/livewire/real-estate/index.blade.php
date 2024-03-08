<x-layout>
    {{-- @dump($form, $form['additional_spaces']) --}}
    <div class="relative">
        <x-slot name="header">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="flex items-center">
                <h2 class="text-xl font-bold">
                    Real etate
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
                    <div class="flex w-full justify-between items-center space-x-2 ">
                        @foreach (App\Enums\RealEstate\Type::cases() as $type)
                            <div class="flex items-center w-full">
                                <x-form.label for="{{ $type->name }}" class="w-full bg-white rounded-lg border-2 has-[:checked]:bg-indigo-600 has-[:checked]:border-indigo-600 has-[:checked]:text-white overflow-hidden p-4 hover:border-indigo-600 hover:bg-gray-100">
                                    {{ $type->name }}
                                    <input wire:model.live="form.type" id="{{ $type->name }}" type="radio" class="hidden" name="type" value="{{ $type }}">
                                </x-form.label>
                            </div>
                        @endforeach
                    </div>

                    <div class="w-full space-y-1">
                        <x-form.select wire:model.live="form.category" class="w-full">
                            @foreach ($category_items as $category_item)
                                <option value="{{ $category_item->id }}">{{ $category_item->name }}</option>
                            @endforeach
                        </x-form.select>
                        
                        @if ($category?->subcategories->isNotEmpty())
                            <x-form.select wire:model.live="form.subcategory" class="w-full">
                                <option value="">{{ __('Select subcategory') }}</option>
                                @foreach ($category->subcategories as $subcategory_item)
                                    <option value="{{ $subcategory_item->id }}">{{ $subcategory_item->name }}</option>
                                @endforeach
                            </x-form.select>
                        @endif
                        
                        @if ($category?->configurations->isNotEmpty())
                            <div class="grid grid-cols-3 gap-1">
                                @foreach ($category->configurations as $index => $configuration)
                                    <label wire:key="{{$configuration->slug}}" class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900 whitespace-nowrap"> 
                                        <span>{{ $configuration->name }}</span>
                                        <x-form.checkbox wire:model.live="form.configurations" value="{{ $configuration->id }}" class=" hover:border-indigo-400" />
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="w-full space-y-2">
                        <div class="w-full space-y-2 ">
                            <livewire:components.create.location wire:model.live="form.location"/>
                            <x-form.select wire:model.live="form.radius" >
                                <option value="10">Radius</option>
                                <option value="20">20 km</option>
                                <option value="30">30 km</option>
                                <option value="40">40 km</option>
                                <option value="100">100 km</option>
                            </x-form.select>
                        </div>
                    </div>
                    
                    <hr>

                    <div class="space-y-2">
                        <div class="w-full flex space-x-3">
                            <x-form.input wire:model.blur="form.priceMin" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="Price min" />
                            <x-form.input wire:model.blur="form.priceMax" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="Price max" />
                        </div>
                    </div>

                    <hr>

                    <div class="w-full space-y-2">
                        <h2 class="text-xl font-bold">
                            Ecuipment:
                        </h2>
                        <div class="grid grid-cols-3 gap-1">
                            @foreach (App\Enums\RealEstate\Equipment::cases() as $equipment)
                                <label for="{{ $equipment->name }}" class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ ucfirst(__($equipment->name)) }}</span>
                                    <x-form.checkbox id="{{ $equipment->name }}" wire:model.live="form.equipment" value="{{$equipment->value}}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h2 class="text-xl font-bold">
                            Condition:
                        </h2>
                        <div class="grid grid-cols-3 gap-1">
                            @foreach (App\Enums\RealEstate\Condition::cases() as $condition)
                                <label for="{{ $condition->name }}" class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ ucfirst(__($condition->name)) }}</span>
                                    <x-form.checkbox id="{{ $condition->name }}" wire:model.live="form.condition" value="{{$condition->value}}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full space-y-2">
                        <h2 class="text-xl font-bold">
                            Additional spaces:
                        </h2>
                        <div class="grid grid-cols-3 gap-1">
                            @foreach (App\Enums\RealEstate\AdditionalSpace::cases() as $additional_space)
                                <label for="{{ $additional_space->name }}" class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ ucfirst(__($additional_space->name)) }}</span>
                                    <x-form.checkbox id="{{ $additional_space->name }}" wire:model.live="form.additional_spaces" value="{{$additional_space->value}}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="space-y-2">
                        <h2 class="text-xl font-bold">
                            Square meters:
                        </h2>
                        <div class="w-full flex space-x-3">
                            <x-form.input wire:model.blur="form.minSquareMeters" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="min" />
                            <x-form.input wire:model.blur="form.maxSquareMeters" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="max" />
                        </div>
                    </div>

                    <hr>

                    <div class="space-y-2">
                        <h2 class="text-xl font-bold">
                            Flore:
                        </h2>
                        <div class="w-full flex space-x-3">
                            <x-form.input wire:model.blur="form.minFlore" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="from" />
                            <x-form.input wire:model.blur="form.maxFlore" type="number" class="w-full p-4 hover:border-indigo-400" placeholder="to" />
                        </div>
                    </div>
                </div>

                <div class="bg-white w-full p-2 border-t text-right">
                    <x-buttons.primary type="submit" @click="sidebarOpen = false">
                        Show results
                    </x-buttons.primary>
                </div>
            </form>
        </x-slot>

        <div id="start-of-page" class="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-2 2xl:grid-cols-3 mb-6 p-2" >
            @foreach ($announcements as $index => $announcement)
                <a href="{{ route('real-estate.show', $announcement) }}" wire:navigate class="group overflow-hidden hover:scale-[1.02] transition ease-in-out duration-150 m-1 sm:m-2 md:flex md:bg-white md:rounded-lg md:shadow-xl">
                    <img class="w-full md:size-32 aspect-square object-cover rounded-lg" src="{{ $announcement->photos->first() ? asset('storage/'.$announcement->photos->first()?->src) : '' }}" alt="">
                    <div class="w-full md:p-2 flex flex-col">
                        <div class="flex-1">
                            <h2 class="md:text-xl font-bold w-full">
                                {{ ucfirst($announcement->title) }} m<sup>2</sup>
                            </h2>
                            <p class="text-lg text-indigo-700">
                                {{ $announcement->price }} {{ $announcement->price_currency }} 
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $announcement->location['name'] }}
                            </p>
                        </div>
                        <div class="w-full hidden md:block">
                            <x-badge>
                                {{ $announcement->equipment->name }}
                            </x-badge>
                            @foreach ($announcement->additional_spaces as $additional_space)
                                <x-badge>
                                    {{ $additional_space->name }}
                                </x-badge>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="p-4">
            {{ $announcements->links(data: ['scrollTo' => '#start-of-page']) }}
        </div>
    </div>
</x-layout>
