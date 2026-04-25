<x-app-layout>
    <div class="min-h-screen">
        <div class="border-b border-white/60 bg-white/70">
            <div class="mx-auto max-w-7xl px-4 py-20 text-center sm:px-6 lg:px-8">
                <h1 class="mb-4 text-5xl font-extrabold tracking-tight text-gray-900">
                    TaskFlow
                </h1>
                <p class="mx-auto mb-8 max-w-2xl text-xl text-gray-500">
                    Gestiona projectes i tasques del teu equip de forma simple i eficient.
                </p>
                @guest
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white transition hover:bg-indigo-700">
                            Registra't gratis
                        </a>
                        <a href="{{ route('login') }}"
                            class="rounded-lg border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-50">
                            Iniciar sessio
                        </a>
                    </div>
                @endguest
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="mb-6 text-2xl font-bold text-gray-900">Projectes recents</h2>

            @if($projects->isEmpty())
                <div class="py-16 text-center text-gray-400">
                    <p class="text-lg">Encara no hi ha projectes publicats.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $project->name }}</h3>
                            <p class="mb-4 line-clamp-3 text-sm text-gray-500">
                                {{ $project->description ?? 'Sense descripcio.' }}
                            </p>
                            <div class="flex items-center justify-between gap-4 text-xs text-gray-400">
                                <span>{{ optional($project->user)->name ?? 'Sense usuari' }}</span>
                                <span>{{ $project->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @guest
                <div class="mt-12 text-center">
                    <p class="mb-4 text-gray-500">Vols veure'n mes? Crea un compte gratuit.</p>
                    <a href="{{ route('register') }}"
                        class="inline-block rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white transition hover:bg-indigo-700">
                        Registra't ara
                    </a>
                </div>
            @endguest
        </div>
    </div>
</x-app-layout>
