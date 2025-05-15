<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('logs', function (Blueprint $table) {
			$table->id();
			$table->string('action'); // e.g., 'created', 'updated', 'deleted'
			$table->json('details')->nullable();
			$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
			$table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('cascade');
			$table->timestamps();

			$table->index('task_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('logs');
	}
};
