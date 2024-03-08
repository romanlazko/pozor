<div>
    <x-form.input wire:model.live="address" class="w-full hover:border-indigo-600" placeholder="Address"/>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
