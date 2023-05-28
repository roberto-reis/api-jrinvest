<?php

namespace Tests\Feature\RebalanceamentoAtivo;

use Tests\TestCase;
use App\Models\User;

use App\Models\RebalanceamentoAtivo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_ao_atualizar_rebalanceamento_por_ativo(): void
    {
        $uidQualquer = '123';

        $response = $this->put(route('rebalanceamento-ativos.update', $uidQualquer), []);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'user_uid',
                    'ativo_uid',
                    'percentual'
                ]);
    }

    public function test_deve_atualizar_rebalanceamento_por_ativo(): void
    {
        $user = User::factory()->create();
        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 50
        ]);

        $rebalanceamentoAtivo->percentual = 30.00;

        $response = $this->put(
            route('rebalanceamento-ativos.update', $rebalanceamentoAtivo->uid),
            $rebalanceamentoAtivo->toArray()
        );

        $response->assertStatus(200)
            ->assertJson([
                "message" => "Dados Atualizados com sucesso"
            ]);

        $this->assertDatabaseHas('rebalanceamento_ativos', [
            'uid' => $rebalanceamentoAtivo->uid,
            'percentual' => $rebalanceamentoAtivo->percentual
        ]);
    }

    public function test_deve_nao_atualizar_rebalanceamento_com_soma_a_percentuais_maior_que_100(): void
    {
        $user = User::factory()->create();
        RebalanceamentoAtivo::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 80.00
        ]);

        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 20.00
        ]);

        $rebalanceamentoAtivo->percentual = 30.00;

        $response = $this->put(
            route('rebalanceamento-ativos.update', $rebalanceamentoAtivo->uid),
            $rebalanceamentoAtivo->toArray()
        );

        $response->assertStatus(400)
            ->assertJson([
                "message" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }

    public function test_deve_retornar_rebalanceamento_por_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $rebalanceamentoAtivo = RebalanceamentoAtivo::factory()->create();

        $response = $this->put(
            route('rebalanceamento-ativos.update',
            $uidQualquer),
            $rebalanceamentoAtivo->toArray()
        );

        $response->assertJson(['message' => 'Rebalanceamento por ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_esta_autenticado_para_atualizar_rebalanceamento_por_classe_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->put(route('rebalanceamento-ativos.update', '123'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
