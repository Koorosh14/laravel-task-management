<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Guest routes (only accessible when not authenticated)
Route::middleware('guest')->group(function()
{
	// Login routes
	Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
	Route::post('/login', [AuthController::class, 'login']);

	// Registration routes
	Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
	Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes (only accessible when authenticated)
Route::middleware('auth')->group(function()
{
	// Logout route
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
