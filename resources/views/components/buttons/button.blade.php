<button 
    {{ 
        $attributes->merge([
            'class' => 'cursor-pointer inline-flex items-center px-4 py-3 border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 disabled:opacity-25'
        ]) 
    }}
>
    {{ $slot }}
</button>