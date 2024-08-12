<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

// 
Route::middleware('jwt.auth')->group(function () {
    Route::get('/user', function () {
        return response()->json(['user' => auth()->user()]);
    });
});
