<div class="w-full">
    <x-form.label :value="$label ?? __( 'Number:')"/>
    <x-form.input wire:model.live="number" class="w-full hover:border-indigo-600" type="number"/>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
