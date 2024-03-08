<x-layout>
    <x-slot name="header">
        <x-a-buttons.close href="{{ route('marketplace.index') }}" wire:navigate/>
    </x-slot>
    <div class="p-2 md:p-12 space-y-4 max-w-3xl m-auto">
        <x-white-block>
            {{ __("Page not found") }}
        </x-white-block>
    </div>
</x-layout>
