<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectToDashBoardTest extends TestCase
{
    /**
     * @test
     */
    public function verificaSeRedirecionaraParaODashBoard()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect(route('dashboard'));
    }
}
