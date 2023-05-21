<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *
     * @return void
     */
    public function test_deve_ser_obrigatorio_os_campos_ao_registrar_user(): void
    {
        $response = $this->post(route('auth.register'), []);

        $response->assertSessionHasErrors(['name', 'last_name', 'phone', 'email', 'password'])
                ->assertStatus(302);
    }

    public function test_deve_registrar_user(): void
    {
        $user = User::factory()->make()->toArray();

        $user['password'] = '12345678';
        $user['password_confirmation'] = '12345678';

        $response = $this->post(route('auth.register'), $user);

        $response->assertStatus(201)
                 ->assertJson([
                    'menssage' => 'Dados cadastrados com sucesso'
                 ]);

        $this->assertDatabaseHas('users', [
            'uid' => $response->json()['data']['user']['uid']
        ]);
    }

    public function test_deve_conseguir_logar_ao_registrar_user(): void
    {
        $user = User::factory()->make()->toArray();

        $user['password'] = '12345678';
        $user['password_confirmation'] = '12345678';

        $this->post(route('auth.register'), $user);

        $response = $this->post(route('auth.login'), $user);

        $response->assertStatus(200)
                 ->assertJson([
                    'menssage' => 'Dados retornados com sucesso'
                 ]);
    }
}
