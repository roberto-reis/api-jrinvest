<?php

namespace Tests\Feature\ClasseAtivo;

use App\Models\Ativo;
use Tests\TestCase;
use App\Models\ClasseAtivo;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class DeleteClasseAtivoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_retornar_classe_ativo_nao_encontrado_404(): void
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

    public function test_deve_nao_deletar_uma_classe_ativo_em_uso_por_ativo(): void
    {
        $classeAtivo = ClasseAtivo::factory()->create();
        Ativo::factory()->create([
            'classe_ativo_uid' => $classeAtivo->uid
        ]);

        $response = $this->delete(route('classe-ativo.delete', $classeAtivo->uid));

        $response->assertJson(['menssage' => 'Não será possivel deletar, existe ativo ultilizando essa classe'])
                ->assertStatus(400);
    }
}
