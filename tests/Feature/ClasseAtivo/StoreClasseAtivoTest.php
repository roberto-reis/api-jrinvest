<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\ClasseAtivo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class StoreClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_nome_e_descricao_ao_cadastrar_classe_ativo(): void
    {
        $response = $this->post(route('classe-ativo.store'), []);

        $response->assertSessionHasErrors(['nome', 'descricao'])
                ->assertStatus(302);
    }

    public function test_deve_cadastrar_uma_classe_de_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->make();

        $response = $this->post(route('classe-ativo.store'), $classeAtivo->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('classes_ativos', [
            'nome' => $classeAtivo->nome
        ]);
    }

}
