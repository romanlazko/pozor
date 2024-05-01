@props(['active'])

@php
    $activeClasses = ($active ?? false)
        ? ' text-indigo-700 text-left border-indigo-600 '
        : ' border-transparent text-gray-500 focus:outline-none focus:text-gray-800 focus:border-gray-300 hover:text-indigo-200';
@endphp

<a {{ $attributes->merge(['class' => 'border block text-left text-md font-base transition duration-150 ease-in-out cursor-pointer rounded-lg w-full lg:w-min px-4 py-2 text-gray-700 items-center flex text-center w-min' . $activeClasses]) }}>
    <div class="flex whitespace-nowrap items-center ">
        {{ $slot }}
    </div>
</a>