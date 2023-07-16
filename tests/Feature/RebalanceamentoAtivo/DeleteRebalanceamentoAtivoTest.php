<?php

namespace Tests\Feature\RebalanceamentoAtivo;

use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\RebalanceamentoAtivo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_retornar_rebalanceamento_por_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->delete(route('rebalanceamento-ativos.delete', $uidQualquer));

        $response->assertJson(['message' => 'Rebalanceamento por ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_deletar_um_rebalanceamento_por_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $rebalanceamento = RebalanceamentoAtivo::factory()->create(['user_uid' => $user->uid]);

        $response = $this->delete(route('rebalanceamento-ativos.delete', $rebalanceamento->uid));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rebalanceamento_ativos', [
            'uid' => $rebalanceamento->uid
        ]);
    }

    public function test_deve_esta_autenticado_ao_deletar_um_rebalanceamento_por_ativo(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('rebalanceamento-ativos.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }

}
