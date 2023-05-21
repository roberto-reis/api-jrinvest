<?php

namespace Tests\Feature\RebalanceamentoClasse;

use Tests\TestCase;

use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_rebalanceamento_classe_ativo(): void
    {
        $response = $this->post(route('rebalanceamento-classes.store'), []);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'user_uid',
                    'classe_ativo_uid',
                    'percentual'
                ]);
    }

    public function test_deve_cadastrar_rebalanceamento_por_classe_ativo(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->make();

        $response = $this->post(route('rebalanceamento-classes.store'), $rebalanceamentoClasse->toArray());

        $response->assertStatus(201)
            ->assertJson([
                "message" => "Dados cadastrados com sucesso"
            ]);

        $this->assertDatabaseHas('rebalanceamento_classes', [
            'uid' => $response->json()['data']['uid']
        ]);
    }

    public function test_deve_nao_cadastrar_rebalanceamento_com_soma_percentuais_maior_que_100(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create(['percentual' => 80.00]);

        $rebalanceamentoClasse->percentual = 30.00;

        $response = $this->post(route('rebalanceamento-classes.store'), $rebalanceamentoClasse->toArray());

        $response->assertStatus(400)
            ->assertJson([
                "message" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_rebalanceamento_por_classe_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->post(route('rebalanceamento-classes.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
