<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use Illuminate\Http\JsonResponse;
use App\Exceptions\LoginException;
use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

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

    // TODO: Faltar Implementar Update User
    // TODO: Faltar Implementar Delete User
    // TODO: Faltar Implementar Forgot Password
    // TODO: Faltar Implementar Reset Password
}
