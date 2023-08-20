<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class ListPortfolioRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:quantidade,codigo_ativo,classe_ativo,custo_total,preco_medio'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
