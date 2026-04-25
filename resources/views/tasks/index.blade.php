<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Tasks</h2>
            <a href="{{ route('tasks.create') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                + New task
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('tasks.index') }}"
                class="mb-6 flex flex-wrap items-end gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex flex-col">
                    <label class="mb-1 block text-xs font-medium text-gray-500">Status</label>
                    <select name="status" class="h-11 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ str($status)->replace('_', ' ')->title() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="mb-1 block text-xs font-medium text-gray-500">Tag</label>
                    <select name="tag" class="h-11 rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ (string) request('tag') === (string) $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="mb-1 block text-xs font-medium opacity-0">Filter</label>
                    <button type="submit"
                        class="h-11 rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-900">
                        Apply filters
                    </button>
                </div>
                @if(request('status') || request('tag'))
                    <a href="{{ route('tasks.index') }}" class="self-center text-sm text-gray-400 hover:underline">Clear</a>
                @endif
            </form>

            @if($tasks->isEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-16 text-center text-gray-400">
                    No tasks found.
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="min-w-[980px] w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Assigned to</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Tags</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Due date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($tasks as $task)
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-50 text-yellow-700',
                                        'in_progress' => 'bg-blue-50 text-blue-700',
                                        'done' => 'bg-green-50 text-green-700',
                                    ];
                                @endphp
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-6 py-4 align-middle">
                                        <a href="{{ route('tasks.show', $task) }}" class="block font-medium text-gray-900 hover:text-indigo-600">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-gray-500">
                                        {{ optional($task->project)->name ?? 'No project' }}
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-gray-500">
                                        {{ optional($task->user)->name ?? 'Unassigned' }}
                                    </td>
                                    <td class="px-6 py-4 align-middle">
                                        <span class="rounded-full px-2 py-1 text-xs {{ $statusColors[$task->status] }}">
                                            {{ str($task->status)->replace('_', ' ')->title() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-middle">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($task->tags as $tag)
                                                <span class="inline-block rounded-full border border-black/10 px-2 py-0.5 text-xs font-semibold"
                                                    style="background-color: {{ $tag->color }}; color: {{ $tag->text_color }};">
                                                    {{ $tag->name }}
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-400">-</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-middle text-sm text-gray-400">
                                        {{ $task->due_date ? $task->due_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 align-middle text-right">
                                        <div class="flex justify-end gap-3 whitespace-nowrap">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>