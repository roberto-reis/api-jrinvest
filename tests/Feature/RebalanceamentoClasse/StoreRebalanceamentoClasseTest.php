<?php

namespace Tests\Feature\RebalanceamentoClasse;

use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_rebalanceamento_classe_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->post(route('rebalanceamento-classes.store'), []);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'classe_ativo_uid',
                    'percentual'
                ]);
    }

    public function test_deve_cadastrar_rebalanceamento_por_classe_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
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
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        RebalanceamentoClasse::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 80.00
        ]);
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->make([
            'user_uid' => $user->uid,
            'percentual' => 30.00
        ]);

        $response = $this->post(route('rebalanceamento-classes.store'), $rebalanceamentoClasse->toArray());

        $response->assertStatus(400)
            ->assertJson([
                "message" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_rebalanceamento_por_classe_ativo(): void
    {
        $response = $this->post(route('rebalanceamento-classes.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
