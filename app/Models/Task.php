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
}
