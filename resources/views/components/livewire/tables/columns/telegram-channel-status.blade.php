
<div class="flex space-x-2">
    @foreach ($channels as $channel)
        <x-filament::badge
            :color="$channel->status?->filamentColor()"
        >
            {{ $channel->channel->title }}
        </x-filament::badge>
    @endforeach
</div>