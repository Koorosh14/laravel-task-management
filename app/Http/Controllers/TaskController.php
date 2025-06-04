<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\TaskStatus;
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

		$tasks = Task::query()->with(['creator', 'assignee']);

		if (!empty($status = TaskStatus::tryFrom($filters['status'])))
			$tasks = $tasks->where('status', $status);

		$sort   = in_array($filters['sort'], ['title', 'due_date', 'created_at', 'is_important']) ? $filters['sort'] : 'due_date';
		$sortBy = in_array(strtoupper($filters['sort_by']), ['ASC', 'DESC']) ? strtoupper($filters['sort_by']) : 'ASC';
		$tasks  = $tasks->orderBy($sort, $sortBy);

		// Add a default due date sort if the selected option is different
		if ($sort !== 'due_date')
			$tasks = $tasks->orderBy('due_date', 'ASC');

		$tasks = $tasks->paginate(10);

		return view('tasks.index', compact('tasks', 'filters'));
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
