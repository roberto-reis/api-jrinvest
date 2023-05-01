<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class StoreAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_um_ativo(): void
    {
        $response = $this->post(route('ativo.store'), []);

        $response->assertSessionHasErrors(['codigo', 'nome', 'classe_ativo_uid', 'setor'])
                ->assertStatus(302);
    }

    public function test_deve_cadastrar_ativo(): void
    {
        $ativo = Ativo::factory()->make();

        $response = $this->post(route('ativo.store'), $ativo->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('ativos', [
            'codigo' => $ativo->codigo
        ]);
    }

}
