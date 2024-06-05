<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @include('profile.partials.verify-email')

    <div class="tab-wrapper" x-data="{ activeTab:  0 }">
        <div class="flex space-x-1 px-2">
            <x-buttons.button @click="activeTab = 0" class="rounded-b-none" x-bind:class="{ 'bg-indigo-700 hover:bg-indigo-500 text-white': activeTab === 0 }">
                {{ __("Profile")}}
            </x-buttons.button>
            <x-buttons.button @click="activeTab = 1" class="rounded-b-none" x-bind:class="{ 'bg-indigo-700 hover:bg-indigo-500 text-white': activeTab === 1 }">
                {{ __("Password") }}
            </x-buttons.button>
        </div>
    
        <div class="tab-panel space-y-4" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0">
            <x-white-block>
                @include('profile.partials.update-profile-information-form')
            </x-white-block>
            <x-white-block>
                @include('profile.partials.update-telegram-information-form')
            </x-white-block>
            <x-white-block>
                @include('profile.partials.logout-form')
            </x-white-block>
        </div>

        <div class="tab-panel space-y-6" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1">
            <x-white-block>
                @include('profile.partials.update-password-form')
            </x-white-block>
        </div>
    </div>
</x-profile-layout>