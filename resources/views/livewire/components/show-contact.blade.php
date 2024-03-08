<div class="w-full">
    @if ($phone)
        <a href="" class="inline-block w-full h-full">{{ $phone }}</a>
    @else
        <x-a-buttons.secondary class="w-full whitespace-nowrap" wire:click="showContacts">
            <i class="fa-solid fa-comment mr-1"></i>
            Show phone
        </x-a-buttons.secondary>
    @endif
</div>

