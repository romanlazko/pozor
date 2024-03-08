<div>
    <x-form.label :value="$label ?? __( 'Date:')"/>
    <x-form.input wire:model.live="date" class="w-full hover:border-indigo-600" type="date"/>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
