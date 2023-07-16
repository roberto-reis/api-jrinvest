<?php

namespace Tests\Feature\Provento;

use App\Models\Operacao;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteOperacaoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_deletar_operacao_do_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $operacao = Operacao::factory()->create(['user_uid' => $user->uid]);

        $response = $this->delete(route('operacoes.delete', $operacao->uid));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('operacoes', [
            'uid' => $operacao->uid,
            'user_uid' => $operacao->user_uid
        ]);
    }

    public function test_deve_nao_encontrar_operacao_ao_deletar_404(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('operacoes.delete', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Operação não encontrado']);
    }

    public function test_deve_esta_autenticado_para_deletar_operacao(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->delete(route('operacoes.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
