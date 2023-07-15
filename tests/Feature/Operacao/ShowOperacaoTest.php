<?php

namespace Tests\Feature\ClasseAtivo;

use App\Models\Operacao;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowOperacaoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_operacao_para_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $operacao = Operacao::factory()->create(['user_uid' => $user->uid]);

        $response = $this->get(route('operacoes.show', $operacao->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    'quantidade',
                    'cotacao_preco',
                    'data_operacao',
                    'valor_total',
                    'ativo' => [
                        'codigo',
                        'classe_ativo'
                    ],
                    'tipo_operacao',
                    'corretora'
                  ]
            ]);
    }

    public function test_deve_nao_listar_operacao_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get(route('operacoes.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Operação não encontrado']);
    }

    public function test_deve_esta_autenticado_para_listar_operacao(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->get(route('operacoes.show', [
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
