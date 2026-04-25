<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.index') }}" class="text-gray-400 transition hover:text-gray-600">&larr; Back</a>
                <h2 class="text-xl font-semibold text-gray-800">{{ $project->name }}</h2>
            </div>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Edit
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                        onsubmit="return confirm('Delete this project and all related tasks?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="mb-3 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <span>Owner: <strong class="text-gray-700">{{ optional($project->user)->name ?? 'Unknown user' }}</strong></span>
                    <span>Created: {{ $project->created_at->format('d/m/Y') }}</span>
                </div>
                @if($project->description)
                    <p class="text-gray-600">{{ $project->description }}</p>
                @else
                    <p class="italic text-gray-400">No description available.</p>
                @endif
            </div>

            <div class="mb-4 flex items-center justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Tasks
                    <span class="ml-1 text-sm font-normal text-gray-400">({{ $project->tasks->count() }})</span>
                </h3>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    + New task
                </a>
            </div>

            @if($project->tasks->isEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-12 text-center text-gray-400">
                    This project has no tasks yet.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($project->tasks as $task)
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'done' => 'bg-green-50 text-green-700 border-green-200',
                            ];
                        @endphp
                        <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md md:flex-row md:items-center md:justify-between">
                            <div class="flex min-w-0 flex-1 flex-wrap items-center gap-4">
                                <span class="whitespace-nowrap rounded-full border px-2 py-1 text-xs {{ $statusColors[$task->status] }}">
                                    {{ str($task->status)->replace('_', ' ')->title() }}
                                </span>
                                <a href="{{ route('tasks.show', $task) }}" class="truncate font-medium text-gray-900 hover:text-indigo-600">
                                    {{ $task->title }}
                                </a>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($task->tags as $tag)
                                        <span class="inline-block rounded-full border border-black/10 px-2 py-0.5 text-xs font-semibold"
                                            style="background-color: {{ $tag->color }}; color: {{ $tag->text_color }};">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ml-0 flex items-center gap-3 md:ml-4">
                                @if($task->due_date)
                                    <span class="text-xs text-gray-400">{{ $task->due_date->format('d/m/Y') }}</span>
                                @endif
                                @can('update', $task)
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-sm text-gray-500 hover:underline">Edit</a>
                                @endcan
                                @can('delete', $task)
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-500 hover:underline">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
