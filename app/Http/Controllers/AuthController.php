<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\ResetAction;
use App\Exceptions\AuthException;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\ForgotAction;
use App\Actions\Auth\UpdateAction;
use App\Exceptions\LoginException;
use App\Actions\Auth\RegisterAction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Repositories\IAuthRepository;

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

        } catch (AuthException $e) {
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

    public function forgot(ForgotRequest $request, ForgotAction $forgotAction): JsonResponse
    {
        try {
            $forgotAction->execute($request->validated('email'));
            return response_api('Codigo enviado para seu e-mail', [], 200);

        } catch (AuthException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        } catch (\Exception $e) {
            send_log('Erro ao fazer forgot para usuário', [], 'error', $e);
            return response_api(
                'Erro ao fazer forgot para usuário',
                [],
                $e->getCode()
            );
        }
    }

    public function reset(ResetRequest $request, ResetAction $forgotAction): JsonResponse
    {
        try {
            $forgotAction->execute($request->validated());
            return response_api('Senha alterada com sucesso', [], 200);

        } catch (AuthException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        } catch (\Exception $e) {
            send_log('Erro ao resetar senha', [], 'error', $e);
            return response_api(
                'Erro ao resetar senha',
                [],
                $e->getCode()
            );
        }
    }

    // TODO: Falta Implementar Delete User
    public function delete(string $userUid, IAuthRepository $authRepository): JsonResponse
    {
        try {

            $authRepository->delete($userUid);
            return response_api('Usuário deletado com sucesso', [], 200);

        } catch (AuthException $e) {
            return response_api(
                $e->getMessage(),
                [],
                $e->getCode()
            );
        } catch (\Exception $e) {
            send_log('Erro ao deletar usuário', [], 'error', $e);
            return response_api(
                'Erro ao deletar usuário',
                [],
                $e->getCode()
            );
        }

    }

    private function preparaParametros(array $parametros): string
    {
        $parametrosToString = '';

        // dd($parametros);

        foreach ($parametros as $key => $parametro) {
            if (empty($parametro)) continue;

            $parametrosToString .= "{$key}:$parametro ";
        }
        dd(rtrim($parametrosToString));
    }
}
