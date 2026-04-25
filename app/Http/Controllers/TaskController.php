<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $user = auth()->user();
        $query = $user->is_admin ? Task::query() : $user->tasks();

        if ($request->filled('status')) {
            $query->where('status', (string) $request->string('status'));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn ($tagQuery) => $tagQuery->where('tags.id', $request->integer('tag')));
        }

        $tasks = $query
            ->with(['project', 'tags', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $tags = Tag::orderBy('name')->get();
        $statuses = ['pending', 'in_progress', 'done'];

        return view('tasks.index', compact('tasks', 'tags', 'statuses'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $user = auth()->user();
        $projects = $this->availableProjectsFor($user);

        if ($projects->isEmpty()) {
            return redirect()->route('projects.create')->with('warning', 'Create a project before adding tasks.');
        }

        $assignees = $this->availableAssigneesFor($user);
        $tags = Tag::orderBy('name')->get();
        $statuses = ['pending', 'in_progress', 'done'];

        return view('tasks.create', compact('projects', 'assignees', 'tags', 'statuses'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $user = auth()->user();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,done',
            'due_date' => 'nullable|date',
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function ($query) use ($user) {
                    if (! $user->is_admin) {
                        $query->where('user_id', $user->id);
                    }
                }),
            ],
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id'),
                function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                    if ($value && ! $user->isAdmin() && (int) $value !== $user->id) {
                        $fail('You can only assign tasks to yourself.');
                    }
                },
            ],
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $task = Task::create([
            'project_id' => $validated['project_id'],
            'user_id' => $user->isAdmin() ? ($validated['user_id'] ?? $user->id) : $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        $task->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load('tags', 'project', 'user');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $user = auth()->user();
        $projects = $this->availableProjectsFor($user);
        $assignees = $this->availableAssigneesFor($user);
        $tags = Tag::orderBy('name')->get();
        $statuses = ['pending', 'in_progress', 'done'];

        return view('tasks.edit', compact('task', 'projects', 'assignees', 'tags', 'statuses'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $user = auth()->user();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,done',
            'due_date' => 'nullable|date',
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function ($query) use ($user) {
                    if (! $user->is_admin) {
                        $query->where('user_id', $user->id);
                    }
                }),
            ],
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id'),
                function (string $attribute, mixed $value, \Closure $fail) use ($user) {
                    if ($value && ! $user->isAdmin() && (int) $value !== $user->id) {
                        $fail('You can only assign tasks to yourself.');
                    }
                },
            ],
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        $task->update([
            'project_id' => $validated['project_id'],
            'user_id' => $user->isAdmin() ? ($validated['user_id'] ?? $task->user_id) : $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        $task->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    private function availableProjectsFor(User $user)
    {
        return $user->is_admin
            ? Project::with('user')->orderBy('name')->get()
            : $user->projects()->orderBy('name')->get();
    }

    private function availableAssigneesFor(User $user)
    {
        return $user->isAdmin()
            ? User::orderBy('name')->get(['id', 'name'])
            : User::whereKey($user->id)->get(['id', 'name']);
    }
}
