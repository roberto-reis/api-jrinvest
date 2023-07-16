<?php

namespace App\Repositories;

use App\Models\Provento;
use App\DTOs\Provento\ProventoDTO;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ProventoException;
use App\Interfaces\Repositories\IProventoRepository;

class ProventoRepository implements IProventoRepository
{
    private Provento $model;
    private int $perPage = 15;
    private array $searchFields = [
        'data_com',
        'data_pagamento',
        'quantidade_ativo',
        'valor',
        'yield_on_cost',
        'proventos.created_at',
        'ativos.codigo',
        'tipos_proventos.nome',
        'corretoras.nome'
    ];

    public function __construct()
    {
        $this->model = app(Provento::class);
    }

    public function getAll(array $filters): array
    {
        $proventos = $this->model::query()
                                ->select([
                                    'proventos.*',
                                    'ativos.codigo as codigo_ativo',
                                    'tipos_proventos.nome as tipo_provento',
                                    'corretoras.nome as nome_corretora'
                                ])
                                ->join('tipos_proventos', 'proventos.tipo_provento_uid', '=', 'tipos_proventos.uid')
                                ->join('ativos', 'proventos.ativo_uid', '=', 'ativos.uid')
                                ->join('corretoras', 'proventos.corretora_uid', '=', 'corretoras.uid')
                                ->where('user_uid', Auth::user()->uid);


        if (isset($filters['search'])) {
            $proventos->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }
            });
        }

        if (isset($filters['sort'])) {
            $proventos->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $proventos->get()->toArray();
        }

        return $proventos->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function find(string $uid): array
    {
        $provento = $this->model::with(['ativo', 'tipoProvento'])
                            ->where('uid', $uid)
                            ->where('user_uid', Auth::user()->uid)->first();

        if (!$provento) throw new ProventoException('Provento não encontrado', 404);

        return $provento->toArray();
    }

    public function store(ProventoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function update(string $uid, ProventoDTO $dto): array
    {
        $provento = $this->model::where('uid', $uid)
                            ->where('user_uid', $dto->user_uid)->first();

        if (!$provento) throw new ProventoException('Provento não encontrado', 404);

        $provento->update($dto->toArray());

        return $provento->toArray();
    }

    public function delete(string $uid): bool
    {
        $provento = $this->model::where('uid', $uid)
                            ->where('user_uid', Auth::user()->uid)->first();

        if (!$provento) throw new ProventoException('Provento não encontrado', 404);

        return $provento->delete();
    }
}
