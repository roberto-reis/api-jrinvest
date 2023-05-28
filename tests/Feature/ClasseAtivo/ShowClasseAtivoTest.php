<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;

use App\Models\ClasseAtivo;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_listar_classe_de_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();

        $response = $this->get(route('classe-ativo.show', $classeAtivo->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "uid",
                    "nome",
                    "nome_interno",
                    "descricao"
                  ]
            ]);
    }

    public function test_deve_nao_listar_classe_de_ativo_404(): void
    {
        $uidQualquer = '123';

        $response = $this->get(route('classe-ativo.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Classe de ativo não encontrado']);
    }

    public function test_deve_esta_autenticado_para_listar_classe_de_ativo(): void
    {
        $this->withMiddleware();
        $uidQualquer = '123';

        $response = $this->get(route('classe-ativo.show', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
