@props(['category' => null, 'search' => null, 'filterButton' => false, 'location' => null])

<div class="md:flex items-center w-full md:space-x-2 space-y-3 md:space-y-0">
    <form action="{{ route('announcement.search', ['category' => $category?->slug]) }}" class="rounded-full flex border-2 border-indigo-600 bg-white p-2 w-full items-center">
        <div class="w-full bg-white rounded-full items-center flex ">
            <input type="search" class="w-full border-none rounded-full h-full focus:ring-0 border border-indigo-600" placeholder="{{ __('Search...') }}" name="search" value="{{ $search }}"
            onchange="this.form.submit()">
        </div>
    
        <button @click="sidebarOpen = true" type="button"
            @class(['text-gray-900 hover:text-indigo-700 text-xl lg:hidden p-2', 'hidden' => !$filterButton])
        >
            <i class="fa-solid fa-sliders"></i>
        </button>
        
        <button class="p-2 rounded-full aspect-square min-w-10 min-h-10 max-w-10 max-h-10 hover:bg-indigo-500 text-xl bg-indigo-600 text-center items-center">
            <i class="fa-solid fa-magnifying-glass text-white m-auto"></i>
        </button>
    </form>
    
    <livewire:location-form :location="$location" :category="$category"/>
</div>
