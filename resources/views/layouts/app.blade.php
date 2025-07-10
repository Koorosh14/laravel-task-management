<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Task Management') }} - @yield('title')</title>

	@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	@endif
</head>

<body>
	<main class="container my-4 mx-auto">
		@if (session('success'))
			<div id="flash-message-success" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
				{{ session('success') }}
			</div>
			<script>
				setTimeout(() => { document.getElementById('flash-message-success').style.display = 'none'; }, 5000);
			</script>
		@endif

		@if (session('error'))
			<div id="flash-message-error" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
				{{ session('error') }}
			</div>
			<script>
				setTimeout(() => { document.getElementById('flash-message-error').style.display = 'none'; }, 5000);
			</script>
		@endif

		@yield('content')
	</main>

	<footer class="bg-light py-4 mt-5">
		<div class="container text-center">
			<p class="mb-0">{{ config('app.name', 'Task Management') }} &copy; {{ date('Y') }}</p>
		</div>
	</footer>
</body>

</html>
