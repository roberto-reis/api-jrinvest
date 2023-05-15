<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ListAllAtivoTest extends TestCase
{
    use WithoutMiddleware;

    public function test_deve_listar_todos_os_ativos(): void
    {
        $response = $this->get(route('ativo.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_ativos_com_filtro_perPage(): void
    {
        $perPage = 2;

        $response = $this->get(route('ativo.listAll', ['perPage' => $perPage]));

        $response->assertJson([
            'data' => [
                'per_page' => $perPage
            ]
        ])->assertStatus(200);
    }
}
