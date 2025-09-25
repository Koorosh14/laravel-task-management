<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

	/**
	 * Tests user can register successfully.
	 *
	 * @return	void
	 */
	public function testUserCanRegister()
	{
		$userData = [
			'name'                  => 'Test User',
			'email'                 => 'test@example.com',
			'password'              => 'password123',
			'password_confirmation' => 'password123',
		];

		$response = $this->post(route('register'), $userData);

		$response->assertRedirect(route('dashboard.index'));
		$this->assertAuthenticated();
		$this->assertDatabaseHas('users', [
			'name'  => 'Test User',
			'email' => 'test@example.com',
		]);
	}

	/**
	 * Tests user can login with valid credentials.
	 *
	 * @return	void
	 */
	public function testUserCanLoginWithValidCredentials()
	{
		$user = User::factory()->create([
			'email'    => 'test@example.com',
			'password' => Hash::make('password123'),
		]);

		$response = $this->post(route('login'), [
			'email'    => 'test@example.com',
			'password' => 'password123',
		]);

		$response->assertRedirect(route('dashboard.index'));
		$this->assertAuthenticatedAs($user);
	}

	/**
	 * Tests user cannot login with invalid credentials.
	 *
	 * @return	void
	 */
	public function testUserCannotLoginWithInvalidCredentials()
	{
		$user = User::factory()->create([
			'email'    => 'test@example.com',
			'password' => Hash::make('password123'),
		]);

		$response = $this->post(route('login'), [
			'email'    => 'test@example.com',
			'password' => 'wrongpassword',
		]);

		$response->assertSessionHasErrors('email');
		$this->assertGuest();
	}

	/**
	 * Tests user can logout.
	 *
	 * @return	void
	 */
	public function testUserCanLogout()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

		$response = $this->post(route('logout'));

		$response->assertRedirect(route('tasks.index'));
		$this->assertGuest();
	}

	/**
	 * Tests authenticated user is redirected from login page.
	 *
	 * @return	void
	 */
	public function testAuthenticatedUserIsRedirectedFromLoginPage()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

		$response = $this->get(route('login'));
		$response->assertRedirect(route('dashboard.index'));
	}

	/**
	 * Tests authenticated user is redirected from register page.
	 *
	 * @return	void
	 */
	public function testAuthenticatedUserIsRedirectedFromRegisterPage()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

		$response = $this->get(route('register'));
		$response->assertRedirect(route('dashboard.index'));
	}

	/**
	 * Tests registration validation rules.
	 *
	 * @return	void
	 */
	public function testRegistrationValidationRules()
	{
		// Test required fields
		$response = $this->post(route('register'), []);
		$response->assertSessionHasErrors(['name', 'email', 'password']);

		// Test email format
		$response = $this->post(route('register'), [
			'name'                  => 'Test User',
			'email'                 => 'invalid-email',
			'password'              => 'password123',
			'password_confirmation' => 'password123',
		]);
		$response->assertSessionHasErrors('email');

		// Test password confirmation
		$response = $this->post(route('register'), [
			'name'                  => 'Test User',
			'email'                 => 'test@example.com',
			'password'              => 'password123',
			'password_confirmation' => 'different-password',
		]);
		$response->assertSessionHasErrors('password');

		// Test unique email
		User::factory()->create(['email' => 'test@example.com']);
		$response = $this->post(route('register'), [
			'name'                  => 'Test User',
			'email'                 => 'test@example.com',
			'password'              => 'password123',
			'password_confirmation' => 'password123',
		]);
		$response->assertSessionHasErrors('email');
	}

	/**
	 * Tests remember me functionality.
	 *
	 * @return	void
	 */
	public function testRememberMeFunctionality()
	{
		$user = User::factory()->create([
			'email'    => 'test@example.com',
			'password' => Hash::make('password123'),
		]);

		$response = $this->post(route('login'), [
			'email'    => 'test@example.com',
			'password' => 'password123',
			'remember' => '1',
		]);

		$response->assertRedirect(route('dashboard.index'));
		$this->assertAuthenticatedAs($user);
	}
}
