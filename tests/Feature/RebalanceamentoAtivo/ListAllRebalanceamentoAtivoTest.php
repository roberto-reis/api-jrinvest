<?php

namespace Tests\Feature\RebalanceamentoAtivo;

use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\RebalanceamentoAtivo;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ListAllRebalanceamentoAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_listar_todos_os_rebalanceamento_por_ativo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->get(route('rebalanceamento-ativos.listAll'));

        $response->assertStatus(200);
    }

    public function test_deve_listar_rebalanceamento_por_ativo_com_filtro_perPage(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        RebalanceamentoAtivo::factory(3)->create(['user_uid' => $user->uid]);
        $perPage = 2;

        $response = $this->get(route('rebalanceamento-ativos.listAll', [
            'withPaginate' => true,
            'perPage' => $perPage
        ]));

        $response->assertStatus(200)
                ->assertJsonCount($perPage, 'data.data');

        assertEquals(data_get($response->json(), 'data.per_page'), $perPage);
    }

    public function test_deve_esta_autenticado_para_todos_os_rebalanceamento_por_ativo(): void
    {
        $response = $this->get(route('rebalanceamento-ativos.listAll'), [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
