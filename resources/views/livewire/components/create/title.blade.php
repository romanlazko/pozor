<div>
    <x-form.label :value="__('Title:')"/>
    <x-form.input wire:model.live="title" class="w-full hover:border-indigo-600"/>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
