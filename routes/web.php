<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/edit/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
