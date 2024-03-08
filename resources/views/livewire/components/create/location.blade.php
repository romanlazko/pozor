<div class="w-full">
    <div class="space-y-2 md:flex md:space-x-2 md:space-y-0">
        <x-form.select wire:model.live="country" class="w-full md:w-1/2" wire:change="$set('search', null)">
            @foreach ($countries as $country)
                <option value="{{ $country->country }}">
                    {{ $country->name }}
                </option>
            @endforeach
        </x-form.select>
        <div x-data="{ dropdown: false, value:'' }" class="relative w-full md:w-1/2">
            <div @click="dropdown = ! dropdown">
                <x-form.input @class(['w-full p-4 hover:border-indigo-400', 'border-2 border-red-600' => $error ?? ($search AND empty($location))]) wire:model.live="search" type="search" placeholder="{{ __('City') }}"/>
            </div>
    
            <div x-cloak x-show="dropdown" @click="dropdown = false" class="fixed inset-0 z-10 h-full"></div>
    
            <div @click.outside="dropdown = false" x-cloak x-show="dropdown" class="absolute left-0 z-10 mt-2 bg-white rounded-md shadow-xl border max-h-[200px] overflow-auto">
                @foreach ($cities as $city)
                    <button class="p-2 w-full hover:bg-gray-200 text-left dropdown-option" type="button" @click="dropdown = false" wire:click="setLocation('{{$city->name}}')">
                        {{ $city->country }}, {{ $city->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
