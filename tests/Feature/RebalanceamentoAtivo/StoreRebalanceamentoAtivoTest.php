<?php

namespace Tests\Feature\RebalanceamentoClasse;

use Tests\TestCase;

use App\Models\RebalanceamentoAtivo;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_rebalanceamento_ativo(): void
    {
        $response = $this->post(route('rebalanceamento-ativos.store'), []);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'user_uid',
                    'ativo_uid',
                    'percentual'
                ]);
    }

    public function test_deve_cadastrar_rebalanceamento_por_ativo(): void
    {
        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->make();

        $response = $this->post(route('rebalanceamento-ativos.store'), $rebalanceamentoAtivo->toArray());

        $response->assertStatus(201)
            ->assertJson([
                "message" => "Dados cadastrados com sucesso"
            ]);

        $this->assertDatabaseHas('rebalanceamento_ativos', [
            'uid' => $response->json()['data']['uid']
        ]);
    }

    public function test_deve_nao_cadastrar_rebalanceamento_com_soma_percentuais_maior_que_100(): void
    {
        $user = User::factory()->create();
        RebalanceamentoAtivo::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 80.00
        ]);
        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->make([
            'user_uid' => $user->uid,
            'percentual' => 30.00
        ]);

        $response = $this->post(route('rebalanceamento-ativos.store'), $rebalanceamentoAtivo->toArray());

        $response->assertStatus(400)
            ->assertJson([
                "message" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_rebalanceamento_por_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->post(route('rebalanceamento-ativos.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
