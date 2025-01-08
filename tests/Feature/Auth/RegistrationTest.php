<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_new_users_can_register(): void
    {

        $this->withoutExceptionHandling();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@ex.com',
            'password' => 'strongpassword',
            'password_confirmation' => 'strongpassword',
        ]);

        $this->assertAuthenticated();

        $response
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect('/');
    }
}
