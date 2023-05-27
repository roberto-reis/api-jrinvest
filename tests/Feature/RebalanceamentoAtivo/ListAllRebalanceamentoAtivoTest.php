<?php

namespace Tests\Feature\RebalanceamentoAtivo;

use Tests\TestCase;

use App\Models\RebalanceamentoAtivo;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAllRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_deve_listar_todos_os_rebalanceamento_por_ativo(): void
    {
        $response = $this->get(route('rebalanceamento-ativos.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_rebalanceamento_por_ativo_com_filtro_perPage(): void
    {
        RebalanceamentoAtivo::factory(3)->create();
        $perPage = 2;

        $response = $this->get(route('rebalanceamento-ativos.listAll', ['perPage' => $perPage]));

        $response->assertStatus(200)
                ->assertJsonCount($perPage, 'data.data');

        assertEquals(data_get($response->json(), 'data.per_page'), $perPage);
    }

    public function test_deve_esta_autenticado_para_todos_os_rebalanceamento_por_ativo(): void
    {
        $this->withMiddleware();

        $response = $this->get(route('rebalanceamento-ativos.listAll'), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
