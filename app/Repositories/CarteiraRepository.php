<?php

namespace App\Repositories;

use App\Models\Carteira;
use App\Models\Operacao;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;
use App\Interfaces\Repositories\ICarteiraRepository;
use Illuminate\Support\Collection;

class CarteiraRepository implements ICarteiraRepository
{
    private Carteira $model;

    public function __construct()
    {
        $this->model = app(Carteira::class);
    }

    public function getAllByUser(string $userUid): Collection
    {
        $operacoesAtivos = Operacao::select('operacoes.*', 'tipos_operacoes.nome_interno AS tipo_operacao')
        ->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid')
        ->where('user_uid', $userUid)
        ->get()
        ->groupBy('ativo_uid');

        return $operacoesAtivos;
    }


    public function updateOrCreate(CarteiraUpdateOrCreateDTO $dto): void
    {
        $this->model::updateOrCreate([
            'user_uid' => $dto->user_uid,
            'ativo_uid' => $dto->ativo_uid,
        ],
        [
            'quantidade' => $dto->quantidade,
            'preco_medio' => $dto->preco_medio,
            'custo_total' => $dto->custo_total
        ]);
    }
}
