<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::fallback(function (){
    return to_route('tasks.index');
});

Route::get('/login', [AuthController::class, 'loginView'])
    ->name('login');

Route::get('/register', [AuthController::class, 'registerView'])
    ->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::any('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')
    ->resource('tasks', TaskController::class)
    ->scoped(['task' => 'slug']);
