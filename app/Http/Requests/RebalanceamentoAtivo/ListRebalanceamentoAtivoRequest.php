<?php

namespace App\Http\Requests\RebalanceamentoAtivo;

use Illuminate\Foundation\Http\FormRequest;

class ListRebalanceamentoAtivoRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:percentual,created_at,codigo_ativo'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
