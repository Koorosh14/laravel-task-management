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
		Schema::create('tasks', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->text('description')->nullable();
			$table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
			$table->boolean('is_important')->default(false);
			$table->date('due_date')->nullable();
			$table->foreignId('created_by')->constrained('users')->onDelete('cascade');
			$table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->timestamps();

			$table->index('status');
			$table->index('due_date');
			$table->index('assigned_to');
			$table->index(['created_by', 'assigned_to']);
		});

		// We might encounter an issue with `parent_id` foreign key, because the tasks table refers to itself.
		// To prevent this, we'll add the foreign key constraint separately:
		Schema::table('tasks', function (Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('tasks')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tasks');
	}
};
