<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('tasks.index') }}" class="text-gray-400 hover:text-gray-600 transition">← Tornar</a>
                <h2 class="font-semibold text-xl text-gray-800">{{ $task->title }}</h2>
            </div>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                        Editar
                    </a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        onsubmit="return confirm('Eliminar aquesta tasca?')">
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
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">

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

                <div class="flex flex-wrap gap-4 mb-6">
                    <span class="text-xs px-3 py-1 rounded-full border font-medium {{ $statusColors[$task->status] }}">
                        {{ $statusLabels[$task->status] }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Projecte:
                        <a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:underline">
                            {{ $task->project->name }}
                        </a>
                    </span>
                    <span class="text-sm text-gray-500">
                        Assignat a: <strong class="text-gray-700">{{ $task->user->name }}</strong>
                    </span>
                    @if($task->due_date)
                        <span class="text-sm text-gray-500">
                            Data límit: <strong class="text-gray-700">{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Descripció</h3>
                    @if($task->description)
                        <p class="text-gray-700 whitespace-pre-line">{{ $task->description }}</p>
                    @else
                        <p class="text-gray-400 italic">Sense descripció.</p>
                    @endif
                </div>

                @if($task->tags->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Etiquetes</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($task->tags as $tag)
                                <span class="inline-block px-3 py-1 rounded-full text-white text-sm font-medium"
                                    style="background-color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
