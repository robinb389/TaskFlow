<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(auth()->user()->is_admin)
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-4xl font-extrabold text-gray-900">{{ $totalUsers }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total users</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-4xl font-extrabold text-gray-900">{{ $totalProjects }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total projects</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-4xl font-extrabold text-gray-900">{{ $totalTasks }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total tasks</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
                        <p class="text-4xl font-extrabold text-gray-900">{{ $totalTags }}</p>
                        <p class="mt-1 text-sm text-gray-500">Total tags</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium uppercase tracking-wide text-gray-500">My projects</p>
                        <p class="mt-3 text-4xl font-extrabold text-gray-900">{{ $projectCount }}</p>
                        <a href="{{ route('projects.index') }}" class="mt-4 inline-flex text-sm font-semibold text-indigo-600 hover:underline">
                            View projects
                        </a>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm font-medium uppercase tracking-wide text-gray-500">My tasks</p>
                        <p class="mt-3 text-4xl font-extrabold text-gray-900">{{ $taskCount }}</p>
                        <a href="{{ route('tasks.index') }}" class="mt-4 inline-flex text-sm font-semibold text-indigo-600 hover:underline">
                            View tasks
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
