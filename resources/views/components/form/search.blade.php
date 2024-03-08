@props(['action' => "", 'placeholder' => 'Search'])

<form action="{{ $action }}" class="">
    <div class="relative lg:mx-0 w-full">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>

        <input class="w-full pl-10 pr-4 rounded-md sm:min-w-[16rem] focus:border-indigo-600 border-none" type="text" name="search" value="{{ old('search', request()->search) }}" placeholder="{{ $placeholder }}">
    </div>
</form>