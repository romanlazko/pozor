@props(['user' => null])

<div class="flex space-x-4 items-center bg-gray-100 p-4 rounded-2xl border">
    <div class="relative">
        <img src="{{ $user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 min-h-14 min-w-14 object-cover aspect-square">
    </div>
    <div class="w-full space-y-2">
        <span class="block font-medium leading-none">{{ $user?->name }}</span>
        <span class="block text-gray-500 text-xs leading-none">{{ __("registered") }} {{ $user?->created_at->diffForHumans() }}</span>
        @if ($user?->lang)
            <label class="text-gray-500 flex text-sm items-center space-x-1">
                <i class="fa-solid fa-language"></i>
                <span>
                    {{ __("Languages:") }}
                </span>
                @foreach ($user?->lang ?? [] as $item)
                    <span class="text-sm text-gray-900 uppercase">
                        {{ $item }}@if (!$loop->last),@endif
                    </span>
                @endforeach
            </label>
        @endif
    </div>
    <div>
        {{ $slot }}
    </div>
</div>
