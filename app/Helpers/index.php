<?php

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
    function response_api(string $mensagem, array $data = [], int $statusCode = 200) {
        return response()->json([
            'menssage' => $mensagem,
            'data' => $data
        ], $statusCode);
    }
}
