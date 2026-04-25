<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is_admin) {
            return view('dashboard', [
                'totalUsers' => User::count(),
                'totalProjects' => Project::count(),
                'totalTasks' => Task::count(),
                'totalTags' => Tag::count(),
            ]);
        }

        return view('dashboard', [
            'projectCount' => $user->projects()->count(),
            'taskCount' => $user->tasks()->count(),
        ]);
    }
}
