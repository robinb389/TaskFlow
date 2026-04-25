<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $users = User::withCount(['projects', 'tasks'])->latest()->paginate(12);

        return view('users.index', compact('users'));
    }
}
