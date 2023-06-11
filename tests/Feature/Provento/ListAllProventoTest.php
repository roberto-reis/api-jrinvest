<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\User;
use App\Models\Provento;

use Laravel\Sanctum\Sanctum;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAllProventoTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function test_deve_listar_todos_proventos_de_um_usuario(): void
    {
        $this->withMiddleware();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Provento::factory(5)->create(['user_uid' => $user->uid]);

        $response = $this->get(route('proventos.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_proventos_com_filtro_paginate(): void
    {
        $this->withMiddleware();
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Provento::factory(5)->create(['user_uid' => $user->uid]);
        $perPage = 2;

        $response = $this->get(route('proventos.listAll', [
            'perPage' => $perPage
        ]));

        $response->assertStatus(200);
        assertEquals($response->json()['data']['per_page'], $perPage);
    }

    public function test_deve_esta_autenticado_para_listar_todos_proventos_de_um_usuario(): void
    {
        $this->withMiddleware();
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->get(route('proventos.listAll', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
