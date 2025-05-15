<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title'        => fake()->name(),
			'description'  => fake()->realText(500),
			'status'       => fake()->randomElement(['pending', 'in_progress', 'completed']),
			'is_important' => fake()->boolean(10),
			'due_date'     => fake()->dateTimeBetween('-1 week', '+1 week'),
			'created_by'   => User::all()->random()->id,
			'assigned_to'  => User::all()->random()->id,
		];
	}
}
