@props(['active'])

@php
    $activeClasses = ($active ?? false)
        ? ' text-left text-white hover:bg-indigo-700 bg-indigo-600 '
        : ' border-transparent text-gray-500 hover:text-gray-800 focus:outline-none focus:text-gray-800 focus:border-gray-300 hover:border-indigo-600 hover:text-indigo-700';
@endphp

<a {{ $attributes->merge(['class' => 'border block text-left text-md font-base transition duration-150 ease-in-out cursor-pointer rounded-lg w-full lg:w-min px-4 py-2 text-gray-700' . $activeClasses]) }}>
    <div class="flex whitespace-nowrap items-center ">
        {{ $slot }}
    </div>
</a>