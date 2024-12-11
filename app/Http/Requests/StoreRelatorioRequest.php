<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRelatorioRequest extends FormRequest
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
        $rules = [];

        switch ($this->input('etapa')) 
        {
            case 'etapa1':
                $rules = [
                    'processo_sipac' => 'required|string|max:255',
                    'inicio_projeto' => 'required|date|before:conclusao_projeto',
                    'conclusao_projeto' => 'required|date|after:inicio_projeto',
                    'titulo_projeto' => 'required|string|min:5|max:255',
                    'nome_coordenador' => 'required|string|max:255',
                    'email_institucional_coordenador' => 'required|email|max:255',
                    'cargo_coordenador' => 'required|string|max:255',
                    'curso_coordenador' => 'required|string|max:255',
                    'cpf_coordenador' => 'required',
                    'telefone_coordenador' => 'required',
                    'ch_coordenador' => 'required|min:1',
                    'select_area_tematica' => 'required',
                    'select_ods' => 'required',
                ];
                break;

            case 'etapa2':
                $rules = [
                    'nome_interno.*' => 'required|string|max:255',
                    'cpf_interno.*' => 'required',
                    'tipo.*' => 'required',
                    'tipo_vinculo.*' => 'required',
                ];
                break;

            case 'etapa3':
                $rules = [
                    'resumo' => 'required|string|max:3000',
                    'objetivos_alcancados' => 'required|string|max:3000',
                    'justificativa_objetivos_alcancados' => 'required|string|max:3000',
                    'pessoas_beneficiadas' => 'required|integer|min:1',
                    'alcance_publico_estimado' => 'required|integer|min:1',
                    'justificativa_publico_estimado' => 'required|string|max:3000',
                    'beneficios_publico_atendido' => 'required|string|max:3000',
                    'impactos_tecnologicos_cientificos' => 'required|string|max:3000',
                    'desafios_encontrados' => 'required|string|max:3000',
                    'avaliacao_projeto_executado' => 'required|string|max:3000',
                    'tecnico_cientifico' => 'required|string',
                    'qtd_tecnico_cientifico' => 'required|min:1',
                    'divulgacao' => 'required|string',
                    'qtd_divulgacao' => 'required|min:1',
                    'didatico_instrucional' => 'required|string',
                    'qtd_didatico_instrucional' => 'required|min:1',
                    'multimidia' => 'required|string',
                    'qtd_multimidia' => 'required|min:1',
                    'artistico_cultural' => 'required|string',
                    'qtd_artistico_cultural' => 'required|min:1',
                ];
                break;

            case 'etapa4':
                $rules = [
                    'formulario_indicadores' => 'required',
                    'certificacao_adicinonal' => 'required',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'processo_sipac.required' => 'O processo sipac é obrigatório.',
            'processo_sipac.string' => 'O processo sipac deve ser um texto.',
            'processo_sipac.max' => 'O processo sipac deve ter no máximo 255 caracteres.',

            'inicio_projeto.required' => 'A data de início do projeto é obrigatória.',
            'inicio_projeto.date' => 'A data de início do projeto deve ser uma data válida.',
            'inicio_projeto.before' => 'A data de início do projeto deve ser antes da data de conclusão do projeto.',

            'conclusao_projeto.required' => 'A data de conclusão do projeto é obrigatória.',
            'conclusao_projeto.date' => 'A data de conclusão do projeto deve ser uma data válida.',
            'conclusao_projeto.after' => 'A data de conclusão do projeto deve ser após a data de início do projeto.',

            'titulo_projeto.required' => 'O título do projeto é obrigatório.',
            'titulo_projeto.string' => 'O título do projeto deve ser um texto.',
            'titulo_projeto.min' => 'O título do projeto deve ter no mínimo 5 caracteres.',
            'titulo_projeto.max' => 'O título do projeto deve ter no máximo 255 caracteres.',

            'nome_coordenador.required' => 'O nome do coordenador é obrigatório.',
            'nome_coordenador.string' => 'O nome do coordenador deve ser um texto.',
            'nome_coordenador.max' => 'O nome do coordenador deve ter no máximo 255 caracteres.',

            'email_institucional_coordenador.required' => 'O e-mail institucional do coordenador é obrigatório.',
            'email_institucional_coordenador.email' => 'O e-mail institucional do coordenador deve ser um e-mail válido.',
            'email_institucional_coordenador.max' => 'O e-mail institucional do coordenador deve ter no máximo 255 caracteres.',

            'cargo_coordenador.required' => 'O cargo do coordenador é obrigatório.',
            'cargo_coordenador.max' => 'O cargo do coordenador deve ter no máximo 255 caracteres.',

            'curso_coordenador.required' => 'O curso do coordenador é obrigatório.',
            'curso_coordenador.string' => 'O curso do coordenador deve ser um texto.',
            'curso_coordenador.max' => 'O curso do coordenador deve ter no máximo 255 caracteres.',

            'cpf_coordenador.required' => 'O CPF do coordenador é obrigatório.',

            'telefone_coordenador.required' => 'O telefone do coordenador é obrigatório.',

            'ch_coordenador.required' => 'A carga horária do coordenador é obrigatória.',
            'ch_coordenador.integer' => 'A carga horária do coordenador deve ser um número inteiro.',
            'ch_coordenador.min' => 'A carga horária do coordenador deve ser no mínimo 1.',

            'select_area_tematica.required' => 'A área temática é obrigatória.',

            'select_ods.required' => 'As ODS são obrigatórias.',

            'captacao_recursos.required' => 'A captação de recursos é obrigatória.',
            'captacao_recursos.string' => 'A captação de recursos deve ser um texto.',

            'resumo.required' => 'O resumo é obrigatório.',
            'resumo.string' => 'O resumo deve ser um texto.',
            'resumo.max' => 'O resumo deve ter no máximo 3000 caracteres.',

            'objetivos_alcancados.required' => 'Os objetivos alcançados são obrigatórios.',
            'objetivos_alcancados.string' => 'Os objetivos alcançados devem ser um texto.',
            'objetivos_alcancados.max' => 'Os objetivos alcançados devem ter no máximo 3000 caracteres.',

            'justificativa_objetivos_alcancados.required' => 'A justificativa dos objetivos alcançados é obrigatória.',
            'justificativa_objetivos_alcancados.string' => 'A justificativa dos objetivos alcançados deve ser um texto.',
            'justificativa_objetivos_alcancados.max' => 'A justificativa dos objetivos alcançados deve ter no máximo 3000 caracteres.',

            'pessoas_beneficiadas.required' => 'O número de pessoas beneficiadas é obrigatório.',
            'pessoas_beneficiadas.integer' => 'O número de pessoas beneficiadas deve ser um número inteiro.',
            'pessoas_beneficiadas.min' => 'O número de pessoas beneficiadas deve ser no mínimo 1.',

            'alcance_publico_estimado.required' => 'O alcance do público estimado é obrigatório.',
            'alcance_publico_estimado.integer' => 'O alcance do público estimado deve ser um número inteiro.',
            'alcance_publico_estimado.min' => 'O alcance do público estimado deve ser no mínimo 1.',

            'justificativa_publico_estimado.required' => 'A justificativa do público estimado é obrigatória.',
            'justificativa_publico_estimado.string' => 'A justificativa do público estimado deve ser um texto.',
            'justificativa_publico_estimado.max' => 'A justificativa do público estimado deve ter no máximo 5000 caracteres.',

            'beneficios_publico_atendido.required' => 'Os benefícios ao público atendido são obrigatórios.',
            'beneficios_publico_atendido.string' => 'Os benefícios ao público atendido devem ser um texto.',
            'beneficios_publico_atendido.max' => 'Os benefícios ao público atendido devem ter no máximo 5000 caracteres.',

            'impactos_tecnologicos_cientificos.required' => 'Os impactos tecnológicos e científicos são obrigatórios.',
            'impactos_tecnologicos_cientificos.string' => 'Os impactos tecnológicos e científicos devem ser um texto.',
            'impactos_tecnologicos_cientificos.max' => 'Os impactos tecnológicos e científicos devem ter no máximo 3000 caracteres.',

            'desafios_encontrados.required' => 'Os desafios encontrados são obrigatórios.',
            'desafios_encontrados.string' => 'Os desafios encontrados devem ser um texto.',
            'desafios_encontrados.max' => 'Os desafios encontrados devem ter no máximo 3000 caracteres.',

            'avaliacao_projeto_executado.required' => 'A avaliação do projeto executado é obrigatória.',
            'avaliacao_projeto_executado.string' => 'A avaliação do projeto executado deve ser um texto.',
            'avaliacao_projeto_executado.max' => 'A avaliação do projeto executado deve ter no máximo 3000 caracteres.',

            'tecnico_cientifico.required' => 'A área técnico-científica é obrigatória.',
            'tecnico_cientifico.string' => 'A área técnico-científica deve ser um texto.',

            'qtd_tecnico_cientifico.required' => 'A quantidade técnico-científica é obrigatória.',
            'qtd_tecnico_cientifico.min' => 'A quantidade técnico-científica deve ser no mínimo 1.',

            'divulgacao.required' => 'A divulgação é obrigatória.',
            'divulgacao.string' => 'A divulgação deve ser um texto.',

            'qtd_divulgacao.required' => 'A quantidade de divulgações é obrigatória.',
            'qtd_divulgacao.min' => 'A quantidade de divulgações deve ser no mínimo 1.',

            'didatico_instrucional.required' => 'A área didático-instrucional é obrigatória.',
            'didatico_instrucional.string' => 'A área didático-instrucional deve ser um texto.',

            'qtd_didatico_instrucional.required' => 'A quantidade didático-instrucional é obrigatória.',
            'qtd_didatico_instrucional.min' => 'A quantidade didático-instrucional deve ser no mínimo 1.',

            'multimidia.required' => 'A área multimídia é obrigatória.',
            'multimidia.string' => 'A área multimídia deve ser um texto.',

            'qtd_multimidia.required' => 'A quantidade multimídia é obrigatória.',
            'qtd_multimidia.min' => 'A quantidade multimídia deve ser no mínimo 1.',

            'artistico_cultural.required' => 'A área artístico-cultural é obrigatória.',
            'artistico_cultural.string' => 'A área artístico-cultural deve ser um texto.',

            'qtd_artistico_cultural.required' => 'A quantidade artístico-cultural é obrigatória.',
            'qtd_artistico_cultural.min' => 'A quantidade artístico-cultural deve ser no mínimo 1.',

            'formulario_indicadores.required' => 'O formulário de indicadores é obrigatório.',
            'formulario_indicadores.string' => 'O formulário de indicadores deve ser um texto.',
            'formulario_indicadores.max' => 'O formulário de indicadores deve ter no máximo 5000 caracteres.',

            'certificacao_adicinonal.required' => 'A certificação adicional é obrigatória.',

            'nome_participante.*.string' => 'O nome do participante deve ser um texto.',
            'nome_participante.*.max' => 'O nome do participante deve ter no máximo 255 caracteres.',

            'carga_horaria_participante.*.min' => 'A carga horária do participante deve ser no mínimo 1.',
        ];
    }
}
