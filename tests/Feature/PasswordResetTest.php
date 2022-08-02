<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }
}
