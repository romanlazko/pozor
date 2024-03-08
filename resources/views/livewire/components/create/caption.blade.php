<div>
    <x-form.label :value="__('Caption:')"/>
    <x-form.textarea wire:model.live="caption" class="w-full hover:border-indigo-600" rows="8"/>
    <x-form.error class="mt-1" :messages="$error"/>
</div>
