@props(['user' => null, 'announcement' => null])

<div class="space-y-3">
    <div class="flex space-x-4 items-center bg-gray-100 p-4 rounded-2xl border">
        <div class="relative">
            <img src="{{ $user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 min-h-14 min-w-14 object-cover aspect-square">
        </div>
        <div class="w-full space-y-2">
            <span class="block font-medium leading-none">{{ $user?->name }}</span>
            <span class="block text-gray-500 text-xs leading-none">{{ __("registered") }} {{ $user?->created_at->diffForHumans() }}</span>
            <div class="w-full flex space-x-0.5">
                @foreach ($user?->lang ?? [] as $item)
                    <span class="text-sm bg-indigo-600 text-white p-0.5 leading-none rounded-md">
                        {{ $item }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="w-full">
        <livewire:send-message :announcement="$announcement"/>
    </div>
</div>
