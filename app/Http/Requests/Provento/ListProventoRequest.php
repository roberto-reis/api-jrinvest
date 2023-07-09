<?php

namespace App\Http\Requests\Provento;

use Illuminate\Foundation\Http\FormRequest;

class ListProventoRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:data_com,data_pagamento,quantidade_ativo,valor,yield_on_cost,created_at,codigo_ativo,tipo_provento,nome_corretora'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
