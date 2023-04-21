<?php

namespace App\Actions\ClasseAtivo;

use Illuminate\Support\Str;
use App\DTOs\ClasseAtivo\StoreClasseAtivoDTO;
use App\Interfaces\Repositories\IClasseAtivoRepository;

class StoreAction
{
    public function __construct(
        private IClasseAtivoRepository $classeAtivoRepository,
    )
    {}

    public function execute(array $classeAtivo = []): array
    {
        $classeAtivo['nome_interno'] = Str::slug($classeAtivo['nome'], '-');
        $classeAtivoDto = new StoreClasseAtivoDTO($classeAtivo);

        return $this->classeAtivoRepository->store($classeAtivoDto);
    }
}
