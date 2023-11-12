<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteUserTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    public function test_deve_deletar_user(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('auth.delete', $user->uid));

        $response->assertStatus(200)
                 ->assertJson([
                    'message' => 'Usuário deletado com sucesso'
                 ]);

        $this->assertDatabaseMissing('users', [
            'uid' => $user->uid
        ]);
    }

    public function test_deve_esta_autenticado_para_atualizar_user(): void
    {
        $this->withMiddleware();
        $uidQualquer = '1b6efbcf-8de7-4876-a056-050622f24b01';

        $response = $this->delete(route('auth.delete', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
