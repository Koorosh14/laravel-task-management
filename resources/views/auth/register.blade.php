@extends('layouts.app')

@section('title', 'Register - Task Management')

@section('content')
	<div class="max-w-md w-full space-y-8 m-auto">
		<div>
			<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
				Create your account
			</h2>
			<p class="mt-2 text-center text-sm text-gray-600">
				Already have an account?
				<a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
					Sign in here
				</a>
			</p>
		</div>

		<form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
			@csrf
			<div class="rounded-md shadow-sm space-y-4">
				<div>
					<label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
					<input id="name" name="name" type="text" autocomplete="name" required
						class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('name') border-red-300 @enderror"
						placeholder="Enter your full name" value="{{ old('name') }}">
					@error('name')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
					<input id="email" name="email" type="email" autocomplete="email" required
						class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-300 @enderror"
						placeholder="Enter your email address" value="{{ old('email') }}">
					@error('email')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="password" class="block text-sm font-medium text-gray-700">Password</label>
					<input id="password" name="password" type="password" autocomplete="new-password" required
						class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-300 @enderror"
						placeholder="Enter your password">
					@error('password')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
					<input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
						class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
						placeholder="Confirm your password">
				</div>
			</div>

			<div>
				<button type="submit"
					class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					<span class="absolute left-0 inset-y-0 flex items-center pl-3">
						<svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path
								d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
						</svg>
					</span>
					Create Account
				</button>
			</div>
		</form>
	</div>
@endsection
