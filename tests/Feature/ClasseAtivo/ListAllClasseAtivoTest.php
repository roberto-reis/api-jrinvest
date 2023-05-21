<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ListAllClasseAtivoTest extends TestCase
{
    use WithoutMiddleware;

    public function test_deve_listar_todos_as_classes_de_ativos(): void
    {
        $response = $this->get(route('classe-ativo.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_classe_ativo_com_filtro_perPage(): void
    {
        $perPage = 2;

        $response = $this->get(route('classe-ativo.listAll', ['perPage' => $perPage]));

        $response->assertStatus(200);
        assertEquals($response->json()['data']['per_page'], $perPage);
    }

    public function test_deve_esta_autenticado_para_listar_todos_as_classes_de_ativos(): void
    {
        $this->withMiddleware();

        $response = $this->get(route('classe-ativo.listAll'), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
