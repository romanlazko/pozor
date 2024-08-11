<div class="flex space-x-2">
    @forelse ($channels as $channel)
        <x-filament::badge
            :color="$channel->status?->filamentColor()"
        >
            {{ $channel->channel->title }}
        </x-filament::badge>
    @empty
        <i class="fa-brands fa-telegram text-2xl text-blue-600"></i>
    @endforelse
</div>