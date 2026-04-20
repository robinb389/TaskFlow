<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $query = $user->isAdmin() ? Task::query() : $user->tasks();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('tags.id', $request->tag));
        }

        $tasks = $query->with(['project', 'tags'])->latest()->paginate(10);
        $tags  = Tag::all();

        return view('tasks.index', compact('tasks', 'tags'));
    }

    public function create()
    {
        $projects = auth()->user()->isAdmin()
            ? Project::all()
            : auth()->user()->projects;

        $tags = Tag::all();
        return view('tasks.create', compact('projects', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,done',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $task = auth()->user()->tasks()->create([
            'project_id'  => $validated['project_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'due_date'    => $validated['due_date'] ?? null,
        ]);

        $task->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('tasks.show', $task)->with('success', 'Tasca creada.');
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
        $projects = auth()->user()->isAdmin() ? Project::all() : auth()->user()->projects;
        $tags     = Tag::all();
        return view('tasks.edit', compact('task', 'projects', 'tags'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,done',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $task->update([
            'project_id'  => $validated['project_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'],
            'due_date'    => $validated['due_date'] ?? null,
        ]);

        $task->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('tasks.show', $task)->with('success', 'Tasca actualitzada.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tasca eliminada.');
    }
}