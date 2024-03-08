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
        </div>
    </x-slot>

    <div class="w-full p-4">
        <div class="w-full max-w-xl space-y-6 m-auto">
            <x-white-block>
                <livewire:profile.create.photo wire:model.live="form.photos" :error="$errors->get('form.photos')"/>
            </x-white-block>
            
            <livewire:profile.create.type wire:model.live="form.type"/>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        Required iformation:
                    </h2>
                    <livewire:profile.create.category wire:model.live="form.category_id" :error="$errors->get('form.category_id')"/>
                    <livewire:profile.create.subcategory wire:model.live="form.subcategory_id" :category="$form->category_id" :error="$errors->get('form.subcategory_id')"/>
                    <livewire:profile.create.condition wire:model.live="form.condition" :error="$errors->get('form.condition')"/>
                    <div>
                        <x-form.label :value="__('Price:')"/>
                        <div class="flex space-x-2">
                            <livewire:profile.create.price wire:model.live="form.price" :error="$errors->get('form.price')"/>
                            <livewire:profile.create.currency wire:model.live="form.currency" :error="$errors->get('form.currency')"/>
                        </div>
                    </div>
                </div>
            </x-white-block>

            <div class="w-full bg-white rounded-lg shadow-xl p-4">
                <livewire:profile.create.location wire:model.live="form.location" :error="$errors->get('form.location')"/>
            </div>

            <x-white-block>
                <div class="space-y-6">
                    <h2 class="text-xl font-bold">
                        Additional iformation:
                    </h2>
                    <livewire:profile.create.payment wire:model.live="form.payment" :error="$errors->get('form.payment')"/>
                    <livewire:profile.create.shipping wire:model.live="form.shipping" :error="$errors->get('form.shipping')"/>
                    <livewire:profile.create.caption wire:model.live="form.caption" :error="$errors->get('form.caption')"/>
                </div>
            </x-white-block>
            
            <x-a-buttons.button wire:click="save" class="justify-center text-center bg-indigo-600 hover:bg-indigo-700 text-white uppercase w-full sm:w-min">
                Create
            </x-a-buttons.button>
        </div>
    </div>
</x-layout>