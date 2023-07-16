<?php

namespace App\Http\Requests\Operacao;

use Illuminate\Foundation\Http\FormRequest;

class OperacaoRequest extends FormRequest
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
            'ativo_uid' => ['required', 'uuid', 'exists:ativos,uid'],
            'tipo_operacao_uid' => ['required', 'uuid', 'exists:tipos_operacoes,uid'],
            'corretora_uid' => ['required', 'uuid', 'exists:corretoras,uid'],
            'cotacao_preco' => ['required', 'numeric'],
            'quantidade' => ['required', 'numeric'],
            'data_operacao' => ['required', 'date', 'date_format:Y-m-d']
        ];
    }
}
