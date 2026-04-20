<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tags.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Tornar</a>
            <h2 class="font-semibold text-xl text-gray-800">Editar etiqueta</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">

                <form action="{{ route('tags.update', $tag) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="color" name="color" value="{{ old('color', $tag->color) }}"
                                class="h-10 w-16 rounded-lg border-gray-300 cursor-pointer">
                            <span class="text-sm text-gray-400">Selecciona un color per a l'etiqueta</span>
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-400 mb-2">Previsualització:</p>
                        <span id="preview" class="inline-block px-3 py-1 rounded-full text-white text-sm font-medium"
                            style="background-color: {{ old('color', $tag->color) }}">
                            {{ old('name', $tag->name) }}
                        </span>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('tags.index') }}"
                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
                            Desar canvis
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const colorInput = document.getElementById('color');
        const nameInput = document.getElementById('name');
        const preview = document.getElementById('preview');

        function updatePreview() {
            preview.style.backgroundColor = colorInput.value;
            preview.textContent = nameInput.value || 'Etiqueta';
        }

        colorInput.addEventListener('input', updatePreview);
        nameInput.addEventListener('input', updatePreview);
    </script>
</x-app-layout>
