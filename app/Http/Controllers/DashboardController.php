<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $data = [
                'totalProjects' => Project::count(),
                'totalTasks'    => Task::count(),
                'totalUsers'    => User::count(),
                'projects'      => Project::with('user')->latest()->take(5)->get(),
            ];
        } else {
            $data = [
                'projects' => $user->projects()->withCount('tasks')->latest()->get(),
                'tasks'    => $user->tasks()->with('project')->latest()->take(5)->get(),
            ];
        }

        return view('dashboard', $data);
    }
}