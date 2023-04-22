<?php

namespace App\Exceptions;

use Exception;

class ClasseAtivoNaoEncontradoException extends Exception
{
    protected $message = 'Classe de ativo não encontrado';
    protected $code = 404;
}
