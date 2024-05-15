{{-- <x-base-layout>
    <div x-data="{ sidebarOpen: false }" class="flex font-roboto bg-gray-50">
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
</x-base-layout> --}}

<x-base-layout>
    <div class="w-full hidden lg:block fixed top-0 h-10 bg-black">
        @include('layouts.header')
    </div>
    
    <div class="pb-10 pt-0 lg:pt-10 lg:pb-0 flex w-full h-full">
        <aside id="default-sidebar" class="fixed left-0 z-40 h-full" aria-label="Sidebar">
            <x-sidebar>
                {{ $sidebar }}
            </x-sidebar>
        </aside>
        
        <div class="w-full lg:ml-72 xl:ml-96 h-full">
            @if (isset($header))
                <div class="flex w-full px-2 min-h-[50px] items-center py-1 space-x-2 sticky lg:top-10 top-0 bg-gray-50" x-data="{ headerOpen: false }">
                    <div class="flex items-center justify-between space-x-3 w-full">
                        {{ $header }}
                    </div>
                </div>
            @endif
            
            <main id="main-block" class="w-full space-y-4 h-full" >
                {{ $slot }}
            </main>

            @if (isset($footer))
                <div class="flex w-full px-2 items-center py-1 space-x-2 justify-between bg-white sticky bottom-10 md:bottom-0">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>

    <div class="w-full lg:hidden block fixed bottom-0 h-10">
        @include('layouts.footer')
    </div>
</x-base-layout>