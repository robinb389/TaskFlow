<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Tornar</a>
                <h2 class="font-semibold text-xl text-gray-800">{{ $project->name }}</h2>
            </div>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Editar
                    </a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}" method="POST"
                        onsubmit="return confirm('Eliminar aquest projecte i totes les seves tasques?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition">
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-8">
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-3">
                    <span>Propietari: <strong class="text-gray-700">{{ $project->user->name }}</strong></span>
                    <span>Creat: {{ $project->created_at->format('d/m/Y') }}</span>
                </div>
                @if($project->description)
                    <p class="text-gray-600">{{ $project->description }}</p>
                @else
                    <p class="text-gray-400 italic">Sense descripció.</p>
                @endif
            </div>

            <div class="flex items-center justify-between gap-4 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Tasques
                    <span class="text-sm font-normal text-gray-400 ml-1">({{ $project->tasks->count() }})</span>
                </h3>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                    + Nova tasca
                </a>
            </div>

            @if($project->tasks->isEmpty())
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-400">
                    Encara no hi ha tasques en aquest projecte.
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
                            $statusLabels = [
                                'pending' => 'Pendent',
                                'in_progress' => 'En progrés',
                                'done' => 'Feta',
                            ];
                        @endphp
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between hover:shadow-md transition">
                            <div class="flex items-center gap-4 flex-1 min-w-0 flex-wrap">
                                <span class="text-xs px-2 py-1 rounded-full border {{ $statusColors[$task->status] }} whitespace-nowrap">
                                    {{ $statusLabels[$task->status] }}
                                </span>
                                <a href="{{ route('tasks.show', $task) }}" class="font-medium text-gray-900 hover:text-indigo-600 truncate">
                                    {{ $task->title }}
                                </a>
                                <div class="flex gap-1 flex-wrap">
                                    @foreach($task->tags as $tag)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-white text-xs"
                                            style="background-color: {{ $tag->color }}">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-0 md:ml-4 shrink-0">
                                @if($task->due_date)
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</span>
                                @endif
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
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
