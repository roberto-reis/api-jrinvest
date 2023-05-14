<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;

use App\Models\Ativo;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_ativo(): void
    {
        $ativo = Ativo::factory()->create();

        $response = $this->get(route('ativo.show', $ativo->uid));

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

        $response = $this->get(route('ativo.show', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['menssage' => 'Ativo não encontrado']);
    }
}
