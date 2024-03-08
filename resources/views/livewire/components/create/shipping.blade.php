<div>
    <div class="w-full">
        <x-form.label for="shipping" value="{{ __('Shipping:') }}"/>
        <x-form.select wire:model.live="shipping" id="shipping" type="text" class="w-full hover:border-indigo-600" required>
            <option selected value="{{ NULL }}">
                {{ __("Select") }}
            </option>
            <option value="free">{{ __("Free") }}</option>
            <option value="self">{{ __("Self") }}</option>
            <option value="for_a_fee">{{ __("For a fee") }}</option>
        </x-form.select>
        <span class="text-xs text-gray-500">Not required</span>
        <x-form.error class="mt-1" :messages="$error"/>
    </div>
</div>
