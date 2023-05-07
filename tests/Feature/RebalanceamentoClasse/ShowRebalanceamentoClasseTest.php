<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\RebalanceamentoClasse;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_um_rebalanceamento_por_classe_ativo(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create();;

        $response = $this->get(route('rebalanceamento-classes.show', $rebalanceamentoClasse->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "uid",
                    "user_id",
                    "classe_ativo_uid",
                    "percentual",
                    "created_at",
                    "updated_at",
                    "user",
                    "classe_ativo"
                  ]
            ]);
    }

    public function test_deve_nao_listar_um_rebalanceamento_por_classe_ativo_404(): void
    {
        $uidQualquer = '123';

        $response = $this->get(route('rebalanceamento-classes.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertSeeText('Rebalanceamento por classe n\u00e3o encontrado');
    }
}
