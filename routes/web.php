<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

require base_path('routes/auth-routes.php');
require base_path('routes/dashboard-routes.php');

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function()
{
	if (auth()->check())
		return redirect()->route('dashboard.index');

	return redirect()->route('login');
});

// Authenticated routes (only accessible when authenticated)
Route::middleware('auth')->group(function()
{
	// Tasks routes
	Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
	Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
	Route::post('/tasks/create', [TaskController::class, 'store'])->name('tasks.store');
	Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
	Route::put('/tasks/edit/{task}', [TaskController::class, 'update'])->name('tasks.update');
	Route::patch('/tasks/edit/{task}', [TaskController::class, 'updateStatus'])->name('tasks.update_status');
	Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
	Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
});
