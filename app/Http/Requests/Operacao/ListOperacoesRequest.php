<?php

namespace App\Http\Requests\Operacao;

use Illuminate\Foundation\Http\FormRequest;

class ListOperacoesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'perPage' => ['nullable', 'integer'],
            'withPaginate' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'string', 'in:cotacao_preco,quantidade,data_operacao,created_at,codigo_ativo,classe_ativo,tipo_operacao,nome_corretora'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
