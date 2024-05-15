<a class="announcement-card overflow-hidden group transition ease-in-out duration-150 rounded-lg" href="{{ route('announcement.show', $announcement) }}" wire:navigate>
    {{-- <img class="w-full aspect-square object-cover rounded-lg bg-white group-hover:border-indigo-700 group-hover:border-2 shadow-lg border-[0.5px]" 
        src="{{ $announcement->getFirstMediaUrl('announcements', 'small') }}" 
        alt=""
    > --}}
    <div class="w-full rounded-lg bg-white group-hover:border-indigo-700 group-hover:border-2 shadow-lg border-[0.5px] overflow-hidden">
        {{ $announcement->getMedia('announcements')->first() }}
    </div>

    {{-- @dump($announcement->attachments) --}}

    <div class="">
        <h2 class="text-base font-bold w-full">
            {{ $announcement->current_price }} {{ $announcement->currency->name }} <span class="font-light text-gray-400 line-through">{{ $announcement->old_price ?? '' }}</span>
        </h2>
        <p class="text-sm">
            {{ $announcement->translated_title }}
        </p>
        <p class="text-xs text-gray-500">
            {{ $announcement->location['name'] ?? null }}
        </p>
    </div>
</a>