<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	/** @use HasFactory<\Database\Factories\TaskFactory> */
	use HasFactory;

	protected $fillable = ['title', 'description', 'status', 'is_important', 'due_date', 'created_by', 'assigned_to', 'parent_id'];

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

	public function subtasks()
	{
		return $this->hasMany(Task::class, 'parent_id');
	}
}
