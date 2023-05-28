<?php

namespace App\Http\Requests\RebalanceamentoAtivo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRebalanceamentoAtivoRequest extends FormRequest
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
            'user_uid' => ['required', 'uuid', 'exists:users,uid'],
            'ativo_uid' => [
                'required',
                'uuid',
                'exists:ativos,uid',
                Rule::unique('rebalanceamento_ativos')->where('user_uid', $this->user_uid)->ignore($this->uid, 'uid')
            ],
            'percentual' => ['required', 'numeric', 'min:0.01', 'max:100.00', 'regex:/^\d+(\.\d{1,2})?$/']
        ];
    }

    public function messages()
    {
        return [
            'user_uid.uuid' => 'O campo :attribute deve ser uuid valido',
            'ativo_uid.uuid' => 'O campo :attribute deve ser uuid valido',
            'ativo_uid.required' => 'O :attribute é obrigatório',
            'ativo_uid.unique' => 'Já foi definido uma porcentagem para esta classe',
            'percentual.required' => 'O campo :attribute é obrigatório',
            'percentual.regex' => 'O campo :attribute tem que ser número válido. ex: 1.50 ou 25.50',
            'percentual.min' => 'O campo :attribute deve ser pelo menos :min.',
            'percentual.max' => 'O campo :attribute deve ser no máximo :max.',
        ];
    }
}
