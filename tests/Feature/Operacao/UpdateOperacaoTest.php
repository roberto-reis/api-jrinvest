<?php

namespace Tests\Feature\Operacao;

use App\Models\Operacao;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateOperacaoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_para_atualizar_operacao(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->put(route('operacoes.update', $uidQualquer), []);

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

    public function test_deve_atualizar_operacao_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $operacao = Operacao::factory()->create(['user_uid' => $user->uid]);

        $operacao->data_operacao = '2023-06-10';
        $operacao->quantidade = 50;
        $operacao->cotacao_preco = 1.50;

        $response = $this->put(route('operacoes.update', $operacao->uid), $operacao->toArray());

        $response->assertStatus(200)
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
            'uid' => $operacao->uid,
            'user_uid' => $operacao->user_uid,
            'quantidade' => $operacao->quantidade
        ]);
    }

    public function test_deve_nao_encontrar_operacao_ao_atualizar_404(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $operacao = Operacao::factory()->make();

        $response = $this->put(route('operacoes.update', $uidQualquer), $operacao->toArray());

        $response->assertStatus(404)
            ->assertJson(['message' => 'Operação não encontrado']);
    }

    public function test_deve_esta_autenticado_para_atualizar_operacao(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->put(route('operacoes.update', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
