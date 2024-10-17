<div class="grid grid-cols-1 gap-2 w-max">
    @forelse ($collection as $item)
        <x-filament::badge
            :color="$item->color"
        >
            {{ $item->title }}
        </x-filament::badge>
    @empty
        <i class="fa-brands fa-telegram text-2xl text-blue-600"></i>
    @endforelse
</div>