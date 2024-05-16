<form wire:submit="search" class="h-full flex flex-col w-full">
    {{-- @dump($data) --}}
    <div class="p-4 flex-1 w-full">
        {{ $this->form }}
    </div>
    <div class="bottom-0 sticky p-2 bg-white w-full">
        <x-buttons.primary type="submit" @click="sidebarOpen = false" class="w-full justify-center">
            Show results
        </x-buttons.primary>
    </div>
</form>
