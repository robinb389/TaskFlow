<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                ← Tornar
            </a>
            <h2 class="font-semibold text-xl text-gray-800">Nou projecte</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">

                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom del projecte *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Web corporativa">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripció</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Descripció opcional del projecte...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('projects.index') }}"
                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
                            Crear projecte
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
