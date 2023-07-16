<?php

namespace App\Repositories;

use App\Models\Operacao;
use App\DTOs\Operacao\OperacaoDTO;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\OperacaoException;
use App\Interfaces\Repositories\IOperacaoRepository;

class OperacaoRepository implements IOperacaoRepository
{
    private Operacao $model;
    private int $perPage = 15;
    private array $searchFields = [
        'cotacao_preco',
        'quantidade',
        'data_operacao',
        'operacoes.created_at',
        'ativos.codigo',
        'classes_ativos.nome',
        'tipos_operacoes.nome',
        'corretoras.nome'
    ];

    public function __construct()
    {
        $this->model = app(Operacao::class);
    }

    public function getAll(array $filters): array
    {
        $operacoes = $this->model::query()
                            ->select([
                                'operacoes.*',
                                'ativos.codigo as codigo_ativo',
                                'classes_ativos.nome as classe_ativo',
                                'tipos_operacoes.nome as tipo_operacao',
                                'corretoras.nome as nome_corretora'
                            ])
                            ->join('tipos_operacoes', 'operacoes.tipo_operacao_uid', '=', 'tipos_operacoes.uid')
                            ->join('ativos', 'operacoes.ativo_uid', '=', 'ativos.uid')
                            ->join('classes_ativos', 'ativos.classe_ativo_uid', '=', 'classes_ativos.uid')
                            ->join('corretoras', 'operacoes.corretora_uid', '=', 'corretoras.uid')
                            ->where('user_uid', Auth::user()->uid);

        if (isset($filters['search']) && !empty($filters['search'])) {
            $operacoes->where(function($query) use ($filters) {
                foreach($this->searchFields as $field) {
                    $query->orWhere($field, 'like', "%{$filters['search']}%");
                }
            });
        }

        if (isset($filters['sort'])) {
            $operacoes->orderBy($filters['sort'], $filters['direction'] ?? 'asc');
        }

        if (isset($filters['withPaginate']) && !(bool)$filters['withPaginate']) {
            return $operacoes->get()->toArray();
        }

        return $operacoes->paginate($filters['perPage'] ?? $this->perPage)->toArray();
    }

    public function find(string $uid): array
    {
        $operacao = $this->model::with(['ativo', 'ativo.classeAtivo', 'tipoOperacao', 'corretora'])
                            ->where('uid', $uid)
                            ->where('user_uid', Auth::user()->uid)->first();

        if (!$operacao) throw new OperacaoException('Operação não encontrado', 404);

        return $operacao->toArray();
    }

    public function store(OperacaoDTO $dto): array
    {
        return $this->model::create($dto->toArray())->toArray();
    }

    public function update(string $uid, OperacaoDTO $dto): array
    {
        $operacao = $this->model::where('uid', $uid)
                            ->where('user_uid', $dto->user_uid)->first();

        if (!$operacao) throw new OperacaoException('Operação não encontrado', 404);

        $operacao->update($dto->toArray());

        return $operacao->toArray();
    }

    public function delete(string $uid): bool
    {
        $operacao = $this->model::where('uid', $uid)
                            ->where('user_uid', Auth::user()->uid)->first();

        if (!$operacao) throw new OperacaoException('Operação não encontrado', 404);

        return $operacao->delete();
    }
}
