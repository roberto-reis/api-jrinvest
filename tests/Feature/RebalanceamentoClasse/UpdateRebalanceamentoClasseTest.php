<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\User;

use App\Models\ClasseAtivo;
use App\Models\RebalanceamentoClasse;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_ao_atualizar_rebalanceamento_classe_ativo(): void
    {
        $uidQualquer = '123';

        $response = $this->put(route('rebalanceamento-classes.update', $uidQualquer), []);

        $response->assertStatus(302)
                ->assertSessionHasErrors([
                    'user_uid',
                    'classe_ativo_uid',
                    'percentual'
                ]);
    }

    public function test_deve_atualizar_rebalanceamento_por_classe_ativo(): void
    {
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create([
            'percentual' => 50
        ]);

        $rebalanceamentoClasse->percentual = 30.00;

        $response = $this->put(
            route('rebalanceamento-classes.update', $rebalanceamentoClasse->uid),
            $rebalanceamentoClasse->toArray()
        );

        $response->assertStatus(200)
            ->assertJson([
                "menssage" => "Dados Atualizados com sucesso"
            ]);

        $this->assertDatabaseHas('rebalanceamento_classes', [
            'uid' => $rebalanceamentoClasse->uid,
            'percentual' => $rebalanceamentoClasse->percentual
        ]);
    }

    public function test_deve_nao_atualizar_rebalanceamento_com_soma_a_percentuais_maior_que_100(): void
    {
        $user = User::factory()->create();
        RebalanceamentoClasse::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 80.00
        ]);

        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create([
            'user_uid' => $user->uid,
            'percentual' => 20.00
        ]);

        $rebalanceamentoClasse->percentual = 30.00;

        $response = $this->put(
            route('rebalanceamento-classes.update', $rebalanceamentoClasse->uid),
            $rebalanceamentoClasse->toArray()
        );

        $response->assertStatus(400)
            ->assertJson([
                "menssage" => "A soma dos percentuais não pode ser maior que 100.00%"
            ]);
    }

    public function test_deve_retornar_rebalanceamento_por_classe_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $rebalanceamentoClasse = RebalanceamentoClasse::factory()->create();

        $response = $this->delete(
            route('rebalanceamento-classes.delete',
            $uidQualquer),
            $rebalanceamentoClasse->toArray()
        );

        $response->assertJson(['menssage' => 'Rebalanceamento por classe não encontrado'])
                ->assertStatus(404);
    }
}
