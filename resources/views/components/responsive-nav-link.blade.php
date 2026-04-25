@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl border border-slate-300 bg-slate-100 px-4 py-3 text-start text-base font-semibold text-slate-900 focus:outline-none focus:bg-slate-200 transition duration-150 ease-in-out'
            : 'block w-full rounded-xl border border-transparent px-4 py-3 text-start text-base font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 hover:border-slate-200 focus:outline-none focus:text-slate-900 focus:bg-slate-100 focus:border-slate-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
