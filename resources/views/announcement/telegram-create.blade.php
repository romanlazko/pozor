<x-body-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Create announcement") }}
        </h2>
    </x-slot> --}}
    @dump(auth()->user()->email)
    <livewire:announcement.create/>
</x-body-layout>