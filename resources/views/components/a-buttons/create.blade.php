<a 
    {{ 
        $attributes->merge([
            'class' => 'space-x-2 cursor-pointer inline-flex items-center px-4 py-2 border border-transparent rounded-full text-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-25 whitespace-nowrap bg-indigo-600 hover:bg-indigo-700 text-white justify-center'
        ]) 
    }}
>
    <p class="hidden md:flex">
        {{ $slot }}
    </p>
    <i class="fa-solid fa-plus"></i>
    
    
</a>