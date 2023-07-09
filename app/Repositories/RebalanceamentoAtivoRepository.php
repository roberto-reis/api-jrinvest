<?php

namespace App\Repositories;

use App\Models\RebalanceamentoAtivo;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RebalanceamentoAtivoException;
use App\DTOs\Rebalanceamento\RebalanceamentoAtivoDTO;
use App\Interfaces\Repositories\IRebalanceamentoAtivoRepository;

class RebalanceamentoAtivoRepository implements IRebalanceamentoAtivoRepository
{
    private RebalanceamentoAtivo $model;
    private int $perPage = 15;
    private array $searchFields = ['percentual', 'rebalanceamento_ativos.created_at', 'ativos.codigo'];

    public function __construct()
    {
        $this->model = app(RebalanceamentoAtivo::class);
    }

    public function getAll(array $filters): array
    {
        $rebalanceamentoQuery = $this->model::query()
                                    ->select([
                                        'rebalanceamento_ativos.*',
                                        'ativos.codigo as codigo_ativo'
                                    ])
                                    ->join('ativos', 'rebalanceamento_ativos.ativo_uid', '=', 'ativos.uid')
                                    ->where('user_uid', Auth::user()->uid);

        if (isset($filters['search'])) {
            $rebalanceamentoQuery->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }
            });
        }

        if (isset($filters['sort'])) {
            $rebalanceamentoQuery->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $rebalanceamentoQuery->get()->toArray();
        }

        return $rebalanceamentoQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function find(string $uid, array $with = []): array
    {
        $rebalanceamentoClasse = $this->model::with($with)
                                    ->where('uid', $uid)
                                    ->where('user_uid', Auth::user()->uid)
                                    ->first();

        if (!$rebalanceamentoClasse) throw new RebalanceamentoAtivoException('Rebalanceamento por ativo não encontrado', 404);

        return $rebalanceamentoClasse->toArray();
    }

    public function somaPecentual(string $data, string $campo = 'user_uid'): float
    {
        return $this->model::where($campo, $data)->sum('percentual');
    }

    public function store(RebalanceamentoAtivoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function somaPecentualUpdate(string $userUid, string $uid): float
    {
        return $this->model::where('user_uid', $userUid)->where('uid', '<>', $uid)->sum('percentual');
    }

    public function update(string $uid, RebalanceamentoAtivoDTO $dto): array
    {
        $rebalanceamentoAtivo = $this->model::find($uid);

        $rebalanceamentoAtivo->update($dto->toArray());

        return $rebalanceamentoAtivo->toArray();
    }

    public function delete(string $uid): bool
    {
        $rebalanceamentoAtivo = $this->model::find($uid);

        if (!$rebalanceamentoAtivo) {
            throw new RebalanceamentoAtivoException('Rebalanceamento por ativo não encontrado', 404);
        }

        return $rebalanceamentoAtivo->delete();
    }
}
