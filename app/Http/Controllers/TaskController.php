<?php

namespace App\Http\Controllers;

use App\Models\Task;

class TaskController extends Controller
{
	/**
	 * Displays tasks listing.
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function index()
	{
		return view('tasks.index', ['tasks' => Task::all()]);
	}

	/**
	 * Displays a specific task.
	 *
	 * @param	int		$id
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function show($id)
	{
		$task = Task::findOrFail($id); // Find the task or throw 404 if not found
		return view('tasks.show', compact('task'));
	}
}
