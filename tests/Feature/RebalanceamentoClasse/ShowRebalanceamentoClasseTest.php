<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_listar_um_rebalanceamento_por_classe_ativo(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create();;

        $response = $this->get(route('rebalanceamento-classes.show', $rebalanceamentoClasse->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "uid",
                    "user_uid",
                    "classe_ativo_uid",
                    "percentual",
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
            ->assertJson([
                "menssage" => "Rebalanceamento por classe não encontrado"
            ]);
    }
}
