<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();

        //regras do user (att de senha inclusa)
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'cpf', Rule::unique('users')->ignore($user->id)],
            'celular' => ['required', 'string', 'telefone'],
            'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
            'instituicaoSelect' => ['required_without:instituicao'],
            'alterarSenhaCheckBox' => ['nullable'],
            'senha_atual' => [
                'required_with:nova_senha',
                function ($attr, $value, $fail) {
                    if ($this->alterarSenhaCheckBox && !Hash::check($value, $this->user()->password)) {
                        $fail('Senha atual não corresponde');
                    }
                }
            ],
            'confirmar_senha' => [
                'required_if:alterarSenhaCheckBox,on',
            ],

            'nova_senha' => [
                'required_if:alterarSenhaCheckBox,on',
                'min:8',
                'same:confirmar_senha',
            ],
        ];

        //auxiliar para pos-doutorando
        $requires = $this->cargo !== 'Estudante' || ($this->cargo === 'Estudante' && $this->vinculo === 'Pós-doutorando');

        //regras do proponente
        if ($user->tipo === 'proponente') {
            $rules = array_merge($rules, [
                'cargo' => ['required'],
                'vinculo' => ['required'],
                'outro' => ['required_if:vinculo,Outro'],


                'titulacaoMaxima' => [
                    'required_with:anoTitulacao,areaFormacao,bolsistaProdutividade',
                    Rule::requiredIf($requires),
                ],
                'anoTitulacao' => [
                    'required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes',
                    Rule::requiredIf($requires),
                ],
                'areaFormacao' => [
                    'required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes',
                    Rule::requiredIf($requires),
                ],
                'bolsistaProdutividade' => [
                    'required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes',
                    Rule::requiredIf($requires),
                ],

                'nivel' => ['required_if:bolsistaProdutividade,sim'],

                'linkLattes' => [
                    'required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade',
                    Rule::requiredIf($requires),
                    'link_lattes',
                ],
            ]);
        }

        //regras do participante
        if ($user->tipo === 'participante') {
            $rules = array_merge($rules, [
                'outroCursoEstudante' => ['required_if:cursoEstudante,Outro', 'max:255'],
                'cursoEstudante' => ['required_without:outroCursoEstudante'],
                'perfil' => ['required'],
                'linkLattes' => ['required', 'url'],
                //esses devem ser required?
                'rg' => ['required', Rule::unique('participantes')->ignore($user->participantes->first()->id)],
                'data_de_nascimento' => ['required', 'date'],
                'cep' => ['required', 'string'],
                'uf' => ['required', 'string', 'max:2'],
                'cidade' => ['required', 'string'],
                'rua' => ['required', 'string'],
                'numero' => ['required', 'string'],
                'bairro' => ['required', 'string'],
                'complemento' => ['nullable', 'string'],
            ]);
        }
        if ($user->tipo === 'avaliador') {
            $rules = array_merge($rules, [
                'area' => ['nullable','array'],
                'natureza' => ['nullable','array'],
            ]);
        }

        return $rules;
    }
}
