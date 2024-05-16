<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Create announcement") }}
    </h2>
</x-slot>
<form wire:submit="create" class="w-full max-w-2xl mx-auto">
    {{ $this->form }}
</form>
