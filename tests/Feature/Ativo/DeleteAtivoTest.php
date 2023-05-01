<?php

namespace Tests\Feature\Ativo;

use Tests\TestCase;
use App\Models\Ativo;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DeleteAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_retornar_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('ativo.delete', $uidQualquer));

        $response->assertJson(['menssage' => 'Ativo não encontrado'])
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

}
