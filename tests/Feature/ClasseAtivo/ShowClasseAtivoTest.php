<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\ClasseAtivo;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;

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
            ->assertSeeText('Classe de ativo n\u00e3o encontrado');
    }
}
