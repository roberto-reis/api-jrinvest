<?php

namespace App\Actions\ClasseAtivo;

use Illuminate\Support\Str;
use App\DTOs\ClasseAtivo\ClasseAtivoDTO;
use App\Interfaces\Repositories\IClasseAtivoRepository;

class UpdateAction
{
    public function __construct(
        private IClasseAtivoRepository $classeAtivoRepository,
    )
    {}

    public function execute(string $uid, array $classeAtivo = []): array
    {
        $classeAtivo['nome_interno'] = Str::slug($classeAtivo['nome'], '-');
        $classeAtivoDto = new ClasseAtivoDTO($classeAtivo);

        return $this->classeAtivoRepository->update($uid, $classeAtivoDto);
    }
}
