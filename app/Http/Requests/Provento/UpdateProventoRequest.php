<?php

namespace App\Http\Requests\Provento;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProventoRequest extends FormRequest
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
            'tipo_provento_uid' => ['required', 'uuid', 'exists:tipos_proventos,uid'],
            'corretora_uid' => ['required', 'uuid', 'exists:corretoras,uid'],
            'data_com' => ['nullable', 'date'],
            'data_pagamento' => ['required', 'date'],
            'quantidade_ativo' => ['required', 'numeric'],
            'valor' => ['required', 'numeric']
        ];
    }
}
