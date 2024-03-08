<div {{ $attributes->merge(['class' => 'flex overflow-hidden grow m-auto w-full']) }}>
    @if (isset($sidebar))
        <x-sidebar>
            {{ $sidebar }}
        </x-sidebar>
    @endif
    
    <div class="flex flex-1 flex-col overflow-hidden">
        @include('layouts.navigation')
        @if (isset($header))
            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between bg-white border-b" x-data="{ headerOpen: false }">
                {{ $header }}
            </div>
        @endif
        
        <main class="flex-1 overflow-y-auto" wire:scroll>
            <div class="mx-auto h-full">
                {{ $slot }}
            </div>
        </main>

        @if (isset($footer))
            <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between bg-white ">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>