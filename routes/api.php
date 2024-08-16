<?php

use App\Http\Middleware\JwtAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\IsAdmin;

Route::post('/login', [AuthController::class, 'login']);

// 
Route::middleware([JwtAuth::class])->group(function () {
    Route::middleware([IsAdmin::class])->group(function () {
        // Projects
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
        // Tasks
        Route::post('/projects/{project_id}/tasks', [TaskController::class, 'store']);
        Route::put('/tasks/{task_id}', [TaskController::class, 'update']);
        Route::delete('/tasks/{task_id}', [TaskController::class, 'destroy']);
        // Users
        Route::post('/users', [UserController::class, 'store']);

    });
    // Projects
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    
    // Tasks
    Route::get('/projects/{project_id}/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{task_id}', [TaskController::class, 'show']);
    
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user_id}/projects', [UserController::class, 'userProjects']);
    Route::get('/users/{user_id}/tasks', [UserController::class, 'userTasks']);
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
