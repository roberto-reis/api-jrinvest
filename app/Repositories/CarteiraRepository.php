<?php

namespace App\Repositories;

use App\Models\Carteira;
use App\Models\Operacao;
use App\DTOs\Carteira\CarteiraUpdateOrCreateDTO;
use App\Interfaces\Repositories\ICarteiraRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CarteiraRepository implements ICarteiraRepository
{
    private Carteira $model;

    public function __construct()
    {
        $this->model = app(Carteira::class);
    }

    public function getAll(): Collection
    {
        $carteira = $this->model::select('carteiras.*', 'ativos.codigo AS codigo_ativo', 'classes_ativos.nome AS classe_ativo')
                        ->join('ativos', 'ativos.uid', '=', 'carteiras.ativo_uid')
                        ->join('classes_ativos', 'classes_ativos.uid', '=', 'ativos.classe_ativo_uid')
                        ->where('user_uid', Auth::user()->uid);

        return $carteira->get();
    }

    public function getAllByUser(string $userUid): Collection
    {
        // TODO: Alterar para repository de Operações
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
