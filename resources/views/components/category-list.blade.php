<div class="w-full space-y-3 grid grid-cols-1">
    <div class="bg-gray-50 w-full py-1 sticky top-12 lg:relative lg:top-0 order-1">
        <form action="{{ route('announcement.search', ['category' => $category?->slug]) }}" class="rounded-lg bg-indigo-600 flex">
            <div class="w-full bg-white rounded-lg items-center flex border-2 border-indigo-600">
                <input type="search" class="w-full border-none rounded-lg h-full focus:ring-0 border border-indigo-600" placeholder="{{ __('Search...') }}" name="search" value="{{ $data['search'] ?? null }}"
                onchange="this.form.submit()">
                
                <button @click="sidebarOpen = true" type="button"
                    @class(['text-gray-900 hover:text-indigo-700 text-xl lg:hidden p-3', 'hidden' => !$category])
                >
                    <i class="fa-solid fa-sliders"></i>
                </button>
            </div>
            
            <button class="p-4 rounded-lg hover:bg-indigo-500 text-xl">
                <i class="fa-solid fa-magnifying-glass text-white"></i>
            </button>
        </form>
    </div>

    @if ($category)
        <div class="bg-gray-50 order-2">
            <div class="w-full overflow-auto">
                {{-- <div class="space-x-1 text-sm w-full whitespace-nowrap">
                    <a href="{{ route('announcement.index') }}" class="text-blue-500 inline-block">
                        <span class="hover:underline">
                            {{ __("Main page") }}
                        </span>
                    </a>
                    
                    @foreach ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
                        <a href="{{ route('announcement.search', ['category' => $parent->slug]) }}" class="text-gray-500 space-x-1 inline-block">
                            <span>
                                >
                            </span>
                            <span class="hover:underline hover:text-blue-500">
                                {{ $parent->name }}
                            </span>
                        </a>
                    @endforeach
                </div> --}}
                <nav class="text-sm ">
                    <ol class="flex flex-wrap items-center gap-1">
                        <li class="flex items-center gap-1.5 ">
                            <a href="{{ route('announcement.index') }}" aira-label="home" class="cursor-pointer text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" class="size-4">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" />
                                </svg>	
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </li>
                        @foreach ($category?->getParentsAndSelf()->reverse() ?? [] as $parent)
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
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    @endif
    
    
    <div class="w-full grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 order-3">
        @foreach ($categories as $child)
            <a 
                href="{{ route('announcement.search', ['category' => $child->slug]) }}"
                @class([
                    'p-2 bg-white rounded-lg text-sm border hover:border-indigo-700 items-center ', 
                    'border-indigo-700' => $category?->slug === $child->slug
                ])
            >
                <div class="flex items-center space-x-2 m-auto h-full">
                    <div class="w-12 h-12 min-h-12 min-w-12">
                        <img src="{{ $child->getFirstMediaUrl('categories', 'thumb') }}" alt="" class="float-right">
                    </div>
                    <div class="grid">
                        <span class="w-full font-bold">
                            {{ $child->name }}
                        </span>
                        <span class="w-full text-xs text-gray-500">
                            {{ $child->announcements_count }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>