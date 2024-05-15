<div class="p-2">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My announcements') }}
        </h2>
    </x-slot>
    {{ $this->table }}
</div>