<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function testResetPasswordLinkScreenCanBeRendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function testResetPasswordLinkCanBeRequested()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function testResetPasswordScreenCanBeRendered()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }

    public function testPasswordCanBeResetWithValidToken()
    {
        Notification::fake();

        $user = Usuario::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertStatus(302); //Recurso desabilitado por segurança
        $response->assertRedirect(route('login'));
    }
}
