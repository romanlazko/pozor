<x-base-layout>
    <div x-data="{ sidebarOpen: false }" class="flex h-dvh font-roboto bg-gray-50">
        <div class="flex-1 flex flex-col ">
            <div class="w-full hidden lg:block">
                @include('layouts.header')
            </div>
            
            <div class="flex overflow-hidden grow mx-auto w-[100vw] h-full">
                @if (isset($sidebar))
                    <x-sidebar>
                        {{ $sidebar }}
                    </x-sidebar>
                @endif
                
                <div class="flex flex-1 flex-col overflow-hidden">
                    @if (isset($header))
                        <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between" x-data="{ headerOpen: false }">
                            {{ $header }}
                        </div>
                    @endif
                    
                    <main id="main-block"  class="w-full overflow-y-auto max-w-[1800px] mx-auto" wire:scroll>
                        {{ $slot }}
                    </main>
            
                    @if (isset($footer))
                        <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 justify-between bg-white ">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:hidden block">
                @include('layouts.footer')
            </div>
        </div>
    </div>
</x-base-layout>