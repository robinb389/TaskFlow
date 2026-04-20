<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(auth()->user()->isAdmin())
                <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-3">
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 text-center">
                        <p class="text-4xl font-extrabold text-indigo-600">{{ $totalProjects }}</p>
                        <p class="text-sm text-gray-500 mt-1">Projectes totals</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 text-center">
                        <p class="text-4xl font-extrabold text-green-600">{{ $totalTasks }}</p>
                        <p class="text-sm text-gray-500 mt-1">Tasques totals</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 text-center">
                        <p class="text-4xl font-extrabold text-purple-600">{{ $totalUsers }}</p>
                        <p class="text-sm text-gray-500 mt-1">Usuaris registrats</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Últims projectes</h3>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Propietari</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($projects as $project)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $project->name }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $project->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-400 text-sm">{{ $project->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:underline text-sm">Veure</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Sense projectes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Els meus projectes</h3>
                            <a href="{{ route('projects.create') }}" class="text-sm text-indigo-600 hover:underline">+ Nou</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($projects as $project)
                                <a href="{{ route('projects.show', $project) }}"
                                    class="block bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="font-medium text-gray-900">{{ $project->name }}</span>
                                        <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full whitespace-nowrap">
                                            {{ $project->tasks_count }} tasques
                                        </span>
                                    </div>
                                    @if($project->description)
                                        <p class="text-sm text-gray-400 mt-1 truncate">{{ $project->description }}</p>
                                    @endif
                                </a>
                            @empty
                                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
                                    Encara no tens projectes.
                                    <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline ml-1">Crea'n un</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Últimes tasques</h3>
                            <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:underline">Veure totes</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($tasks as $task)
                                <a href="{{ route('tasks.show', $task) }}"
                                    class="block bg-white rounded-xl border border-gray-200 shadow-sm p-4 hover:shadow-md transition">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="font-medium text-gray-900 truncate">{{ $task->title }}</span>
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
                                        <span class="text-xs px-2 py-1 rounded-full {{ $statusColors[$task->status] }} whitespace-nowrap">
                                            {{ $statusLabels[$task->status] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">{{ $task->project->name }}</p>
                                </a>
                            @empty
                                <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
                                    Sense tasques recents.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
