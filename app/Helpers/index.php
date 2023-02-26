<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('send_log')) {
    function send_log(string $mensagem, array $context = [], Exception $exception = null, string $tipo = 'info') {
        if ($exception) {
            $context['menssage_erro'] = $exception->getMessage();
            $context['file'] = $exception->getFile();
            $context['line'] = $exception->getLine();
            $context['code'] = $exception->getCode();
        }

        Log::{$tipo}($mensagem, $context);
    }
}
