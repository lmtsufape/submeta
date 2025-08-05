<?php

namespace App\Http\Requests;

use App\Evento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\User;

class StoreTrabalho extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    protected function prepareForValidation()
    {
        $func = function ($value) {
            return ['cpf' => $value];
        };
        $this->merge([
            'cpfs' => array_map($func, $this->cpf),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd($this->all());
        $evento = Evento::find($this->editalId);
        $rules = [];
        if ($this->has('marcado')) {
            $rules['cpfs.*.cpf'] = ['distinct', 'nullable'];
            foreach ($this->get('marcado') as $key => $value) {

                if (intval($value) == $key) {
                    //user
                    $rules['name.' . $value] = ['required', 'string'];
                    $rules['email.' . $value] = ['required', 'string'];
                    $rules['instituicao.' . $value] = ['required', 'string'];
                    $rules['cpf.' . $value] = ['required', 'string'];
                    $rules['celular.' . $value] = ['required', 'string'];
                    if (User::where('cpf', $this->cpf[$value])->first()->tipo == "participante") {
                        //endereco
                        $rules['rua.' . $value] = ['required', 'string'];
                        $rules['numero.' . $value] = ['required', 'string'];
                        $rules['bairro.' . $value] = ['required', 'string'];
                        $rules['cidade.' . $value] = ['required', 'string'];
                        $rules['uf.' . $value] = ['required', 'string'];
                        $rules['cep.' . $value] = ['required', 'string'];
                        //participante
                        $rules['rg.' . $value] = ['required', 'string'];
                        $rules['data_de_nascimento.' . $value] = ['required', 'string'];
                        $rules['curso.' . $value] = ['required', 'string'];

                        //participantes da pesquisa
                        if ($evento->natureza_id != 3) {
                            if($evento->tipo != "PICP")
                            {
                                $rules['ordem_prioridade.' . $value] = ['required', 'string'];
                            }
                            $rules['turno.' . $value] = ['required', 'string'];
                            $rules['periodo_atual.' . $value] = ['required', 'string'];
                            $rules['total_periodos.' . $value] = ['required', 'string'];
                            $rules['media_do_curso.' . $value] = ['required', 'string'];
                        }

                        if(($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") && ($this->funcaoParticipante[$value] == "Voluntário" || $this->funcaoParticipante[$value] == "Bolsista")){
                            $rules['anexoPlanoTrabalho.' . $value] = ['required'];
                            $rules['nomePlanoTrabalho.' . $value] = ['required', 'string'];
                        }
                    }

                    // if($evento->tipo != "PIBEX") {
                    //     $rules['media_do_curso.' . $value] = ['required', 'string'];
                    // }

                }
            }
        } else if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {

            $rules['anexoPlanoTrabalho'] = ['required'];
            $rules['nomePlanoTrabalho'] = ['required', 'string'];
        }

        if ($this->has('rascunho')) {
            $rules = [];
            return $rules;
        } else {
            //anexos
            if ($evento->nome_docExtra != null) {
                $rules['anexo_docExtra'] = [Rule::requiredIf($evento->obrigatoriedade_docExtra == true), 'file', 'mimes:zip,doc,docx,pdf', 'max:6144'];
            }


            if ($evento->tipo != "PIBEX" && $evento->tipo != "CONTINUO"  && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {
                //dd($this->preenchimentoFormFlag);

                if($evento->tipo != "PICP")
                {
                    if($evento->tipo != "PIBIC" && $evento->tipo != "PIBIC-EM" && $evento->tipo != "PIBIC-AF")
                    {
                        $rules['anexoGrupoPesquisa'] = ['required', 'mimes:pdf'];
                    }
                    
                    $rules['anexoPlanilhaPontuacao'] = ['required'];
                    $rules['anexoLattesCoordenador'] = ['required', 'mimes:pdf'];
                    $rules['pontuacaoPlanilha'] = ['required', 'string'];
                    $rules['anexo_acao_afirmativa'] = [Rule::requiredIf($this->radioAcoesAfirmativas == 'sim')];
                }

                $rules['linkGrupoPesquisa'] = ['required', 'string'];
                $rules['anexoAutorizacaoComiteEtica'] = [Rule::requiredIf($this->autorizacaoFlag == 'sim')];
                $rules['justificativaAutorizacaoEtica'] = [Rule::requiredIf($this->autorizacaoFlag == 'nao')];
                
                /*if($evento->tipo == "PIBIC" || $evento->tipo == "PIBITI"){
                    $rules['preenchimentoFormFlag'] = [Rule::in(['sim']), 'required'];
                }*/
            }

            $rules['editalId'] = ['required', 'string'];
            $rules['marcado.*'] = ['required'];
            $rules['titulo'] = ['required', 'string'];
            $rules['grande_area_id'] = [Rule::requiredIf($evento->natureza_id != 3), 'string'];
            

            if($evento->tipo != "PICP" && $evento->tipo != 'PIBIC' && $evento->tipo != 'PIBIC-EM' && $evento->tipo != 'PIBIC-AF') {
                $rules['area_id'] = [Rule::requiredIf($evento->natureza_id != 3), 'string'];
            }

            if ($evento->natureza_id == 3) {
                if($evento->tipo == "PIBAC" || $evento->tipo == "CONTINUO-AC")
                {
                    $rules['area_tematica_id'] = ['required'];
                    $rules['ods'] = ['required'];
                }
                else
                {
                    $rules['area_tematica_id'] = ['required', 'string'];
                    $rules['ods'] = ['required'];  
                }     
            }

            $rules['linkLattesEstudante'] = ['required', 'string'];


            if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {
                $rules['anexoDecisaoCONSU'] = [Rule::requiredIf($evento->consu), 'mimes:pdf'];
                $rules['anexoProjeto'] = ['required', 'mimes:pdf'];
            } else {
                $rules['anexo_SIPAC'] = ['required', 'mimes:pdf'];
            }
            // dd($rules, $evento);
            return $rules;

        }

    }

    public function messages()
    {

        return [
            'titulo.required' => 'O :attribute é obrigatório',
            'marcado.*.required' => 'Por favor selcione algum participante, é obrigatório',
            'grande_area_id.required' => 'O campo grande área é obrigatório',
            'anexoPlanoTrabalho.*.required' => 'O :attribute é obrigatório',
            'anexoProjeto.required' => 'O :attribute é obrigatório',
            'cpf.*.required' => 'O cpf é obrigatório',
            'cpfs.*.cpf.distinct' => 'O integrante com CPF :input não pode ser adicionado mais de uma vez',
            'name.*.required' => 'O :attribute é obrigatório',
            'email.*.required' => 'O :attribute é obrigatório',
            'instituicao.*.required' => 'O :attribute é obrigatório',
            'emailParticipante.*.required' => 'O :attribute é obrigatório',
            'celular.*.required' => 'O :attribute é obrigatório',
            'rua.*.required' => 'O :attribute é obrigatório',
            'numero.*.required' => 'O :attribute é obrigatório',
            'bairro.*.required' => 'O :attribute é obrigatório',
            'cidade.*.required' => 'O :attribute é obrigatório',
            'uf.*.required' => 'O :attribute é obrigatório',
            'cep.*.required' => 'O :attribute é obrigatório',
            'complemento.*.required' => 'O :attribute é obrigatório',
            'rg.*.required' => 'O :attribute é obrigatório',
            'data_de_nascimento.*.required' => 'O :attribute é obrigatório',
            'curso.*.required' => 'O :attribute é obrigatório',
            'turno.*.required' => 'O :attribute é obrigatório',
            'ordem_prioridade.*.required' => 'O :attribute é obrigatório',
            'periodo_atual.*.required' => 'O :attribute é obrigatório',
            'total_periodos.*.required' => 'O :attribute é obrigatório',
            'media_do_curso.*.required' => 'O :attribute é obrigatório',
            'anexoPlanoTrabalho.*.required' => 'O :attribute é obrigatório',
            'nomePlanoTrabalho.*.required' => 'O :attribute é obrigatório',
            'area_id' => "area id",
            'area_tematica_id' => 'area tematica id',
            'ods.*' => 'Deve ser selecionada pelo menos uma ODS',
            'linkLattesEstudante.*' => "O link do currículo lattes do estudante é obrigatório",
            'anexoDecisaoCONSU.*' => 'anexoDecisaoCONSU',
            'anexo_SIPAC.*' => 'anexo_SIPAC',
            //'preenchimentoFormFlag.*' => 'Preencha o questionário de pesquisa de prospecção interna.',
            'anexo_acao_afirmativa.*' => 'O anexo de ação afirmativa deve ser anexado'
        ];
    }
}
