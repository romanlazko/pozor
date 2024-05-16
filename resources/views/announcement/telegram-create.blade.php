<x-body-layout>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Create announcement") }}
        </h2>
    </x-slot> --}}
    <livewire:announcement.telegram-create/>

    <script>
        $wire.on('announcement-created', () => {
            window.Telegram.WebApp.close();
        });
    </script>
</x-body-layout>