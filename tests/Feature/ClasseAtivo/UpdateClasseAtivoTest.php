<?php

namespace Tests\Feature\ClasseAtivo;

use App\Models\ClasseAtivo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class UpdateClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_nome_e_descricao_p(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();

        $response = $this->put(route('classe-ativo.update', $classeAtivo->uid), []);

        $response->assertSessionHasErrors(['nome', 'descricao'])
                ->assertStatus(302);
    }

    public function test_retornar_classe_ativo_nao_encontrado_404(): void
    {
        $classeAtualizada = [
            'nome' => 'Novo Nome',
            'descricao' => 'Nova Descrição'
        ];

        $response = $this->put(route('classe-ativo.update', '123'), $classeAtualizada);

        $response->assertJson(['menssage' => 'Classe de ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_cadastrar_uma_classe_de_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();
        $classeAtualizada = [
            'nome' => 'Novo Nome',
            'descricao' => 'Nova Descrição'
        ];

        $response = $this->put(route('classe-ativo.update', $classeAtivo->uid), $classeAtualizada);

        $response->assertStatus(200);
        $this->assertDatabaseHas('classes_ativos', [
            'nome' => $classeAtualizada['nome'],
            'descricao' => $classeAtualizada['descricao']
        ]);
    }

}
