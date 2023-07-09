<?php

namespace Tests\Feature\RebalanceamentoClasse;

use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_retornar_rebalanceamento_por_classe_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->delete(route('rebalanceamento-classes.delete', $uidQualquer));

        $response->assertJson(['message' => 'Rebalanceamento por classe não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_deletar_um_rebalanceamento_classe_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $rebalanceamento = RebalanceamentoClasse::factory()->create(['user_uid' => $user->uid]);

        $response = $this->delete(route('rebalanceamento-classes.delete', $rebalanceamento->uid));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rebalanceamento_classes', [
            'uid' => $rebalanceamento->uid
        ]);
    }

    public function test_deve_esta_autenticado_ao_deletar_um_rebalanceamento_classe_ativo(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('rebalanceamento-classes.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }

}
