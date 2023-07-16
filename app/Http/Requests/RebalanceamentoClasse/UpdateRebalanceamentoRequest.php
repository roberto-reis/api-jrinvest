<?php

namespace App\Http\Requests\RebalanceamentoClasse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRebalanceamentoRequest extends FormRequest
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
            'classe_ativo_uid' => ['required', 'uuid', 'exists:classes_ativos,uid',
                Rule::unique('rebalanceamento_classes')->where('user_uid', Auth::user()->uid)->ignore($this->uid, 'uid')],
            'percentual' => ['required', 'numeric', 'min:0.01', 'max:100.00', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }

    public function messages()
    {
        return [
            'user_uid.uuid' => 'O campo :attribute deve ser uuid valido',
            'classe_ativo_uid.uuid' => 'O campo :attribute deve ser uuid valido',
            'classe_ativo_uid.required' => 'O campo "Classe de ativo" é obrigatório',
            'classe_ativo_uid.unique' => 'Já foi definido uma porcentagem para esta classe',
            'percentual.required' => 'O campo :attribute é obrigatório',
            'percentual.regex' => 'O campo :attribute tem que ser número válido. ex: 1.50 ou 25.50',
            'percentual.min' => 'O campo :attribute deve ser pelo menos :min.',
            'percentual.max' => 'O campo :attribute deve ser no máximo :max.',
        ];
    }
}
