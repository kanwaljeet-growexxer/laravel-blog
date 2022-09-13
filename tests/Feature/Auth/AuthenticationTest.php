<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use stdClass;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected stdClass $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = (object) [
            'id' => rand(),
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'avatar' => 'https://en.gravatar.com/userimage',
        ];
    }

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_redirected_to_google_screen()
    {
        $response = $this->get('login/google');

        $response->assertStatus(302);
    }

    public function test_users_redirected_to_facebook_screen()
    {
        $response = $this->get('login/facebook');

        $response->assertStatus(302);
    }

    public function test_users_redirected_to_github_screen()
    {
        $response = $this->get('login/github');

        $response->assertStatus(302);
    }

    public function test_users_can_authenticate_using_the_google_login()
    {
        Socialite::shouldReceive('driver->user')->andReturn($this->user);
        $response = $this->get('/login/google/callback');

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_authenticate_using_the_facebook_login()
    {
        Socialite::shouldReceive('driver->user')->andReturn($this->user);
        $response = $this->get('/login/facebook/callback');

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_authenticate_using_the_github_login()
    {
        Socialite::shouldReceive('driver->user')->andReturn($this->user);
        $response = $this->get('/login/github/callback');

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
