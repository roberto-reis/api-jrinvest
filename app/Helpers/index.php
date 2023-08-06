<?php

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

if (!function_exists('send_log')) {
    function send_log(string $mensagem, array $context = [], string $tipo = 'info', Exception $exception = null) {
        if ($exception) {
            $context['menssage'] = $exception->getMessage();
            $context['file'] = $exception->getFile();
            $context['line'] = $exception->getLine();
            $context['code'] = $exception->getCode();
        }

        Log::{$tipo}($mensagem, $context);
    }
}

if (!function_exists('response_api')) {
    function response_api(string $mensagem, array $data = [], int $statusCode = 200): JsonResponse {
        return response()->json([
            'message' => $mensagem,
            'data' => $data
        ], $statusCode == 0 ? 500 : $statusCode);
    }
}

if (!function_exists('create_token')) {
    function create_token(User $user, string $name = 'auth_token', array $abilities = ['*']): array
    {
        $timeInMinutes = (int) env('TOKEN_EXPITEST_AT');
        $expiresAt = $timeInMinutes > 0 ? now()->addMinutes($timeInMinutes) : null;

        $token = $user->createToken($name, $abilities, $expiresAt);

        return [
            'user'         => $user->toArray(),
            'access_token' => $token->plainTextToken,
            'expires_at'   => $token->accessToken->expires_at,
            'token_type'   => 'Bearer'
        ];
    }
}
