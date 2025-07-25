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
		Schema::table('users', function (Blueprint $table) {
			Schema::table('users', function (Blueprint $table) {
				// Add role as enum and is_active as boolean
				$table->enum('role', ['user', 'admin'])->default('user')->after('password');
				$table->boolean('is_active')->default(true)->after('role');

				// Make name nullable
				$table->string('name')->nullable()->change();
			});
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(['role', 'is_active']);
			$table->string('name')->nullable(false)->change();
		});
	}
};
