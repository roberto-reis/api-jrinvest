<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\RebalanceamentoClasse;

use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAllRebalanceamentoClasseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_todos_os_rebalanceamento_por_classe_de_ativo(): void
    {
        $response = $this->get(route('rebalanceamento-classes.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_rebalanceamento_por_classe_com_filtro_perPage(): void
    {
        RebalanceamentoClasse::factory(3)->create();
        $perPage = 2;

        $response = $this->get(route('rebalanceamento-classes.listAll', ['perPage' => $perPage]));

        $response->assertStatus(200)
                ->assertJsonCount($perPage, 'data.data');

        assertEquals(data_get($response->json(), 'data.per_page'), $perPage);
    }
}
