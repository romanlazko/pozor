@props(['category' => null, 'search' => null, 'filterButton' => false])

<form action="{{ route('announcement.search', ['category' => $category?->slug]) }}" class="rounded-full flex border-2 border-indigo-600 bg-white p-2">
    <div class="w-full bg-white rounded-full items-center flex ">
        <input type="search" class="w-full border-none rounded-full h-full focus:ring-0 border border-indigo-600" placeholder="{{ __('Search...') }}" name="search" value="{{ $search }}"
        onchange="this.form.submit()">
    </div>

    <button @click="sidebarOpen = true" type="button"
        @class(['text-gray-900 hover:text-indigo-700 text-xl lg:hidden p-2', 'hidden' => !$filterButton])
    >
        <i class="fa-solid fa-sliders"></i>
    </button>
    
    <button class="p-2 rounded-full aspect-square w-10 h-10 hover:bg-indigo-500 text-xl bg-indigo-600 text-center ">
        <i class="fa-solid fa-magnifying-glass text-white m-auto"></i>
    </button>
</form>