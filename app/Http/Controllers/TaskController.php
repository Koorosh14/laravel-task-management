<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
	/**
	 * Displays tasks listing.
	 *
	 * @param	Request		$request
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function index(Request $request)
	{
		$filters = [
			'status'  => $request->query->get('status'),
			'sort'    => $request->query->get('sort', 'due_date'),
			'sort_by' => $request->query->get('sort_by', 'ASC'),
		];

		return view('tasks.index', [
			'tasks'   => Task::getFilteredTasks($filters),
			'filters' => $filters,
		]);
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
