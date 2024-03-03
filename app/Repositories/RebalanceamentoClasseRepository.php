<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\RebalanceamentoClasse;
use App\Exceptions\RebalanceamentoClasseException;
use App\DTOs\Rebalanceamento\RebalanceamentoClasseDTO;
use App\Interfaces\Repositories\IRebalanceamentoClasseRepository;

class RebalanceamentoClasseRepository implements IRebalanceamentoClasseRepository
{
    private RebalanceamentoClasse $model;
    private int $perPage = 15;
    private array $searchFields = ['percentual', 'rebalanceamento_classes.created_at', 'classes_ativos.nome'];

    public function __construct()
    {
        $this->model = app(RebalanceamentoClasse::class);
    }

    public function getAll(array $filters = []): array
    {
        $rebalanceamentoQuery = $this->model::query()
                                    ->select(['rebalanceamento_classes.*', 'classes_ativos.nome as classe_ativo'])
                                    ->join('classes_ativos', 'rebalanceamento_classes.classe_ativo_uid', '=', 'classes_ativos.uid')
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

        if (isset($filters['withPaginate']) && (bool)$filters['withPaginate']) {
            return $rebalanceamentoQuery->paginate($filters['perPage'] ?? $this->perPage)->toArray();
        }

        return $rebalanceamentoQuery->get()->toArray();
    }

    public function find(string $uid, array $with = []): array
    {
        $rebalanceamentoClasse = $this->model::with($with)
                                        ->where('uid', $uid)
                                        ->where('user_uid', Auth::user()->uid)
                                        ->first();

        if (!$rebalanceamentoClasse) throw new RebalanceamentoClasseException('Rebalanceamento por classe não encontrado', 404);

        return $rebalanceamentoClasse->toArray();
    }

    public function exists(string $value, string $field = 'uid'): bool
    {
        return $this->model::where($field, $value)->exists();
    }

    public function somaPecentual(string $data, string $campo = 'user_uid'): float
    {
        return $this->model::where($campo, $data)->sum('percentual');
    }

    public function somaPecentualUpdate(string $userUid, string $uid): float
    {
        return $this->model::where('user_uid', $userUid)->where('uid', '<>', $uid)->sum('percentual');
    }

    public function store(RebalanceamentoClasseDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function update(string $uid, RebalanceamentoClasseDTO $dto): array
    {
        $rebalanceamentoClasse = $this->model::where('uid', $uid)
                                            ->where('user_uid', $dto->user_uid)->first();

        $rebalanceamentoClasse->update($dto->toArray());

        return $rebalanceamentoClasse->toArray();
    }

    public function delete(string $uid): bool
    {
        $rebalanceamentoClasse = $this->model::where('uid', $uid)
                                        ->where('user_uid', Auth::user()->uid)->first();

        if (!$rebalanceamentoClasse) {
            throw new RebalanceamentoClasseException('Rebalanceamento por classe não encontrado', 404);
        }

        return $rebalanceamentoClasse->delete();
    }
}
