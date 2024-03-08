<div>
    <div class="w-full">
        <x-form.label for="payment" value="{{ __('Payment:') }}"/>
        <x-form.select wire:model.live="payment" id="payment" type="text" class="w-full hover:border-indigo-600" required>
            <option selected value="{{ NULL }}">
                {{ __("Select") }}
            </option>
            <option value="card">{{ __("Card") }}</option>
            <option value="cash">{{ __("Cash") }}</option>
            <option value="bank_transaction">{{ __("Bank transaction") }}</option>
        </x-form.select>
        <span class="text-xs text-gray-500">Not required</span>
        <x-form.error class="mt-1" :messages="$error"/>
    </div>
</div>
