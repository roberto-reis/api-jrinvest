<?php

namespace App\Http\Requests\Ativo;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtivoRequest extends FormRequest
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
            'codigo' => ['required', 'string', 'min:3', 'max:255', 'unique:ativos,codigo'],
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'classe_ativo_uid' => ['required', 'uuid', 'exists:classes_ativos,uid'],
            'setor' => ['required', 'string', 'min:3', 'max:255']
        ];
    }
}
