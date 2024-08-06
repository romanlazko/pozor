<form wire:submit="search" class="w-full h-full">
    <div class="p-4 w-full">
        {{ $this->form }}
    </div>
    <div class="bottom-0 sticky p-2 w-full ">
        <x-buttons.primary type="submit" @click="sidebarOpen = false" class="w-full justify-center">
            {{ __("Show results") }}
        </x-buttons.primary>
    </div>
</form>
