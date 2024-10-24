@props(['user' => null])

<div class="flex space-x-4 items-center">
    <div class="relative">
        <img src="{{ $user?->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="rounded-full w-14 h-14 min-h-14 min-w-14 object-cover aspect-square">
    </div>
    <div class="w-full space-y-2">
        <span class="block font-medium leading-none text-start">
            {{ $user?->name }}
        </span>
        <label class="text-gray-500 flex text-xs items-center space-x-1">
            <x-heroicon-o-clock class="size-4"/>
            <span class="block text-gray-500 text-xs leading-none">
                {{ __('components.user.registered') }} 
            </span>
            <span class="text-xs text-gray-900">
                {{ $user?->created_at->diffForHumans() }}
            </span>
        </label>
        
        @if ($user?->lang)
            <label class="text-gray-500 flex text-xs items-center space-x-1">
                <x-heroicon-o-language class="size-4"/>
                <span>
                    {{ __('components.user.languages') }}
                </span>
                @foreach ($user?->lang ?? [] as $item)
                    <span class="text-xs text-gray-900 uppercase">
                        {{ $item }}@if (!$loop->last),@endif
                    </span>
                @endforeach
            </label>
        @endif
    </div>
</div>
