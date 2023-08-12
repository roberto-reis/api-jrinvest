<?php

namespace App\Interfaces\Repositories;

use Illuminate\Support\Collection;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;

interface ICarteiraRepository
{
    public function getAllByUser(string $userUid): Collection;
    public function updateOrCreate(CarteiraUpdateOrCreateDTO $dto): void;
}
