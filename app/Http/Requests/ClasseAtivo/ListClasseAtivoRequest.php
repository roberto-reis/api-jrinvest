<?php

namespace App\Http\Requests\ClasseAtivo;

use Illuminate\Foundation\Http\FormRequest;

class ListClasseAtivoRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:nome_interno,descricao,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
