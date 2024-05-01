<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Edit announcement") }}
        </h2>
    </x-slot>
    <livewire:announcement.edit :record="$announcement"/>
</x-user-layout>