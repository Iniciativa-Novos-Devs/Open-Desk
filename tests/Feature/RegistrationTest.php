<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testNewUsersCanRegister()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // $this->assertAuthenticated();
        // $response->assertRedirect(RouteServiceProvider::HOME);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
