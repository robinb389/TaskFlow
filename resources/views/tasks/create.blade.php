<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Tornar</a>
            <h2 class="font-semibold text-xl text-gray-800">Nova tasca</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">Projecte *</label>
                        <select id="project_id" name="project_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecciona un projecte</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id', request('project_id')) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Títol *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: Dissenyar la pàgina d'inici">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripció</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 mb-5 sm:grid-cols-2">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Estat *</label>
                            <select id="status" name="status"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pendent</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En progrés</option>
                                <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>Feta</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Data límit</label>
                            <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if($tags->isNotEmpty())
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Etiquetes</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="inline-flex items-center gap-1">
                                            <span class="w-3 h-3 rounded-full inline-block" style="background-color: {{ $tag->color }}"></span>
                                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('tasks.index') }}"
                            class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                            Cancel·lar
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
                            Crear tasca
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
