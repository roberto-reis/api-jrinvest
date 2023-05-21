<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_deve_ser_obrigatorio_os_campos_logar_user(): void
    {
        $response = $this->post(route('auth.login'), []);

        $response->assertStatus(302)
                 ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_deve_nao_logar_user_email_ou_senha_invalidos(): void
    {
        $user = User::factory()->create()->toArray();
        $passworQualquer = '1234567899';

        $user['password'] = $passworQualquer;

        $response = $this->post(route('auth.login'), $user);

        $response->assertStatus(401)
                 ->assertJson([
                    'menssage' => 'E-mail ou senha invalidos!'
                 ]);
    }

    public function test_deve_conseguir_logar_ao_registrar_user(): void
    {
        $user = User::factory()->create()->toArray();

        $user['password'] = '12345678';

        $response = $this->post(route('auth.login'), $user);

        $response->assertStatus(200)
                 ->assertJson([
                    'menssage' => 'Dados retornados com sucesso'
                 ]);
    }
}
