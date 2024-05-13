<div class="w-full">
    @if ($phone)
        <a href="" class="inline-block w-full h-full">{{ $phone }}</a>
    @else
        <form wire:submit.prevent="submit">
            <x-honey recaptcha/>
            <x-buttons.secondary type="submit" class="w-full whitespace-nowrap">
                <i class="fa-solid fa-comment mr-1"></i>
                Show phone
            </x-buttons.secondary>
        </form>
    @endif
</div>

