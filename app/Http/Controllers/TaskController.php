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
		$tasks = Task::with(['creator', 'assignee'])
			->latest()
			->paginate(10);

		return view('tasks.index', compact('tasks'));
	}

	/**
	 * Displays a specific task.
	 *
	 * @param	Task		$task
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function show(Task $task)
	{
		return view('tasks.show', compact('task'));
	}
}
