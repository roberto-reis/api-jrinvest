<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\ClasseAtivo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UpdateClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_nome_e_descricao_ao_atualizar_classe_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();

        $response = $this->put(route('classe-ativo.update', $classeAtivo->uid), []);

        $response->assertSessionHasErrors(['nome', 'descricao'])
                ->assertStatus(302);
    }

    public function test_deve_retornar_classe_ativo_nao_encontrado_404(): void
    {
        $classeAtualizada = [
            'nome' => 'Novo Nome',
            'descricao' => 'Nova Descrição'
        ];

        $response = $this->put(route('classe-ativo.update', '123'), $classeAtualizada);

        $response->assertJson(['message' => 'Classe de ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_esta_autenticado_para_atualizar_um_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->put(route('classe-ativo.update', '123'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }

}
