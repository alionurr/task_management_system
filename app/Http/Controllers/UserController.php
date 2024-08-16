<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function userProjects($userId)
    {
        $user = User::with('projects')->findOrFail($userId);
        return response()->json($user->projects);
    }

    public function userTasks($userId)
    {
        $user = User::with('projects.tasks')->findOrFail($userId);

        $tasks = $user->projects->flatMap(function ($project) {
            return $project->tasks;
        });

        return response()->json($tasks);
    }
}
