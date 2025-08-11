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
		{{-- Navbar --}}
		<div class="container mx-auto flex items-center justify-between py-3 px-4">
			<a class="text-white font-bold text-xl" href="{{ url('/') }}">{{ config('app.name', 'Task Management') }}</a>
			<div class="hidden lg:flex lg:items-center w-full lg:w-auto lg:space-x-4">
				@auth
					<span class="text-white">Welcome, {{ auth()->user()->name ?? auth()->user()->email }}!</span>
				@endauth
				<ul class="flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto">
					<li>
						<a href="{{ route('tasks.index') }}"
							class="block px-3 py-2 rounded {{ request()->is('tasks*') ? 'text-white bg-blue-800' : 'text-white hover:bg-blue-700' }}">
							Tasks
						</a>
					</li>
				</ul>
				<ul class="flex flex-col lg:flex-row lg:space-x-4 mt-2 lg:mt-0">
					@auth
						<li>
							<form method="POST" action="{{ route('logout') }}" class="block bg-red-600 px-3 py-2 rounded text-white hover:bg-red-700">
								@csrf
								<button type="submit">Logout</button>
							</form>
						</li>
					@else
						<li>
							<a href="{{ route('login') }}"
								class="block px-3 py-2 rounded {{ request()->routeIs('login') ? 'text-white bg-blue-800' : 'text-white hover:bg-blue-700' }}">Login</a>
						</li>
						<li>
							<a href="{{ route('register') }}"
								class="block px-3 py-2 rounded {{ request()->routeIs('register') ? 'text-white bg-blue-800' : 'text-white hover:bg-blue-700' }}">Register</a>
						</li>
					@endauth
				</ul>
			</div>
		</div>

		{{-- Mobile navbar --}}
		<div class="sm:hidden">
			<div class="pt-2 pb-3 space-y-1">
				<a href="{{ route('tasks.index') }}"
					class="block pl-3 pr-4 py-2 {{ request()->is('tasks*') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'border-l-4 border-transparent text-white hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
					Tasks
				</a>
				@auth
					<form method="POST" action="{{ route('logout') }}"
						class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-white hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
						@csrf
						<button type="submit">Logout</button>
					</form>
				@else
					<a href="{{ route('login') }}"
						class="block pl-3 pr-4 py-2 {{ request()->routeIs('login') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'border-l-4 border-transparent text-white hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
						Login
					</a>
					<a href="{{ route('register') }}"
						class="block pl-3 pr-4 py-2 {{ request()->routeIs('register') ? 'bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700' : 'border-l-4 border-transparent text-white hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }}">
						Register
					</a>
				@endauth
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
