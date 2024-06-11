<a 
    {{ 
        $attributes->merge([
            'class' => 'space-x-2 cursor-pointer inline-flex items-center px-4 py-3 border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25 whitespace-nowrap bg-indigo-600 hover:bg-indigo-700 text-white justify-center'
        ]) 
    }}
>
    <i class="fa-solid fa-plus"></i>
    <p class="hidden lg:flex">
        {{ $slot }}
    </p>
    
</a>