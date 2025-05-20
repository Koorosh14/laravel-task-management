# Seting-up a New Laravel Project
This is a step-by-step guide on how to set-up a new Laravel project.

## The initial setup steps

### Create a New Laravel Project:
`composer create-project laravel/laravel laravel-task-management`

### Navigate to Your Project Directory
```
cd laravel-task-management
```
And rename `.env.example` to `.env`

### Generate App Key (if needed)
```
php artisan key:generate
```

### Configure the Database Connection
Edit the `.env` file to set up your database connection:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Update .env for Development
Set `APP_ENV=dev` and `APP_DEBUG=true` in `.env` for development mode.

### Essential (Recommended) Packages to Install
<details>
<summary>Install these if not already present in composer.json:</summary>

Tailwind CSS:
Tailwind is already installed in the recent versions of Laravel, and all you need to do is to run `npm run dev`. But if by any reason it's not already installed, follow [these steps](https://tailwindcss.com/docs/installation/using-vite).

Laravel Debugbar:
```
composer require barryvdh/laravel-debugbar --dev
```

Laravel Breeze (lightweight authentication):
```
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

Laravel Sanctum (for API authentication if needed):
```
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```
</details>

### Frontend Dependencies
```
npm install
```

And to run Tailwind and other dependencies:
```
npm run dev
```

### Initialize Git
```
git init
```
> Also create `.gitignore` if it's not already included in the project.

## Create Model, Migration, Factory and Seeder
```
php artisan make:model Task -mcfs
```
> -mcfs stands for: migration, controller, factory, seeder.

> Note that you should use a singular name for the class and write it in PascalCase.

If you don't want to use the `-mcfs` flag, you can use other separate Artisan commands like:
```
php arisan make:migration create_tasks_table
OR
php artisan make:migration update_users_table --table=users
```
> Note that you should use snake_case here and the table name should be plural.

Or:
```
php artisan make:seeder TaskSeeder
```

## Update migration:
<details>
<summary>Update the `up()` method in your newly created migration based on your needs, for example:</summary>

```
public function up(): void
{
	Schema::create('tasks', function (Blueprint $table) {
		$table->id();
		$table->string('title');
		$table->text('description')->nullable();
		// more columns
		$table->timestamps();
	});
}
```
</details>

Don't forget to also add `$fillable` and relationships to your models if necessary.

And finally, execute the migration:
```
php artisan migrate
```
> If you wanted to role back a migration, you can use the `php artisan migrate:rollback` command.

## Add/Check rows in the database
You can use a visual database explorer (like phpMyAdmin) for this, or you use Artisan's Tinker:
```
php artisan tinker
use App\Models\Task
```

Now you can see all the created tasks:
```
Task::all();
```

Or create new ones:
```
Task::create(['name' => ....]);
```

## Add dummy/fake data to the database
You can use faker in the factory class of your newly created model to populate dummy data. For example in `TaskFactory.php`:
```
return [
	'title' => fake()->name(),
	'description' => fake()->realText(500),
	'progress' => fake()->numberBetween(0, 100),
	'created_by' => User::all()->random()->id,
	...
];
```
Then you can use Tinker to generate fake values in the database:
```
php artisan tinker
use App\Models\Task
Task::factory()->count(50)->create()
```

But if you don't want to run Tinker manually everytime, add this code in `run()` method of your newly created Seeder class:
```
Task::factory()->count(50)->create();
```
Then add this to `DatabaseSeeder` class:
```
$this->class([
	TaskSeeder::class,
]);
```
And lastly, run this command:
```
php artisan migrate:refresh --seed
OR
php artisan migrate:fresh --seed
```
> Note: We could've added the factory create method directly in the `DatabaseSeeder` class, but it's better to separate the seeders to keep the code more scalable.

## Add controllers, views and routes
First, create your controller:
```
php artisan make:controller TaskController
```
> Note that you should use a singular name with a `Controller` suffix for the class and write it in PascalCase.

Then your views:
```
php artisan make:view tasks.index
OR maybe
php artisan make:view layouts.app
```
> Or you can manually create view templtaes via file explorer.

And then, bind them together in your `routes/web.php` file:
```
Route::get('/tasks', [TaskController:class, 'index'])->('tasks.index');
```
> Note that for routes (and template paths) you should use a lowercase letters and separate folders with a `.`.

And if you wanted to point to your named route in your view:
```
{{ route('tasks.index') }}
OR maybe
{{ route('tasks.show', $task->id) }}
```

## Run the server
```
php artisan serve
```
Then you should be able to see Laravel's welcome page at http://localhost:8000.
