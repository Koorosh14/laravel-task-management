<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Dashboard routes (require authentication)
Route::middleware('auth')->group(function()
{
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
