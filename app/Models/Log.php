<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	/** @use HasFactory<\Database\Factories\LogFactory> */
	use HasFactory;

	protected $fillable = ['action', 'details', 'user_id', 'task_id'];

	// Cast details to array (since it's JSON)
	protected $casts = [
		'details' => 'array',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function task()
	{
		return $this->belongsTo(Task::class);
	}
}
