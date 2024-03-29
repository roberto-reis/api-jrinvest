<?php

namespace App\Http\Requests\RebalanceamentoAtivo;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRebalanceamentoAtivoRequest extends FormRequest
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
            'ativo_uid' => [
                'required',
                'uuid',
                'exists:ativos,uid',
                Rule::unique('rebalanceamento_ativos')->where('user_uid', Auth::user()->uid) // validation unique composite key
            ],
            'percentual' => ['required', 'numeric', 'min:0.01', 'max:100.00', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }

    public function messages()
    {
        return [
            'ativo_uid.required' => 'O campo :attribute é obrigatório',
            'percentual.regex' => 'O campo :attribute tem que ser número válido. ex: 1.50 ou 25.50',
            'percentual.min' => 'O campo :attribute deve ser pelo menos :min.',
            'percentual.max' => 'O campo :attribute deve ser no máximo :max.',
            'ativo_uid.unique' => 'Já foi definido uma porcentagem para este ativo',
        ];
    }
}
