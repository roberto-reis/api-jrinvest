<?php

namespace App\Http\Requests\ClasseAtivo;

use Illuminate\Foundation\Http\FormRequest;

class StoreClasseAtivoRequest extends FormRequest
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
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'descricao' => ['required', 'string', 'min:3', 'max:255']
        ];
    }
}
