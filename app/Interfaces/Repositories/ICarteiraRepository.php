<?php

namespace App\Interfaces\Repositories;

use Illuminate\Support\Collection;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;

interface ICarteiraRepository
{
    public function getAll(): Collection;
    public function updateOrCreate(CarteiraUpdateOrCreateDTO $dto): void;
}
