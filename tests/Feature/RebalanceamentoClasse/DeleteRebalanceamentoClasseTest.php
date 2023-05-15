<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_retornar_rebalanceamento_por_classe_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('rebalanceamento-classes.delete', $uidQualquer));

        $response->assertJson(['menssage' => 'Rebalanceamento por classe não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_deletar_um_rebalanceamento_classe_ativo(): void
    {
        $rebalanceamento = RebalanceamentoClasse::factory()->create();

        $response = $this->delete(route('rebalanceamento-classes.delete', $rebalanceamento->uid));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rebalanceamento_classes', [
            'uid' => $rebalanceamento->uid
        ]);
    }

}
