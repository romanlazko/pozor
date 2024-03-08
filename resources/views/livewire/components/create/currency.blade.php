<div class="w-1/3">
    <x-form.label for="condition" value="{{ $label }}"/>
    <x-form.select wire:model.live="currency" class="w-full hover:border-indigo-600">
        @foreach (App\Enums\Currency::cases() as $currency)
            <option value="{{ $currency }}">{{ $currency }}</option>
        @endforeach
    </x-form.select>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
