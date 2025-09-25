<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to redirect authenticated users away from guest-only pages (e.g. login or register).
 */
class RedirectIfAuthenticated
{
	/**
	 * Handles an incoming request
	 *
	 * @param	Request		$request	The incoming HTTP request.
	 * @param	Closure		$next		The next middleware/controller.
	 * @param	string|null	...$guards	Optional guards to check.
	 *
	 * @return	Response				The HTTP response.
	 */
	public function handle(Request $request, Closure $next, string ...$guards): Response
	{
		$guards = empty($guards) ? [null] : $guards;

		foreach ($guards as $guard)
			if (Auth::guard($guard)->check())
				return redirect()->route('dashboard');

		return $next($request);
	}
}
