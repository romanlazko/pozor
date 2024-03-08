<x-layout>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Real Estate announcement:') }}
        </h2>
    </x-slot>

    <x-slot name="sidebar">
        <div class="p-4 space-y-3">
            <x-responsive-nav-link wire:navigate :href="route('profile.dashboard')" :active="request()->routeIs('profile.dashboard')">
				{{ __('Dashboard') }}
			</x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate :href="route('profile.announcements')" :active="request()->routeIs('profile.announcements')">
				{{ __('My Announcements') }}
			</x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
				{{ __('Profile') }}
			</x-responsive-nav-link>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link>
                    <button type="submit">
                        {{ __('Log Out') }}
                    </button>
                </x-responsive-nav-link>
            </form>

            @hasrole('super-duper-admin')
                <hr>
                <x-responsive-nav-link wire:navigate :href="route('admin.marketplace.announcement.index')">
                    {{ __("Admin") }}
                </x-responsive-nav-link>
            @endhasrole
        </div>
    </x-slot>

    <div class="w-full p-1 md:p-4">
        <form wire:submit="save()" class="w-full max-w-xl space-y-6 m-auto">
            <x-white-block>
                <livewire:components.create.photo wire:model.live="form.photos" :error="$errors->get('form.photos')"/>
            </x-white-block>
            
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

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        Category:
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <x-form.select wire:model.live="form.category_id" class="w-full" required>
                            @foreach ($category_items as $category_item)
                                <option value="{{ $category_item->id }}">{{ $category_item->name }}</option>
                            @endforeach
                        </x-form.select>
                        
                        @if ($category?->subcategories->isNotEmpty())
                            <x-form.select wire:model.live="form.subcategory_id" class="w-full" required>
                                <option value="">{{ __('-- Select subcategory') }}</option>
                                @foreach ($category->subcategories as $subcategory_item)
                                    <option value="{{ $subcategory_item->id }}">{{ $subcategory_item->name }}</option>
                                @endforeach
                            </x-form.select>
                        @endif

                        @if ($category?->configurations->isNotEmpty())
                            <x-form.select wire:model.live="form.configuration_id" class="w-full " required>
                                <option value="">{{ __('-- Select configuration') }}</option>
                                @foreach ($category->configurations as $index => $configuration)
                                    <option value="{{ $configuration->id }}">{{ $configuration->name }}</option>
                                @endforeach
                            </x-form.select>
                        @endif
                    </div>
                </div>
            </x-white-block>

            <div class="w-full bg-white rounded-lg shadow-xl p-4 space-y-6">
                <h2 class="text-xl font-bold">
                    {{ __('Location:') }}
                </h2>
                <div class="space-y-2">
                    <livewire:components.create.location wire:model.live="form.location" :error="$errors->get('form.location')"/>
                    <livewire:components.create.address wire:model.live="form.address" :error="$errors->get('form.address')"/>
                </div>
            </div>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        Description:
                    </h2>
                    <livewire:components.create.caption wire:model.live="form.description" :error="$errors->get('form.description')"/>
                    <livewire:components.create.date 
                        wire:model.live="form.check_in_date"  
                        :label="__('Check in date:')"
                        :error="$errors->get('form.check_in_date')"
                    />
                </div>
            </x-white-block>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        {{ __('Prices:') }}
                    </h2>
                    <div class="flex space-x-2 items-top">
                        <livewire:components.create.number :label="__('Price:')" wire:model.live="form.price" :error="$errors->get('form.price')"/>
                        <livewire:components.create.currency wire:model.live="form.price_currency" :error="$errors->get('form.price_currency')"/>
                    </div>
                    <div class="flex space-x-2 items-top">
                        <livewire:components.create.number :label="__('Utility:')" wire:model.live="form.utilities" :error="$errors->get('form.utilities')"/>
                        <livewire:components.create.currency wire:model.live="form.utilities_currency" :error="$errors->get('form.utilities_currency')"/>
                    </div>
                    @if ($form->type == App\Enums\RealEstate\Type::rent) 
                        <div class="flex space-x-2 items-top">
                            <livewire:components.create.number :label="__('Deposit:')" wire:model.live="form.deposit" :error="$errors->get('form.deposit')"/>
                            <livewire:components.create.currency wire:model.live="form.deposit_currency" :error="$errors->get('form.deposit_currency')"/>
                        </div>
                    @endif
                    
                </div>
            </x-white-block>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        {{ __('Features:') }}
                    </h2>

                    <div class="space-y-2">
                        <x-form.label :value="__('Condition:')"/>
                        <x-form.select wire:model.live="form.condition" id="condition" type="text" class="w-full hover:border-indigo-600" required>
                            <option selected value="">
                                {{ __("-- Select condition") }}
                            </option>
                            @foreach (App\Enums\RealEstate\Condition::cases() as $condition)
                                <option value="{{ $condition }}">{{ ucfirst($condition->name) }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <livewire:components.create.number :label="__('Square meters:')" wire:model.live="form.square_meters" :error="$errors->get('form.square_meters')"/>

                    <livewire:components.create.number :label="__('Floor:')" wire:model.live="form.floor" :error="$errors->get('form.floor')"/>

                    <div class="border border-gray-400 rounded-lg p-3 space-y-2">
                        <x-form.label :value="__('Additional spaces:')"/>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
                            @foreach (App\Enums\RealEstate\AdditionalSpace::cases() as $additional_space)
                                <label class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ ucfirst($additional_space->name) }}</span>
                                    <x-form.checkbox wire:model.live="form.additional_spaces" value="{{$additional_space}}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="border border-gray-400 rounded-lg p-3 space-y-2">
                        <x-form.label :value="__('Ecuipment:')"/>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
                            @foreach (App\Enums\RealEstate\Equipment::cases() as $equipment)
                                <label class="bg-white flex p-2 justify-between items-center border rounded-lg hover:border-indigo-400 has-[:checked]:border-indigo-600 text-gray-500 has-[:checked]:text-indigo-900"> 
                                    <span>{{ ucfirst($equipment->name) }}</span>
                                    <x-form.radio wire:model.live="form.equipment" value="{{ $equipment }}" class=" hover:border-indigo-400" />
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-white-block>
            
            <x-buttons.button type="submit" class="justify-center text-center bg-indigo-600 hover:bg-indigo-700 text-white uppercase w-full sm:w-min">
                Create
            </x-buttons.button>
        </form>
    </div>
</x-layout>