<?php

namespace Tests\Feature\ClasseAtivo;

use Tests\TestCase;
use App\Models\ClasseAtivo;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DeleteClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_retornar_classe_ativo_nao_encontrado_404(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('classe-ativo.delete', $uidQualquer));

        $response->assertJson(['menssage' => 'Classe de ativo não encontrado'])
                ->assertStatus(404);
    }

    public function test_deve_deletar_uma_classe_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();

        $response = $this->delete(route('classe-ativo.delete', $classeAtivo->uid));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('classes_ativos', [
            'uid' => $classeAtivo->uid
        ]);
    }
}
