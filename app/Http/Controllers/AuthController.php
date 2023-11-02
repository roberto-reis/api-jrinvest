<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use App\Exceptions\UserException;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\UpdateAction;
use App\Exceptions\LoginException;
use App\Actions\Auth\RegisterAction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $registerAction): JsonResponse
    {
        try {
            $user = $registerAction->execute($request->validated());
            return response_api('Dados cadastrados com sucesso', $user, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar usuário', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar usuário',
                [],
                $e->getCode()
            );
        }
    }

    public function login(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        try {
            $user = $loginAction->execute($request->validated());
            return response_api('Dados retornados com sucesso', $user, 200);

        } catch (LoginException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        } catch (\Exception $e) {
            send_log('Erro ao logar usuário', [], 'error', $e);
            return response_api(
                'Erro ao logar usuário',
                [],
                $e->getCode()
            );
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            $user = $request->user()->toArray();
            return response_api('Dados retornados com sucesso', $user, 200);

        } catch (\Exception $e) {
            send_log('Erro ao logar usuário', [], 'error', $e);
            return response_api(
                'Erro ao logar usuário',
                [],
                $e->getCode()
            );
        }
    }

    public function logout(): JsonResponse
    {
        try {
            Auth::user()->currentAccessToken()->delete();
            return response_api('Logout feito com sucesso', [], 200);

        } catch (\Exception $e) {
            send_log('Erro ao deslogar usuário', [], 'error', $e);
            return response_api(
                'Erro ao deslogar usuário',
                [],
                $e->getCode()
            );
        }
    }

    public function update(UpdateRequest $request, UpdateAction $updateAction, string $uid): JsonResponse
    {
        try {
            $user = $updateAction->execute($uid, $request->validated());
            return response_api('Dados atualizado com sucesso', $user, 200);

        } catch (UserException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        } catch (\Exception $e) {
            send_log('Erro ao atualizar usuário', [], 'error', $e);
            return response_api(
                'Erro ao atualizar usuário',
                [],
                $e->getCode()
            );
        }
    }



    // TODO: Falta Implementar Delete User
    // TODO: Falta Implementar Forgot Password
    // TODO: Falta Implementar Reset Password
}
