<?php

namespace App\Http\Requests\Ativo;

use Illuminate\Foundation\Http\FormRequest;

class ListAtivoRequest extends FormRequest
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
            'sort' => ['nullable', 'string', 'in:codigo,nome,setor,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
