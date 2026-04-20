<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
                    TaskFlow
                </h1>
                <p class="text-xl text-gray-500 mb-8 max-w-2xl mx-auto">
                    Gestiona projectes i tasques del teu equip de forma simple i eficient.
                </p>
                @guest
                    <div class="flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                            Registra't gratis
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Iniciar sessió
                        </a>
                    </div>
                @endguest
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Projectes recents</h2>

            @if($projects->isEmpty())
                <div class="text-center py-16 text-gray-400">
                    <p class="text-lg">Encara no hi ha projectes publicats.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-3">
                                {{ $project->description ?? 'Sense descripció.' }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-400 gap-4">
                                <span>{{ $project->user->name }}</span>
                                <span>{{ $project->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @guest
                <div class="mt-12 text-center">
                    <p class="text-gray-500 mb-4">Vols veure'n més? Crea un compte gratuït.</p>
                    <a href="{{ route('register') }}"
                        class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Registra't ara
                    </a>
                </div>
            @endguest
        </div>
    </div>
</x-app-layout>
