<x-layout>
    <x-slot name="header">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketplace announcement:') }}
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

    <div class="w-full p-4">
        <div class="w-full max-w-xl space-y-6 m-auto">
            <x-white-block>
                <livewire:components.create.photo wire:model.live="form.photos" :error="$errors->get('form.photos')"/>
            </x-white-block>
            
            <div class="flex w-full justify-between items-center space-x-2 ">
                @foreach (App\Enums\Marketplace\Type::cases() as $type)
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
                        Required iformation:
                    </h2>

                    <livewire:components.create.title wire:model.live="form.title" :error="$errors->get('form.title')"/>

                    <div>
                        <x-form.label :value="__('Category:')"/>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <x-form.select wire:model.live="form.category_id" class="w-full">
                                <option value="{{ NULL }}">
                                    {{ __('-- Select category') }}
                                </option>
                                @foreach ($category_items as $category_item)
                                    <option value="{{ $category_item->id }}">{{ $category_item->name }}</option>
                                @endforeach
                            </x-form.select>
                            
                            @if ($category)
                                <x-form.select wire:model.live="form.subcategory_id" class="w-full">
                                    <option value="{{ NULL }}">
                                        {{ __('-- Select subcategory') }}
                                    </option>
                                    @foreach ($category->subcategories as $subcategory_item)
                                        <option value="{{ $subcategory_item->id }}">{{ $subcategory_item->name }}</option>
                                    @endforeach
                                </x-form.select>
                            @endif
                        </div>
                    </div>

                    <div>
                        <x-form.label :value="__('Condition:')"/>
                        <x-form.select wire:model.live="form.condition" id="condition" type="text" class="w-full hover:border-indigo-600" required>
                            <option selected value="">
                                {{ __("-- Select condition") }}
                            </option>
                            @foreach (App\Enums\Marketplace\Condition::cases() as $condition)
                                <option value="{{ $condition }}">{{ ucfirst($condition->name) }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="flex space-x-2 items-top">
                        <livewire:components.create.number :label="__('Price:')" wire:model.live="form.price" :error="$errors->get('form.price')"/>
                        <livewire:components.create.currency wire:model.live="form.currency" :error="$errors->get('form.currency')"/>
                    </div>

                    <livewire:components.create.caption wire:model.live="form.caption" :error="$errors->get('form.caption')"/>
                </div>
            </x-white-block>

            <div class="w-full bg-white rounded-lg shadow-xl p-4 space-y-6">
                <h2 class="text-xl font-bold">
                    {{ __('Location:') }}
                </h2>
                <div class="space-y-2">
                    <livewire:components.create.location wire:model.live="form.location" :error="$errors->get('form.location')"/>
                </div>
            </div>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        Additional iformation:
                    </h2>

                    <livewire:components.create.payment wire:model.live="form.payment" :error="$errors->get('form.payment')"/>

                    <livewire:components.create.shipping wire:model.live="form.shipping" :error="$errors->get('form.shipping')"/>
                </div>
            </x-white-block>
            
            <x-a-buttons.button wire:click="save" class="justify-center text-center bg-indigo-600 hover:bg-indigo-700 text-white uppercase w-full sm:w-min">
                Create
            </x-a-buttons.button>
        </div>
    </div>
</x-layout>