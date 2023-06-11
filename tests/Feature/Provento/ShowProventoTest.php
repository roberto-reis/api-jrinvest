<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;

use App\Models\User;
use App\Models\Provento;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowProventoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_provento_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $provento = Provento::factory()->create(['user_uid' => $user->uid]);

        $response = $this->get(route('proventos.show', $provento->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    'data_com',
                    'data_pagamento',
                    'quantidade_ativo',
                    'valor',
                    'yield_on_cost',
                    'ativo',
                    'tipo_provento',
                  ]
            ]);
    }

    public function test_deve_nao_listar_provento_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get(route('proventos.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Provento não encontrado']);
    }

    public function test_deve_esta_autenticado_para_listar_provento(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->get(route('proventos.show', [
            'uid' => $uidQualquer,
            'userUid' => $uidQualquer
        ]), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
