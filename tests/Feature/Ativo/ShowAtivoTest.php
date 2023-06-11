<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\Ativo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_listar_ativo(): void
    {
        $ativo = Ativo::factory()->create();

        $response = $this->get(route('ativos.show', $ativo->uid));

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "uid",
                    "codigo",
                    "classe_ativo_uid",
                    "nome",
                    "setor"
                  ]
            ]);
    }

    public function test_deve_nao_listar_ativo_404(): void
    {
        $uidQualquer = '123';

        $response = $this->get(route('ativos.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Ativo não encontrado']);
    }

    public function test_deve_esta_autenticado_para_listar_ativo(): void
    {
        $this->withMiddleware();
        $uidQualquer = '123';

        $response = $this->get(route('ativos.show', $uidQualquer), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
