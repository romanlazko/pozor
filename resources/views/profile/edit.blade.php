<x-profile-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="p-2 space-y-4">
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-lang-form')
            </div>
        </div>
    
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-telegram-information-form')
            </div>
        </div>
    
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
    
</x-profile-layout>