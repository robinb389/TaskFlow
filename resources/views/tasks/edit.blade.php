<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.show', $task) }}" class="text-gray-400 transition hover:text-gray-600">&larr; Back</a>
            <h2 class="text-xl font-semibold text-gray-800">Edit task</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="project_id" class="mb-2 block text-sm font-medium text-gray-700">Project *</label>
                        <select id="project_id" name="project_id"
                            class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="mb-2 block text-sm font-medium text-gray-700">Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                            class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <label for="user_id" class="mb-2 block text-sm font-medium text-gray-700">Assigned to *</label>
                            <select id="user_id" name="user_id"
                                class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($assignees as $assignee)
                                    <option value="{{ $assignee->id }}" {{ (string) old('user_id', $task->user_id) === (string) $assignee->id ? 'selected' : '' }}>
                                        {{ $assignee->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status *</label>
                            <select id="status" name="status"
                                class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status', $task->status) === $status ? 'selected' : '' }}>
                                        {{ str($status)->replace('_', ' ')->title() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="mb-2 block text-sm font-medium text-gray-700">Due date</label>
                            <input type="date" id="due_date" name="due_date"
                                value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}"
                                class="h-12 w-full rounded-lg border-gray-300 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if($tags->isNotEmpty())
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Tags</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                                            {{ collect(old('tag_ids', $task->tags->pluck('id')->all()))->contains($tag->id) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="inline-flex items-center gap-1">
                                            <span class="inline-block h-3 w-3 rounded-full border border-black/10" style="background-color: {{ $tag->color }}"></span>
                                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('tag_ids')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('tasks.show', $task) }}"
                            class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
