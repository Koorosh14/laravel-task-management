<?php

namespace App\Models;

use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
	/** @use HasFactory<\Database\Factories\TaskFactory> */
	use HasFactory;

	protected $fillable = ['title', 'description', 'status', 'is_important', 'due_date', 'created_by', 'assigned_to', 'parent_id'];

	protected $casts = [
		'status' => TaskStatus::class,
		'is_important' => 'boolean',
		'due_date' => 'datetime',
	];

	public function creator()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function assignee()
	{
		return $this->belongsTo(User::class, 'assigned_to');
	}

	public function parent()
	{
		return $this->belongsTo(Task::class, 'parent_id');
	}

	/**
	 * Returns all the subtasks for this task.
	 *
	 * To test and see if this is working:
	 * 		php artisan tinker
	 * 		\App\Models\Task::all()->get(0)->subtasks
	 *
	 * @return	HasMany<TRelatedModel, $this>
	 */
	public function subtasks()
	{
		return $this->hasMany(Task::class, 'parent_id');
	}

	/**
	 * Returns all logs for this task.
	 *
	 * To test and see if this is working:
	 * 		php artisan tinker
	 * 		\App\Models\Task::all()->get(0)->logs
	 *
	 * @return	HasMany<TRelatedModel, $this>
	 */
	public function logs()
	{
		return $this->hasMany(Log::class);
	}

	/**
	 * Returns tasks created by and assigned to the given user (with search, filters and sorting).
	 *
	 * @param	int		$userId
	 * @param	array	$filters
	 *
	 * @return	Task[]
	 */
	public static function getFilteredTasks(int $userId, array $filters)
	{
		$tasks = Task::query()->with(['creator', 'assignee'])
			->where(function($query) use ($userId)
			{
				$query->where('created_by', $userId)
					->orWhere('assigned_to', $userId);
			});

		if (!empty($filters['search']))
		{
			$tasks->where('title', 'LIKE', "%{$filters['search']}%")
				->orWhere('description', 'LIKE', "%{$filters['search']}%");
		}

		if (!empty($status = TaskStatus::tryFrom($filters['status'])))
			$tasks = $tasks->where('status', $status);

		$sort   = in_array($filters['sort'], ['title', 'due_date', 'created_at', 'is_important']) ? $filters['sort'] : 'due_date';
		$sortBy = in_array(strtoupper($filters['sort_by']), ['ASC', 'DESC']) ? strtoupper($filters['sort_by']) : 'ASC';
		$tasks  = $tasks->orderBy($sort, $sortBy);

		// Add a default due date sort if the selected option is different
		if ($sort !== 'due_date')
			$tasks = $tasks->orderBy('due_date', 'ASC');

		return $tasks->paginate(10);
	}
}
