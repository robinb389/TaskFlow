<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Projects</h2>
            <a href="{{ route('projects.create') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                + New project
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($projects->isEmpty())
                <div class="rounded-xl border border-gray-200 bg-white p-16 text-center text-gray-400">
                    <p class="mb-4 text-lg">No projects found yet.</p>
                    <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Create your first project</a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($projects as $project)
                        <div class="flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="flex-1 p-6">
                                <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $project->name }}</h3>
                                <p class="line-clamp-3 text-sm text-gray-500">
                                    {{ $project->description ?? 'No description provided.' }}
                                </p>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 px-6 py-4">
                                <span class="text-xs text-gray-400">
                                    @if(auth()->user()->is_admin)
                                        {{ optional($project->user)->name ?? 'Unknown owner' }} &middot;
                                    @endif
                                    {{ $project->created_at->format('d/m/Y') }}
                                </span>
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('projects.show', $project) }}" class="text-sm text-indigo-600 hover:underline">View</a>
                                    @can('update', $project)
                                        <a href="{{ route('projects.edit', $project) }}" class="text-sm text-gray-500 hover:underline">Edit</a>
                                    @endcan
                                    @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm text-red-500 hover:underline">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
