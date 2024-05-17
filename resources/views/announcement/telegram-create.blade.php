<x-body-layout>
    
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Create announcement") }}
        </h2>
    </x-slot> --}}
    <livewire:announcement.telegram-create/>

    {{-- <div x-on:announcement-created="alert('announcement-created')"></div> --}}
    {{-- @push('scripts') --}}
        <script>
            // $wire.on('announcement-created', () => {
            //     window.Telegram.WebApp.close();
            // });
            // $wire.on('announcement-created', () => {
            //     alert('announcement-created');
            // });
            document.addEventListener('livewire:init', () => {
                Livewire.on('announcement-created', (event) => {
                    alert('announcement-created');
                    window.Telegram.WebApp.close();
                });
            });
        </script>
    {{-- @endpush --}}
    
</x-body-layout>