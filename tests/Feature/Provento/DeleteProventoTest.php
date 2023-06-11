<?php

namespace Tests\Feature\Provento;

use Tests\TestCase;

use App\Models\User;
use App\Models\Provento;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteProventoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_deve_deletar_provento_do_usuario(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $provento = Provento::factory()->create(['user_uid' => $user->uid]);

        $response = $this->delete(route('proventos.delete', $provento->uid));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('proventos', [
            'uid' => $provento->uid,
            'user_uid' => $provento->user_uid
        ]);
    }

    public function test_deve_nao_encontrar_provento_ao_deletar_404(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';

        $response = $this->delete(route('proventos.delete', $uidQualquer));

        $response->assertStatus(404)
            ->assertJson(['message' => 'Provento não encontrado']);
    }

    public function test_deve_esta_autenticado_para_deletar_provento(): void
    {
        $uidQualquer = '32c0e209-cff9-4cc3-af17-71cb6a48d01a';
        $response = $this->delete(route('proventos.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
