<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtribuirBolsistaRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && $this->user()->tipo === 'administrador';
    }

    public function rules()
    {
        $rules = ['cpf' => ['bail', 'required', 'string', 'cpf']];

        if ($this->routeIs('admin.bolsista.store')) {
            $rules += [
                'titulo' => ['required', 'string', 'max:255'],
                'data_entrada' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
                'plano' => ['required', 'file', 'mimes:pdf', 'max:6144'],
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return ['cpf' => 'CPF', 'titulo' => 'título do plano', 'data_entrada' => 'data de entrada', 'plano' => 'plano de trabalho'];
    }

    public function messages()
    {
        return [
            'cpf.cpf' => 'Informe um CPF válido.',
            'plano.mimes' => 'O plano de trabalho deve ser um PDF.',
            'plano.max' => 'O plano de trabalho deve ter no máximo 6 MB.',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('admin.bolsista.create', ['id' => $this->route('id')]);
    }
}
