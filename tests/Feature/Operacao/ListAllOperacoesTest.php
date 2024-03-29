<?php

namespace Tests\Feature\Operacao;

use Tests\TestCase;
use App\Models\User;

use App\Models\Operacao;
use Laravel\Sanctum\Sanctum;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAllOperacoesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_todas_operacoes_de_um_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Operacao::factory(5)->create(['user_uid' => $user->uid]);

        $response = $this->get(route('operacoes.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_operacoes_com_filtro_paginate(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        Operacao::factory(5)->create(['user_uid' => $user->uid]);
        $perPage = 2;

        $response = $this->get(route('operacoes.listAll', [
            'perPage' => $perPage
        ]));

        $response->assertStatus(200);
        assertEquals($response->json()['data']['per_page'], $perPage);
    }

    public function test_deve_esta_autenticado_para_listar_todos_operacoes_de_um_usuario(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->get(route('operacoes.listAll', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
