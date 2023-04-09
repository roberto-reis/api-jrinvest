<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IClasseAtivoRepository;
use App\Models\ClasseAtivo;

class ClasseAtivoRepository implements IClasseAtivoRepository
{
    private ClasseAtivo $model;

    public function __construct()
    {
        $this->model = app(ClasseAtivo::class);
    }

    public function getAll(): array
    {
        return $this->model->paginate()->toArray();
    }
}
