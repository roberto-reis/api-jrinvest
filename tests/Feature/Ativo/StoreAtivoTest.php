<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class StoreAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_ser_obrigatorio_os_campos_ao_cadastrar_um_ativo(): void
    {
        $response = $this->post(route('ativos.store'), []);

        $response->assertSessionHasErrors(['codigo', 'nome', 'classe_ativo_uid', 'setor'])
                ->assertStatus(302);
    }

    public function test_deve_cadastrar_ativo(): void
    {
        $ativo = Ativo::factory()->make();

        $response = $this->post(route('ativos.store'), $ativo->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('ativos', [
            'codigo' => $ativo->codigo
        ]);
    }

    public function test_deve_esta_autenticado_para_cadastrar_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->post(route('ativos.store'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
