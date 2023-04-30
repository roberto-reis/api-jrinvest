<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ListAllClasseAtivoTest extends TestCase
{
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
}
