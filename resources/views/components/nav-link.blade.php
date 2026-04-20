@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex h-16 items-center border-b-2 border-indigo-500 px-3 text-sm font-semibold leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex h-16 items-center border-b-2 border-transparent px-3 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
