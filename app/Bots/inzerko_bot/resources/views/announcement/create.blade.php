<x-body-layout>
    @push('headerScripts')
        <script src="https://telegram.org/js/telegram-web-app.js"></script>
    @endpush
    
    <div class="p-2">
        <livewire:pages.user.announcement.telegram-create/>
    </div>
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('announcement-created', (event) => {
                alert('Объявление успешно создано!');
                window.Telegram.WebApp.close();
            });
        });
    </script>
</x-body-layout>