<?php

namespace Tests\Feature\Provento;

use Tests\TestCase;

use App\Models\User;
use App\Models\Provento;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateProventoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_para_atualizar_provento(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->put(route('proventos.update', $uidQualquer), []);

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

    public function test_deve_atualizar_provento_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $provento = Provento::factory()->create(['user_uid' => $user->uid]);

        $provento->data_com = '2023-06-10';
        $provento->quantidade_ativo = 50;
        $provento->valor = 1.50;

        $response = $this->put(route('proventos.update', $provento->uid), $provento->toArray());

        $response->assertStatus(200)
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

        $this->assertDatabaseHas('proventos', [
            'uid' => $provento->uid,
            'user_uid' => $provento->user_uid,
            'valor' => $provento->valor
        ]);
    }

    public function test_deve_nao_encontrar_provento_ao_atualizar_404(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $provento = Provento::factory()->make();

        $response = $this->put(route('proventos.update', $uidQualquer), $provento->toArray());

        $response->assertStatus(404)
            ->assertJson(['message' => 'Provento não encontrado']);
    }

    public function test_deve_esta_autenticado_para_atualizar_provento(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->put(route('proventos.update', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
