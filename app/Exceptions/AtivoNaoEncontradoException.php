<?php

namespace App\Exceptions;

use Exception;

class AtivoNaoEncontradoException extends Exception
{
    protected $message = 'Ativo não encontrado';
    protected $code = 404;
}
