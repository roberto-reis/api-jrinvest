<?php

namespace Tests\Feature\RebalanceamentoAtivo;

use Tests\TestCase;

use App\Models\RebalanceamentoAtivo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_listar_um_rebalanceamento_por_ativo(): void
    {
        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->create();;

        $response = $this->get(route('rebalanceamento-ativos.show', $rebalanceamentoAtivo->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "uid",
                    "user_uid",
                    "ativo_uid",
                    "percentual",
                    "user",
                    "ativo"
                  ]
            ]);
    }

    public function test_deve_nao_listar_um_rebalanceamento_por_ativo_404(): void
    {
        $uidQualquer = '123';

        $response = $this->get(route('rebalanceamento-ativos.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson([
                "message" => "Rebalanceamento por ativo não encontrado"
            ]);
    }

    public function test_deve_esta_autenticado_para_listar_rebalanceamento_por_ativo(): void
    {
        $this->withMiddleware();
        $uidQualquer = '123';

        $response = $this->get(route('rebalanceamento-ativos.show', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
