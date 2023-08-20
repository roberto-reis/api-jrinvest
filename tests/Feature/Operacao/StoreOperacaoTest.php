<?php

namespace Tests\Feature\Operacao;

use App\Models\Ativo;
use App\Models\Operacao;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreOperacaoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_para_cadastrar_operacao(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->post(route('operacoes.store'), []);

        $response->assertSessionHasErrors([
                'ativo_uid',
                'tipo_operacao_uid',
                'corretora_uid',
                'cotacao_preco',
                'quantidade',
                'data_operacao'
            ])
            ->assertStatus(302);
    }

    public function test_deve_cadastrar_operacao_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $ativo = Ativo::factory()->create();
        $operacao = Operacao::factory()->compra()->create([
            'ativo_uid' => $ativo->uid,
            'quantidade' => 50
        ]);

        $response = $this->post(route('operacoes.store', $operacao->toArray()));

        $response->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'uid',
                    'user_uid',
                    'ativo_uid',
                    'tipo_operacao_uid',
                    'corretora_uid',
                    'cotacao_preco',
                    'quantidade',
                    'data_operacao',
                    'valor_total'
                  ]
            ]);

        $this->assertDatabaseHas('operacoes', [
            'uid' => $response->json()['data']['uid'],
            'user_uid' => $response->json()['data']['user_uid']
        ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_operacao(): void
    {
        $response = $this->post(route('operacoes.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
