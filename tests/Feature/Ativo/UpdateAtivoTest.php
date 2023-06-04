<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UpdateAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_para_atualizar_um_ativo(): void
    {
        $ativo = Ativo::factory()->create();

        $response = $this->put(route('ativos.update', $ativo->uid), []);

        $response->assertSessionHasErrors(['codigo', 'nome', 'classe_ativo_uid', 'setor'])
                ->assertStatus(302);
    }

    public function test_deve_retornar_ativo_nao_encontrado_404(): void
    {
        $ativoAtualizado = Ativo::factory()->make()->toArray();

        $response = $this->put(route('ativos.update', '123'), $ativoAtualizado);

        $response->assertJson(['message' => 'Ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_atualizar_um_ativo(): void
    {
        $ativo = Ativo::factory()->create();
        $ativoAtualizada = [
            'codigo' => 'MALL11',
            'nome' => 'Nova Nome',
            'classe_ativo_uid' => $ativo->classe_ativo_uid,
            'setor' => 'Novo setor'
        ];

        $response = $this->put(route('ativos.update', $ativo->uid), $ativoAtualizada);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ativos', [
            'codigo' => $ativoAtualizada['codigo'],
            'nome' => $ativoAtualizada['nome'],
            'setor' => $ativoAtualizada['setor']
        ]);
    }

    public function test_deve_esta_autenticado_para_atualizar_um_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->put(route('ativos.update', '123'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }

}
