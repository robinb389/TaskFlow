<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projectes</h2>
            <a href="{{ route('projects.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                + Nou projecte
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($projects->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center text-gray-400">
                    <p class="text-lg mb-4">Encara no hi ha projectes.</p>
                    <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Crea el primer projecte</a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col">
                            <div class="p-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->name }}</h3>
                                <p class="text-sm text-gray-500 line-clamp-3">
                                    {{ $project->description ?? 'Sense descripció.' }}
                                </p>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between gap-4">
                                <span class="text-xs text-gray-400">
                                    @if(auth()->user()->isAdmin())
                                        {{ $project->user->name }} ·
                                    @endif
                                    {{ $project->created_at->format('d/m/Y') }}
                                </span>
                                <div class="flex gap-3">
                                    <a href="{{ route('projects.show', $project) }}" class="text-sm text-indigo-600 hover:underline">Veure</a>
                                    @can('update', $project)
                                        <a href="{{ route('projects.edit', $project) }}" class="text-sm text-gray-500 hover:underline">Editar</a>
                                    @endcan
                                    @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                            onsubmit="return confirm('Eliminar aquest projecte?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm text-red-500 hover:underline">Eliminar</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
