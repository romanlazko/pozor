<form wire:submit="search" class="w-full h-full rounded-2xl">
    {{-- @dump($filters) --}}
    <div class="w-full rounded-2xl">
        {{ $this->form }}
    </div>
    <div class="bottom-0 sticky py-4 w-full rounded-2xl">
        <x-buttons.primary type="submit" @click="sidebarOpen = false" class="w-full justify-center rounded-2xl">
            {{ __("Show results") }}
        </x-buttons.primary>
    </div>
</form>
