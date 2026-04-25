<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tags.index') }}" class="text-gray-400 transition hover:text-gray-600">&larr; Back</a>
            <h2 class="text-xl font-semibold text-gray-800">New tag</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                <form action="{{ route('tags.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="mb-2 block text-sm font-medium text-gray-700">Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="color" name="color" value="{{ old('color', '#6366F1') }}"
                                class="h-12 w-20 cursor-pointer rounded-lg border-gray-300 p-1">
                            <input type="text" id="color_hex" value="{{ old('color', '#6366F1') }}"
                                class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="#6366F1">
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4">
                        <p class="mb-2 text-xs text-gray-400">Preview:</p>
                        <span id="preview" class="inline-block rounded-full px-3 py-1 text-sm font-medium text-white"
                            style="background-color: {{ old('color', '#6366F1') }}">
                            {{ old('name', 'Tag') }}
                        </span>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('tags.index') }}"
                            class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Create tag
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const colorInput = document.getElementById('color');
        const colorHexInput = document.getElementById('color_hex');
        const nameInput = document.getElementById('name');
        const preview = document.getElementById('preview');

        function updatePreview() {
            preview.style.backgroundColor = colorInput.value;
            preview.textContent = nameInput.value || 'Tag';
            colorHexInput.value = colorInput.value.toUpperCase();
        }

        colorHexInput.addEventListener('input', () => {
            colorInput.value = colorHexInput.value;
            updatePreview();
        });

        colorInput.addEventListener('input', updatePreview);
        nameInput.addEventListener('input', updatePreview);
    </script>
</x-app-layout>
