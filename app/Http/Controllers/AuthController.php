<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\LoginRequest;
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
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }

    public function login(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        try {
            $user = $registerAction->execute($request->validated());
            return response_api('Dados cadastrados com sucesso', $user, 201);

        } catch (\Exception $e) {
            send_log('Erro ao cadastrar usuário', [], 'error', $e);
            return response_api(
                'Erro ao cadastrar usuário',
                [],
                $e->getCode() == 0 ? 500 : $e->getCode()
            );
        }
    }
}
