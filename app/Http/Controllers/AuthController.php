<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
	/**
	 * Displays the login form
	 *
	 * @return	\Illuminate\View\View
	 */
	public function showLoginForm()
	{
		// Redirect to tasks index if already authenticated
		if (Auth::check())
			return redirect()->route('tasks.index');

		return view('auth.login');
	}

	/**
	 * Handles user login authentication
	 *
	 * @param	Request		$request
	 *
	 * @return	\Illuminate\Http\RedirectResponse
	 * @throws	\Illuminate\Validation\ValidationException	When authentication fails.
	 */
	public function login(Request $request)
	{
		// Validate the login form data
		$credentials = $request->validate([
			'email'    => ['required', 'email'],
			'password' => ['required'],
		]);

		// Attempt to authenticate the user
		if (Auth::attempt($credentials, $request->filled('remember')))
		{
			// Regenerate session to prevent fixation attacks
			$request->session()->regenerate();

			return redirect()->intended('tasks.index');
		}

		// Authentication failed
		throw ValidationException::withMessages([
			'email' => __('The provided credentials do not match our records.'),
		]);
	}

	/**
	 * Displays the registration form.
	 *
	 * @return	\Illuminate\View\View
	 */
	public function showRegisterForm()
	{
		// Redirect to tasks index if already authenticated
		if (Auth::check())
			return redirect()->route('tasks.index');

		return view('auth.register');
	}

	/**
	 * Handles user registration.
	 *
	 * @param	Request		$request
	 *
	 * @return	\Illuminate\Http\RedirectResponse
	 */
	public function register(Request $request)
	{
		// Validate the registration form data
		$validatedData = $request->validate([
			'name'     => ['required', 'string', 'max:255'],
			'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);

		// Create the new user
		$user = User::create([
			'name'     => $validatedData['name'],
			'email'    => $validatedData['email'],
			'password' => Hash::make($validatedData['password']),
		]);

		// Log the user in automatically after registration
		Auth::login($user);

		// Regenerate session
		$request->session()->regenerate();

		return redirect()->route('tasks.index');
	}

	/**
	 * Handles user logout.
	 *
	 * @param	Request		$request
	 *
	 * @return	\Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request)
	{
		// Log the user out
		Auth::logout();

		// Invalidate the session
		$request->session()->invalidate();

		// Regenerate CSRF token
		$request->session()->regenerateToken();

		return redirect()->route('tasks.index');
	}
}
