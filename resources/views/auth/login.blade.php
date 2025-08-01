@extends('layouts.app')

@section('title', 'Login - Task Management')

@section('content')
	<div class="max-w-md w-full space-y-8 m-auto">
		<div>
			<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
				Sign in to your account
			</h2>
			<p class="mt-2 text-center text-sm text-gray-600">
				Don't have an account?
				<a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
					Sign up here
				</a>
			</p>
		</div>

		<form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
			@csrf
			<div class="rounded-md shadow-sm -space-y-px">
				<div>
					<label for="email" class="sr-only">Email address</label>
					<input id="email" name="email" type="email" autocomplete="email" required
						class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-300 @enderror"
						placeholder="Email address" value="{{ old('email') }}">
					@error('email')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>
				<div>
					<label for="password" class="sr-only">Password</label>
					<input id="password" name="password" type="password" autocomplete="current-password" required
						class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-300 @enderror"
						placeholder="Password">
					@error('password')
						<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="flex items-center justify-between">
				<div class="flex items-center">
					<input id="remember" name="remember" type="checkbox"
						class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
					<label for="remember" class="ml-2 block text-sm text-gray-900">
						Remember me
					</label>
				</div>
			</div>

			<div>
				<button type="submit"
					class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
					<span class="absolute left-0 inset-y-0 flex items-center pl-3">
						<svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd"
								d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
								clip-rule="evenodd" />
						</svg>
					</span>
					Sign in
				</button>
			</div>
		</form>
	</div>
@endsection
