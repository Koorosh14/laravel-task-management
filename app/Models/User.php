<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	/** @use HasFactory<\Database\Factories\UserFactory> */
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var list<string>
	 */
	protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var list<string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	/**
	 * Returns all the tasks created by this user.
	 *
	 * To test and see if this is working:
	 * 		php artisan tinker
	 * 		\App\Models\User::all()->get(0)->createdTasks
	 *
	 * @return	HasMany<TRelatedModel, $this>
	 */
	public function createdTasks()
	{
		return $this->hasMany(Task::class, 'created_by');
	}

	/**
	 * Returns all the tasks assigned to this user.
	 *
	 * To test and see if this is working:
	 * 		php artisan tinker
	 * 		\App\Models\User::all()->get(0)->assignedTasks
	 *
	 * @return	HasMany<TRelatedModel, $this>
	 */
	public function assignedTasks()
	{
		return $this->hasMany(Task::class, 'assigned_to');
	}
}
