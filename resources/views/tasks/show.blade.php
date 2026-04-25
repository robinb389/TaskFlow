<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('tasks.index') }}" class="text-gray-400 transition hover:text-gray-600">&larr; Back</a>
                <h2 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h2>
            </div>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Edit
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
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
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'done' => 'bg-green-50 text-green-700 border-green-200',
                    ];
                @endphp

                <div class="mb-6 flex flex-wrap gap-4">
                    <span class="rounded-full border px-3 py-1 text-xs font-medium {{ $statusColors[$task->status] }}">
                        {{ str($task->status)->replace('_', ' ')->title() }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Project:
                        @if($task->project)
                            <a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:underline">
                                {{ $task->project->name }}
                            </a>
                        @else
                            <strong class="text-gray-700">No project</strong>
                        @endif
                    </span>
                    <span class="text-sm text-gray-500">
                        Assigned to: <strong class="text-gray-700">{{ optional($task->user)->name ?? 'Unknown user' }}</strong>
                    </span>
                    @if($task->due_date)
                        <span class="text-sm text-gray-500">
                            Due date: <strong class="text-gray-700">{{ $task->due_date->format('d/m/Y') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="mb-2 text-sm font-medium text-gray-500">Description</h3>
                    @if($task->description)
                        <p class="whitespace-pre-line text-gray-700">{{ $task->description }}</p>
                    @else
                        <p class="italic text-gray-400">No description available.</p>
                    @endif
                </div>

                @if($task->tags->isNotEmpty())
                    <div>
                        <h3 class="mb-2 text-sm font-medium text-gray-500">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($task->tags as $tag)
                                <span class="inline-block rounded-full border border-black/10 px-3 py-1 text-sm font-semibold"
                                    style="background-color: {{ $tag->color }}; color: {{ $tag->text_color }};">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">
                        &larr; Back to tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
