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

	/**
	 * Displays the form for creating a new task.
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function create()
	{
		return view('tasks.create');
	}

	/**
	 * Stores a newly created task.
	 *
	 * @param	Request		$request
	 *
	 * @return	\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		// Validate the request
		$validated = $request->validate([
			'title'        => 'required|string|max:512',
			'description'  => 'nullable|string',
			'status'       => 'required|in:pending,in_progress,completed',
			// 'is_important' => 'sometimes|boolean',
			'due_date'     => 'nullable|date',
		]);

		$validated['created_by']   = 1; // Temporary placeholder for now
		$validated['is_important'] = $request->has('is_important');

		$task = Task::create($validated);

		return redirect()->route('tasks.show', $task->id)
			->with('success', 'Task created successfully');
	}

	/**
	 * Displays the form for editing a specified task.
	 *
	 * @param	Task		$task
	 *
	 * @return	\Illuminate\Contracts\View\View
	 */
	public function edit(Task $task)
	{
		return view('tasks.edit', compact('task'));
	}

	/**
	 * Updates a specified task.
	 *
	 * @param	Request		$request
	 * @param	Task		$task
	 *
	 * @return	\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Task $task)
	{
		// Validate the request
		$validated = $request->validate([
			'title'        => 'required|string|max:512',
			'description'  => 'nullable|string',
			'status'       => 'required|in:pending,in_progress,completed',
			// 'is_important' => 'sometimes|boolean',
			'due_date'     => 'nullable|date',
		]);

		$validated['is_important'] = $request->has('is_important');

		$task->update($validated);

		return redirect()->route('tasks.show', $task->id)
			->with('success', 'Task updated successfully');
	}

	/**
	 * Updates only the status of a specified task.
	 *
	 * @param	Request		$request
	 * @param	Task		$task
	 *
	 * @return	\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function updateStatus(Request $request, Task $task)
	{
		// Validate status
		$validated = $request->validate(['status' => 'required|in:pending,in_progress,completed']);

		// Update task status
		$task->update($validated);

		return redirect()->back()->with('success', 'Task status updated');
	}

	/**
	 * Removes a specified task.
	 *
	 * @param	Task		$task
	 *
	 * @return	\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	public function destroy(Task $task)
	{
		$task->delete();

		return redirect()->route('tasks.index')
			->with('success', 'Task deleted successfully');
	}
}
