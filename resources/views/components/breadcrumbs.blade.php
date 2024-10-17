@props(['category' => null])

<div class="order-2">
    <div class="w-full overflow-auto">
        <nav class="text-sm">
            <ol class="flex flex-wrap items-center gap-1">
                <li class="flex items-center gap-1.5">
                    <a href="{{ route('home') }}" aira-label="home" class="cursor-pointer text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" class="size-4">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" />
                        </svg>	
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </li>
                @forelse ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
                    <li class="flex items-center gap-1">
                        <a href="{{ route('announcement.search', ['category' => $parent->slug]) }}" @class(['text-gray-500 cursor-pointer', 'text-gray-800 font-medium' => $loop->last, 'hover:underline ' => !$loop->last])>
                            {{ $parent->name }}
                        </a>
                        @if (!$loop->last)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        @endif
                    </li>
                @empty
                    <li class="flex items-center gap-1">
                        <a href="{{ route('announcement.index') }}" @class(['text-gray-800 cursor-pointer hover:underline font-medium'])>
                            {{ __("All") }}
                        </a>
                    </li>
                @endforelse
            </ol>
        </nav>
    </div>
</div>