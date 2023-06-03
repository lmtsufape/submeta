<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdicionarIntegranteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'cpf_consulta' => [
                'required',
                'string',
                'regex:/^\d{3}.\d{3}.\d{3}-\d{2}$/',
                'exists:users,cpf'
            ],
            'funcao_participante' => [
                'required',
                'exists:funcao_participantes,id'
            ]
        ];
    }

    public function messages()
    {

        return [
            'cpf_consulta.required' => 'O CPF é obrigatório',
            'cpf_consulta.regex' => 'O CPF é inválido',
            'cpf_consulta.exists' => 'Usuário não encontrado',
            'funcao_participante.required' => 'A função do participantes é obrigatória'
        ];
    }
}
