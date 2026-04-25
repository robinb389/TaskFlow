<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}" class="text-gray-400 transition hover:text-gray-600">&larr; Tornar</a>
            <h2 class="text-xl font-semibold text-gray-800">Nou projecte</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Nom del projecte *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Web corporativa">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Descripcio</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Descripcio opcional del projecte...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('projects.index') }}"
                            class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Crear projecte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
