<?php

namespace App\Http\Requests;

use App\Evento;
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
        $rules = [
            'editalId'                => ['required', 'string'],
            'marcado.*'                => ['required'],
            'titulo'                => ['required', 'string'],
            'grande_area_id'              => ['required', 'string'],
            'area_id'                    => ['required', 'string'],
            'linkLattesEstudante'         => ['required', 'string'],
            'pontuacaoPlanilha'       => ['required', 'string'],
            'linkGrupoPesquisa'               => ['required', 'string'],
            'anexoProjeto'     => [[Rule::requiredIf(!$this->has('rascunho') && $projeto->anexoProjeto == null)], 'mimes:pdf'],
            'anexoDecisaoCONSU'     => [Rule::requiredIf($evento->consu && $projeto->anexoDecisaoCONSU == null), 'mimes:pdf'],
            'anexoPlanilhaPontuacao'     => [[Rule::requiredIf(!$this->has('rascunho') && $projeto->anexoPlanilhaPontuacao == null)]],
            'anexoLattesCoordenador'     => [[Rule::requiredIf(!$this->has('rascunho') && $projeto->anexoLattesCoordenador == null)], 'mimes:pdf'],
            'anexoGrupoPesquisa'     => [[Rule::requiredIf(!$this->has('rascunho') && $projeto->anexoGrupoPesquisa == null)], 'mimes:pdf'],
            'anexoAutorizacaoComiteEtica'     => [
                Rule::requiredIf((!$this->has('rascunho') && $projeto->justificativaAutorizacaoEtica == null && $projeto->anexoAutorizacaoComiteEtica == null) )
            ],
            'justificativaAutorizacaoEtica'   => [
                Rule::requiredIf((!$this->has('rascunho') && $projeto->anexoAutorizacaoComiteEtica == null && $projeto->justificativaAutorizacaoEtica == null))
            ],
            
        ];
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
                    $rules['media_do_curso.'.$value] = ['required', 'string'];
                    $rules['nomePlanoTrabalho.'.$value] = ['required', 'string'];
    
                }
            }

        }
        // dd($this->all());
        if ($this->has('rascunho')) {
            return [
                
            ];
        }else{
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
