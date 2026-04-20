<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasques</h2>
            <a href="{{ route('tasks.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                + Nova tasca
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

            <form method="GET" action="{{ route('tasks.index') }}"
                class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Estat</label>
                    <select name="status" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Tots</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendent</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En progrés</option>
                        <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Feta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Etiqueta</label>
                    <select name="tag" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Totes</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition">
                    Filtrar
                </button>
                @if(request('status') || request('tag'))
                    <a href="{{ route('tasks.index') }}" class="text-sm text-gray-400 hover:underline self-center">Netejar</a>
                @endif
            </form>

            @if($tasks->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center text-gray-400">
                    No s'han trobat tasques.
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Títol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projecte</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Etiquetes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data límit</th>
                                <th class="px-6 py-3"></th>
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
                                    $statusLabels = [
                                        'pending' => 'Pendent',
                                        'in_progress' => 'En progrés',
                                        'done' => 'Feta',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tasks.show', $task) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $task->project->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$task->status] }}">
                                            {{ $statusLabels[$task->status] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-1 flex-wrap">
                                            @foreach($task->tags as $tag)
                                                <span class="inline-block px-2 py-0.5 rounded-full text-white text-xs"
                                                    style="background-color: {{ $tag->color }}">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-400">
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', $task) }}" class="text-sm text-gray-500 hover:underline">Editar</a>
                                            @endcan
                                            @can('delete', $task)
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                    onsubmit="return confirm('Eliminar aquesta tasca?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-sm text-red-500 hover:underline">Eliminar</button>
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
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
