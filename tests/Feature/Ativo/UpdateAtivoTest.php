<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UpdateAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_para_atualizar_um_ativo(): void
    {
        $ativo = Ativo::factory()->create();

        $response = $this->put(route('ativo.update', $ativo->uid), []);

        $response->assertSessionHasErrors(['codigo', 'nome', 'classe_ativo_uid', 'setor'])
                ->assertStatus(302);
    }

    public function test_deve_retornar_ativo_nao_encontrado_404(): void
    {
        $ativoAtualizado = Ativo::factory()->make()->toArray();

        $response = $this->put(route('ativo.update', '123'), $ativoAtualizado);

        $response->assertJson(['menssage' => 'Ativo não encontrado'])
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

        $response = $this->put(route('ativo.update', $ativo->uid), $ativoAtualizada);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ativos', [
            'codigo' => $ativoAtualizada['codigo'],
            'nome' => $ativoAtualizada['nome'],
            'setor' => $ativoAtualizada['setor']
        ]);
    }

}
