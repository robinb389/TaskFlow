<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --tf-bg: #eef2ff;
                --tf-surface: #ffffff;
                --tf-border: #dbe3f0;
                --tf-text: #111827;
                --tf-muted: #374151;
                --tf-primary: #4338ca;
                --tf-primary-strong: #312e81;
            }

            body.tf-ui {
                background: radial-gradient(circle at top, rgba(79, 70, 229, 0.12), transparent 40%), var(--tf-bg);
                color: var(--tf-text);
            }

            .tf-ui main {
                color: var(--tf-text);
                line-height: 1.55;
            }

            .tf-ui .grid {
                display: grid;
            }

            @media (min-width: 640px) {
                .tf-ui .sm\:grid-cols-2 {
                    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                }

                .tf-ui .sm\:grid-cols-3 {
                    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                }
            }

            @media (min-width: 1024px) {
                .tf-ui .lg\:grid-cols-2 {
                    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                }

                .tf-ui .lg\:grid-cols-3 {
                    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                }
            }

            .tf-ui main .bg-white {
                background: var(--tf-surface) !important;
                border: 1px solid var(--tf-border);
                box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            }

            .tf-ui main input,
            .tf-ui main select,
            .tf-ui main textarea {
                background: #fff;
                color: #0f172a;
                border: 1px solid #cbd5e1 !important;
                border-radius: 0.6rem;
            }

            .tf-ui main label {
                color: #1f2937 !important;
                font-weight: 600;
            }

            .tf-ui main .py-8 {
                padding-top: 2.25rem !important;
                padding-bottom: 2.25rem !important;
            }

            .tf-ui header {
                border-bottom-color: #dbe3f0 !important;
                background: rgba(255, 255, 255, 0.95) !important;
            }

            .tf-ui header > div {
                padding-top: 1.05rem !important;
                padding-bottom: 1.05rem !important;
            }

            .tf-ui main .p-16 {
                padding: 2.25rem !important;
            }

            .tf-ui main .p-8 {
                padding: 2rem !important;
            }

            .tf-ui main .p-6 {
                padding: 1.5rem !important;
            }

            .tf-ui main .p-4 {
                padding: 1.1rem !important;
            }

            .tf-ui main .gap-2 {
                gap: 0.65rem !important;
            }

            .tf-ui main .gap-3 {
                gap: 0.85rem !important;
            }

            .tf-ui main .gap-4 {
                gap: 1rem !important;
            }

            .tf-ui main .gap-6 {
                gap: 1.35rem !important;
            }

            .tf-ui main h1,
            .tf-ui main h2,
            .tf-ui main h3 {
                line-height: 1.3;
                margin-bottom: 0.2rem;
            }

            .tf-ui main p {
                line-height: 1.6;
            }

            .tf-ui main .text-gray-400 {
                color: #4b5563 !important;
            }

            .tf-ui main .text-gray-500 {
                color: #374151 !important;
            }

            .tf-ui main .text-gray-600 {
                color: #1f2937 !important;
            }

            .tf-ui main .text-gray-700,
            .tf-ui main .text-gray-800,
            .tf-ui main .text-gray-900 {
                color: #111827 !important;
            }

            .tf-ui main .bg-indigo-600,
            .tf-ui header .bg-indigo-600 {
                background: linear-gradient(135deg, var(--tf-primary), var(--tf-primary-strong)) !important;
                color: #fff !important;
            }

            .tf-ui main .bg-gray-800,
            .tf-ui header .bg-gray-800 {
                background: #1e293b !important;
                color: #fff !important;
            }

            .tf-ui main a[class*="bg-indigo-600"],
            .tf-ui main button[class*="bg-indigo-600"],
            .tf-ui main button[class*="bg-gray-800"],
            .tf-ui header a[class*="bg-indigo-600"],
            .tf-ui header button[class*="bg-indigo-600"],
            .tf-ui header button[class*="bg-gray-800"] {
                height: 2.75rem !important;
                min-height: 2.75rem !important;
                padding: 0 1.15rem !important;
                border-radius: 0.7rem !important;
                font-size: 0.875rem !important;
                font-weight: 700 !important;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                line-height: 1 !important;
            }

            .tf-ui header a[class*="bg-indigo-600"],
            .tf-ui header button[class*="bg-indigo-600"] {
                height: 2.9rem !important;
                min-height: 2.9rem !important;
                padding: 0 1.25rem !important;
            }

            .tf-ui a[class*="border-gray-300"],
            .tf-ui button[class*="border-gray-300"] {
                border-color: #cbd5e1 !important;
                color: #1f2937 !important;
                padding: 0.5rem 0.95rem !important;
                border-radius: 0.7rem !important;
            }

            .tf-ui main select,
            .tf-ui main input:not([type="checkbox"]):not([type="radio"]):not([type="color"]),
            .tf-ui main button[class*="bg-"],
            .tf-ui main a[class*="bg-"] {
                height: 2.75rem;
                min-height: 2.75rem;
            }

            .tf-ui main form.mb-6 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }

            .tf-ui main table thead {
                background: #eff6ff !important;
            }

            .tf-ui main table th {
                color: #334155 !important;
                font-weight: 700;
                padding-top: 0.7rem !important;
                padding-bottom: 0.7rem !important;
            }

            .tf-ui main table td {
                color: #0f172a;
                padding-top: 0.7rem !important;
                padding-bottom: 0.7rem !important;
                vertical-align: middle !important;
            }
        </style>
    </head>
    <body class="tf-ui bg-slate-100 font-sans antialiased text-slate-900">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.10),_transparent_35%),linear-gradient(to_bottom,_#f8fafc,_#eef2ff_45%,_#f8fafc)]">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-white/60 bg-white/75 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="pb-14 pt-2 sm:pt-4">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
                            {{ session('warning') }}
                        </div>
                    @endif
                </div>

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
