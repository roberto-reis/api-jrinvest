<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateUserTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function test_deve_ser_obrigatorio_os_campos_ao_atualizar_user(): void
    {
        $uidQualquer = '1b6efbcf-8de7-4876-a056-050622f24b01';
        $response = $this->put(route('auth.update', $uidQualquer), []);

        $response->assertSessionHasErrors(['name', 'last_name', 'email'])
                ->assertStatus(302);
    }

    public function test_deve_atualizar_user(): void
    {
        $user = User::factory()->create();

        $user->name = "José";
        $user->last_name = "Roberto";
        $user->password = "Roberto";

        $response = $this->put(route('auth.update', $user->uid), $user->toArray());

        $response->assertStatus(200)
                 ->assertJson([
                    'message' => 'Dados atualizado com sucesso'
                 ]);

        $this->assertDatabaseHas('users', [
            'uid' => $user->uid,
            'name' => $user->name,
            'last_name' => $user->last_name
        ]);
    }

    public function test_deve_esta_autenticado_para_atualizar_user(): void
    {
        $this->withMiddleware();
        $uidQualquer = '1b6efbcf-8de7-4876-a056-050622f24b01';

        $response = $this->put(route('auth.update', $uidQualquer), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                    'message' => 'Unauthenticated.'
                 ]);
    }
}
