<?php

namespace Tests\Feature\RebalanceamentoClasse;

use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_um_rebalanceamento_por_classe_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create(['user_uid' => $user->uid]);

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
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->get(route('rebalanceamento-classes.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson([
                "message" => "Rebalanceamento por classe não encontrado"
            ]);
    }

    public function test_deve_esta_autenticado_para_listar_rebalanceamento_por_classe_ativo(): void
    {
        $uidQualquer = '123';

        $response = $this->get(route('rebalanceamento-classes.show', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
