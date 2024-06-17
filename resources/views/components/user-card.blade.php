@props(['user' => null])

<x-white-block>
    <div class="flex space-x-4 items-center">
        <div class="relative">
            <img src="{{ $user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 min-h-14 min-w-14 object-cover aspect-square">
        </div>
        <div class="w-full space-y-1">
            <span class="block font-bold leading-none">{{ $user?->name }}</span>
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
</x-white-block>
