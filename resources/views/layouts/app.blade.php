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
