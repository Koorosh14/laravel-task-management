<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Task Management') }} - @yield('title')</title>

	{{-- Scripts --}}
	@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	@endif
</head>

<body>
	<nav class="bg-blue-600 mb-4">
		<div class="container mx-auto flex items-center justify-between py-3 px-4">
			<a class="text-white font-bold text-xl" href="{{ url('/') }}">{{ config('app.name', 'Task Management') }}</a>
			<div class="hidden lg:flex lg:items-center w-full lg:w-auto lg:space-x-4">
				<ul class="flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto">
					<li>
						<a class="block px-3 py-2 rounded {{ request()->is('tasks*') ? 'bg-blue-800 text-white' : 'text-white hover:bg-blue-700' }}" href="{{ route('tasks.index') }}">Tasks</a>
					</li>
				</ul>
				<ul class="flex flex-col lg:flex-row lg:space-x-4 mt-2 lg:mt-0">
					<li>
						<a class="block px-3 py-2 rounded text-white hover:bg-blue-700" href="#">Login</a>
					</li>
					<li>
						<a class="block px-3 py-2 rounded text-white hover:bg-blue-700" href="#">Register</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<main class="container my-4 mx-auto">
		<x-flash-message type="success" class="bg-green-100 border-green-500 text-green-700" />
		<x-flash-message type="error" class="bg-red-100 border-red-500 text-red-700" />

		@yield('content')
	</main>

	<footer class="bg-light py-4 mt-5">
		<div class="container text-center">
			<p class="mb-0">{{ config('app.name', 'Task Management') }} &copy; {{ date('Y') }}</p>
		</div>
	</footer>
</body>

</html>
