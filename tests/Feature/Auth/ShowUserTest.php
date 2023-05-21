<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     */
    public function test_deve_esta_logado_para_listar_user(): void
    {
        $response = $this->get(route('auth.user'), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }

    /**
     *
     */
    public function test_deve_listar_user_logado(): void
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->get(route('auth.user'), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'message',
                    'data' => [
                        'uid',
                        'name',
                        'last_name',
                        'email',
                        'phone'
                    ]
                 ]);
    }
}
