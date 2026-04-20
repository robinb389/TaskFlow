@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-start text-base font-semibold text-indigo-700 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full rounded-xl border border-transparent px-4 py-3 text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-200 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
