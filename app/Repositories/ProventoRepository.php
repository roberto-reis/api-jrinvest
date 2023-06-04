<?php

namespace App\Repositories;

use App\Models\Provento;
use App\Exceptions\ProventoException;
use App\Interfaces\Repositories\IProventoRepository;

class ProventoRepository implements IProventoRepository
{
    private Provento $model;
    private int $perPage = 15;
    private array $searchFields = ['data_com', 'data_pagamento', 'quantidade_ativo', 'valor', 'yield_on_cost', 'created_at'];
    private array $searchWith = [
        'ativo' => 'codigo',
        'tipoProvento' => 'nome'
    ];

    public function __construct()
    {
        $this->model = app(Provento::class);
    }

    public function getAll(string $userUid, array $filters): array
    {
        $proventos = $this->model::query()->with(['ativo', 'tipoProvento'])
                                          ->where('user_uid', $userUid);

        if (isset($filters['search']) && !empty($filters['search'])) {
            $proventos->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }

                // Buscar nos relacionamentos
                foreach ($this->searchWith as $relationship => $field) {
                    $query->orWhereHas($relationship, function($query) use ($field, $filters) {
                        $query->where($field, 'like', "%{$filters['search']}%");
                    });
                }
            });
        }

        if (isset($filters['sort']) && isset($filters['direction'])) {
            $proventos->orderBy($filters['sort'], $filters['direction']);
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $proventos->get()->toArray();
        }

        return $proventos->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function find(string $uid, string $userUid): array
    {
        $provento = $this->model::with(['ativo', 'tipoProvento'])
                            ->where('uid', $uid)
                            ->where('user_uid', $userUid)->first();

        if (!$provento) throw new ProventoException('Provento não encontrado', 404);

        return $provento->toArray();
    }
}
