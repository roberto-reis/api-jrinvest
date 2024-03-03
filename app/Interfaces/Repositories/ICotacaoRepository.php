<?php

namespace App\Interfaces\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ICotacaoRepository
{
    public function getAll(Carbon $data = null, $rangeDays = 3): Collection;
}
