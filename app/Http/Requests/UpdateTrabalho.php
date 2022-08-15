<?php

namespace App\Http\Requests;

use App\Arquivo;
use App\Evento;
use App\Participante;
use App\Trabalho;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrabalho extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        $projeto = Trabalho::find($this->id);
        $evento = Evento::find($this->editalId);
        
        if($this->has('marcado')){
            foreach ($this->get('marcado') as $key => $value) {
                if( intval($value)  == $key){     
                    //user
                    $rules['name.'.$value] = ['required', 'string'];
                    $rules['email.'.$value] = ['required', 'string'];
                    $rules['instituicao.'.$value] = ['required', 'string'];
                    $rules['cpf.'.$value] = ['required', 'string'];
                    $rules['celular.'.$value] = ['required', 'string'];
                    //endereco
                    $rules['rua.'.$value] = ['required', 'string'];
                    $rules['numero.'.$value] = ['required', 'string'];
                    $rules['bairro.'.$value] = ['required', 'string'];
                    $rules['cidade.'.$value] = ['required', 'string'];
                    $rules['uf.'.$value] = ['required', 'string'];
                    $rules['cep.'.$value] = ['required', 'string'];
                    //participante
                    $rules['rg.'.$value] = ['required', 'string'];
                    $rules['data_de_nascimento.'.$value] = ['required', 'string'];
                    $rules['curso.'.$value] = ['required', 'string'];
                    $rules['turno.'.$value] = ['required', 'string'];
                    $rules['ordem_prioridade.'.$value] = ['required', 'string'];
                    $rules['periodo_atual.'.$value] = ['required', 'string'];
                    $rules['total_periodos.'.$value] = ['required', 'string'];
                    if($evento->tipo != "PIBEX") {
                        $rules['media_do_curso.' . $value] = ['required', 'string'];
                    }
                    $rules['nomePlanoTrabalho.'.$value] = ['required', 'string'];
                    $rules['anexoPlanoTrabalho.'.$value] = ['required', 'mimes:pdf'];
                    
                }
            }

        }
        // dd($this->all());
        if ($this->has('rascunho')) {
            $rules = [];
            return $rules;
        }else{

            //$rules = [];
            if($evento->tipo!="PIBEX"){
                $rules['anexoPlanilhaPontuacao']       = [Rule::requiredIf($projeto->anexoPlanilhaPontuacao == null)];
                $rules['anexoLattesCoordenador']       = [Rule::requiredIf($projeto->anexoLattesCoordenador == null), 'mimes:pdf'];
                $rules['anexoGrupoPesquisa']           = [Rule::requiredIf($projeto->anexoGrupoPesquisa == null), 'mimes:pdf'];
                // anexoAutorizacaoComiteEtica = SIM
                $rules['anexoAutorizacaoComiteEtica']  = [Rule::requiredIf($this->autorizacaoFlag == 'sim' && $projeto->anexoAutorizacaoComiteEtica == null)];
                // justificativaAutorizacaoEtica = NAO
                $rules['justificativaAutorizacaoEtica'] = [Rule::requiredIf($this->autorizacaoFlag == 'nao' && $projeto->justificativaAutorizacaoEtica == null)];
                $rules['pontuacaoPlanilha']            = ['required', 'string'];
                $rules['linkGrupoPesquisa']            = ['required', 'string'];
            }
            if($evento->nome_docExtra != null){
                $rules['anexo_docExtra']               = [Rule::requiredIf($evento->obrigatoriedade_docExtra == true && $evento->obrigatoriedade_docExtra == null),'file', 'mimes:zip,doc,docx,pdf', 'max:2048'];
            }
            $rules['editalId']                     = ['required', 'string'];
            $rules['marcado.*']                    = ['required'];
            $rules['titulo']                       = ['required', 'string'];
            $rules['grande_area_id']               = ['required', 'string'];
            $rules['area_id']                      = ['required', 'string'];

            $rules['linkLattesEstudante']          = ['required', 'string'];


            $rules['anexoProjeto']                 = [Rule::requiredIf($projeto->anexoProjeto == null), 'mimes:pdf'];
            $rules['anexoDecisaoCONSU']            = [Rule::requiredIf($evento->consu && $projeto->anexoDecisaoCONSU == null), 'mimes:pdf'];

            return $rules;
        }
    }
    public function messages()
    {
        
        return [
            'titulo.required' => 'O :attribute é obrigatório',
            'justificativaAutorizacaoEtica.required' => 'O campo justificativa Autorizacao Etica é obrigatório',
            'anexoAutorizacaoComiteEtica.required' => 'O campo anexoAutorizacao Comite Etica é obrigatório',
            
        ];
    }
}