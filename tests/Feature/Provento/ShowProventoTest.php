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
    use WithoutMiddleware;

    public function test_deve_listar_provento_para_usuario(): void
    {
        $this->withMiddleware();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $provento = Provento::factory()->create(['user_uid' => $user->uid]);

        $response = $this->get(route('proventos.show', [
            'uid' => $provento->uid,
            'userUid' => $user->uid
        ]));

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
        $uidQualquer = '123';
        $this->withMiddleware();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get(route('proventos.show', [
            'uid' => $uidQualquer,
            'userUid' => $user->uid
        ]));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Provento não encontrado']);
    }

    public function test_deve_esta_autenticado_para_listar_provento(): void
    {
        $this->withMiddleware();
        $uidQualquer = '123';

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
