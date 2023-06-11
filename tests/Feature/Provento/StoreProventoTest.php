<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;

use App\Models\User;
use App\Models\Provento;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreProventoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_para_cadastrar_provento(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->post(route('proventos.store'), []);

        $response->assertSessionHasErrors([
            'ativo_uid',
            'tipo_provento_uid',
            'corretora_uid',
            'data_pagamento',
            'quantidade_ativo',
            'valor'
            ])
            ->assertStatus(302);
    }

    public function test_deve_cadastrar_provento_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $provento = Provento::factory()->make();

        $response = $this->post(route('proventos.store', $provento->toArray()));

        $response->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'user_uid',
                    'ativo_uid',
                    'tipo_provento_uid',
                    'data_com',
                    'data_pagamento',
                    'quantidade_ativo',
                    'valor',
                    'yield_on_cost'
                  ]
            ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_provento(): void
    {
        $response = $this->post(route('proventos.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
