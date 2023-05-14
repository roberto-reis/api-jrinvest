<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_rebalanceamento_classe_ativo(): void
    {
        $response = $this->post(route('rebalanceamento-classes.store', []));

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

        $response = $this->post(route('rebalanceamento-classes.store', $rebalanceamentoClasse->toArray()));

        $response->assertStatus(201)
            ->assertJson([
                "menssage" => "Dados cadastrados com sucesso"
            ]);

        $this->assertDatabaseHas('rebalanceamento_classes', [
            'uid' => $response->json()['data']['uid']
        ]);
    }

    public function test_deve_nao_cadastrar_rebalanceamento_com_soma_percentuais_maior_que_100(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create(['percentual' => 80.00]);
        $rebalanceamento = $rebalanceamentoClasse->toArray();

        $rebalanceamento['percentual'] = 30.00;

        $response = $this->post(route('rebalanceamento-classes.store', $rebalanceamento));

        $response->assertStatus(400)
            ->assertJson([
                "menssage" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }
}