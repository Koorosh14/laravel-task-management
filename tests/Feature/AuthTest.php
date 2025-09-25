<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test class for authentication functionality (login, registration, and logout features).
 */
class AuthTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * Tests that login page is accessible.
	 *
	 * @return	void
	 */
	public function testLoginPageIsAccessible()
	{
		$response = $this->get(route('login'));
		$response->assertStatus(200);
		$response->assertViewIs('auth.login');
	}

	/**
	 * Tests that register page is accessible.
	 *
	 * @return	void
	 */
	public function testRegisterPageIsAccessible()
	{
		$response = $this->get(route('register'));
		$response->assertStatus(200);
		$response->assertViewIs('auth.register');
	}
}
