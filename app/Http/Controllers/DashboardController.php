<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
	/**
	 * Creates a new controller instance and applies auth middleware to all methods.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Displays the dashboard.
	 *
	 * @return	\Illuminate\View\View
	 */
	public function index()
	{
		return view('dashboard.index');
	}
}
