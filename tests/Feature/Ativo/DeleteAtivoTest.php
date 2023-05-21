<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteAtivoTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function test_retornar_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('ativo.delete', $uidQualquer));

        $response->assertJson(['message' => 'Ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_deletar_um_ativo(): void
    {
        $ativo = Ativo::factory()->create();

        $response = $this->delete(route('ativo.delete', $ativo->uid));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('ativos', [
            'uid' => $ativo->uid
        ]);
    }

    public function test_deve_esta_autenticado_rota_ao_deletar_ativo(): void
    {
        $this->withMiddleware();
        $uidQualquer = '123';

        $response = $this->delete(route('ativo.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
