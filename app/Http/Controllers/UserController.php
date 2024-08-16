<?php

namespace App\Http\Controllers;

use App\Mail\UserRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $purePassword = $request->input('password');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',           
            'password' => 'required|string|min:4|max:16',           
            'role' => ['required', 'string', 'in:admin,user'],           
        ], [
            'role.in' => 'The selected role is invalid. It must be either admin or user.'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $request['password'] = Hash::make($request->input('password'));

        $user = User::create($request->all());
        // Kullanıcı kayıt edildikten sonra mail gönderilecek
        Mail::to($user->email)->queue( new UserRegister($user, $purePassword) );

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
