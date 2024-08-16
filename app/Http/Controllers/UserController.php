<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($request->all());

        return response()->json($user, 201); 
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
