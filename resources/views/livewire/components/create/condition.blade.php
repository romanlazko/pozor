<div>
    <div class="w-full">
        <x-form.label for="condition" value="{{ __('Condition:') }}"/>
        <x-form.select wire:model.live="condition" id="condition" type="text" class="w-full hover:border-indigo-600" required>
            <option selected value="{{ NULL }}">
                {{ __("Select") }}
            </option>
            @foreach ($conditions as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </x-form.select>
        <x-form.error class="mt-1" :messages="$error"/>
    </div>
</div>
