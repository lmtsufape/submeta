@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 2%">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @elseif(session('erro'))
            <div class="alert alert-danger" role="alert">
                {{ session('erro') }}
            </div>
        @endif

        <div class="titulo-menu justify-content-between align-items-center text-center">
            <h4 class="mb-0">Relatório Final PIBEX - {{ $trabalho->titulo }}</h4>
        </div>


        

            <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">

            <div class="container card">
                <br>
                <div class="text-center" style="font: bold">
                    <h5>PARTE 1 - IDENTIFICAÇÃO DO PROJETO</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-4">
                        <label for="processo_sipac"
                               class="col-form-label"> <strong>{{ __('N° do processo SIPAC (Projeto):') }}</strong><span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="processo_sipac" type="text" class="form-control" name="processo_sipac"
                               value="{{ $relatorio->processo_sipac }}" required autocomplete="processo_sipac" autofocus disabled>
                    </div>

                    <div class="col-4">
                        <label for="inicio_projeto"
                            class="col-form-label"> <strong>{{ __('Data de início do projeto:') }}</strong><span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="inicio_projeto" type="date" class="form-control" name="inicio_projeto"
                            value="{{ $relatorio->inicio_projeto }}" required autocomplete="data_inicio" autofocus disabled>
                    </div>

                    <div class="col-4">
                        <label for="conclusao_projeto"
                            class="col-form-label"> <strong>{{ __('Data de conclusão do projeto:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="conclusao_projeto" type="date" class="form-control" name="conclusao_projeto"
                            value="{{ $relatorio->conclusao_projeto }}" required autocomplete="data_conclusao"
                            autofocus disabled>
                    </div>

                    <div class="col-12">
                        <label for="titulo_projeto" class="col-form-label"> <strong>{{ __('Título do projeto:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="titulo_projeto" type="text" class="form-control" name="titulo_projeto"
                            value="{{ $relatorio->titulo_projeto }}" required autocomplete="titulo_projeto" autofocus disabled>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12" style="font: bold">
                        <h5>Coordenador/a do projeto</h5>
                    </div>
                    <div class="col-6">
                        <label for="nome_coordenador" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="nome_coordenador" type="text" class="form-control" name="nome_coordenador"
                            value="{{ $coordenador->nome }}" required autocomplete="nome_coordenador"
                            autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="email_institucional_coordenador"
                            class="col-form-label"> <strong>{{ __('E-mail Institucional:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="email_institucional_coordenador" type="email" class="form-control"
                            name="email_institucional_coordenador"
                            value="{{ $coordenador->email_institucional }}" required
                            autocomplete="email_institucional_coordenador" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="cargo_coordenador" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="cargo_coordenador" class="form-control" name="cargo_coordenador"
                            value="{{ $coordenador->cargo }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="curso_coordenador" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="curso_coordenador" type="text" class="form-control" name="curso_coordenador"
                            value="{{ $coordenador->curso_setor }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="cpf_coordenador" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="cpf" type="text" class="form-control" name="cpf_coordenador"
                            value="{{ $coordenador->cpf }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="telefone_coordenador" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="celular" type="text" class="form-control"
                            name="telefone_coordenador" value="{{ $coordenador->telefone }}" disabled>
                    </div>
                    <div class="col-6">
                        <label for="ch_coordenador" class="col-form-label"> <strong>{{ __('Carga horária de atuação na proposta:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="ch_coordenador" type="number" class="form-control" name="ch_coordenador"
                            value="{{ $coordenador->ch_total_atuacao }}" disabled>
                    </div>
                </div>

                <hr>
                @if($vice_coordenador)
                    <div class="row">
                        <div class="col-12">
                            <h5>Vice-Coordenador/a do projeto (caso houver)</h5>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tem_vice_coord"
                                    name="tem_vice_coord">
                                <label class="form-check-label" for="tem_vice_coord">
                                    Existe Vice-Coordenador
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                        <label for="nome_vice_coord" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                        <input id="nome_vice_coord" type="text" class="form-control vice-coordenador"
                            name="nome_vice_coord" value="{{ $vice_coordenador->nome }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="email_institucional_vice_coord"
                                class="col-form-label"> <strong>{{ __('E-mail institucional:') }}</strong> </label>
                            <input id="email_institucional_vice_coord" type="email"
                                class="form-control vice-coordenador" name="email_institucional_vice_coord"
                                value="{{ $vice_coordenador->email_institucional }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="cargo_vice_coord" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> </label>
                            <input id="cargo_vice_coord" class="form-control vice-coordenador"
                                name="cargo_vice_coord" value="{{ $vice_coordenador->cargo }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="curso_vice_coord" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> </label>
                            <input id="curso_vice_coord" type="text" class="form-control vice-coordenador"
                                name="curso_vice_coord" value="{{ $vice_coordenador->curso_setor }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="cpf_vice_coord" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                            <input id="cpf_vice_coord" type="text" class="form-control vice-coordenador"
                                name="cpf_vice_coord" value="{{ $vice_coordenador->cpf }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="telefone_vice_coord" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                            </label>
                            <input id="celular" type="text" class="form-control vice-coordenador"
                                name="telefone_vice_coord" value="{{ $vice_coordenador->telefone }}" disabled>
                        </div>
                        <div class="col-6">
                            <label for="ch_vice_coord" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                            </label>
                            <input id="ch_vice_coord" type="number" class="form-control vice-coordenador"
                                name="ch_vice_coord" value="{{ $vice_coordenador->ch_total_atuacao }}" disabled>
                        </div>
                    </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-12">
                        <label for="area_tematica_principal"
                            class="col-form-label">
                            <strong>{{ __('Área(s) temática(s) principal(is) do projeto, de acordo com a Política Nacional de Extensão') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <div class="form-check">
                            @foreach($areas_tematicas as $area_tematica)
                                <input class="form-check-input" type="checkbox" name="select_area_tematica[]"
                                    id="area_tematica_{{ $area_tematica->id }}" value="{{ $area_tematica->id }}" disabled
                                    checked>
                                <label class="form-check-label" for="area_tematica_{{ $area_tematica->id }}">
                                    {{ $area_tematica->nome }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="ods" class="col-form-label">
                            <strong>{{ __('Identifique qual(is) Objetivo(s) de Desenvolvimento Sustentáveis (ODS) da Agenda 2030 da ONU, está(ão) presente(s) no projeto') }}</strong>
                            <a href="https://brasil.un.org/pt-br/sdgs"
                            target="_blank"> {{ __('(para maiores esclarecimentos sobre ODS acesse o link)') }} </a>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>
                        <div class="form-check">
                            @foreach($ods as $od)
                                <input class="form-check-input" type="checkbox" name="select_ods[]" id="od_{{ $od->id }}"
                                    value="{{ $od->id }}" disabled checked>
                                <label class="form-check-label" for="od_{{ $od->id }}">
                                    {{ $od->nome }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                </div>

                <br>
            </div>
            
            <hr>

            <div class="container card">
                <br>

                <div class="text-center" style="font: bold">
                    <h5>PARTE 2 - IDENTIFICAÇÃO DA EQUIPE E PARCERIAS</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <h5>Equipe: Integrantes internos à UFAPE (Sem limite de integrantes)</h5>
                    </div>
                </div>
                @foreach($internos as $interno)
                    <div id="integrantesInternos">
                        <div class="row integranteInterno">
                            <div class="col-6">
                                <label for="nome_interno" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span> </label>
                                <input type="text" class="form-control" name="nome_interno[]" value="{{ $interno->nome }}"
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label for="cpf_interno" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span> </label>
                                <input type="text" class="form-control" name="cpf_interno[]" id="cpf_interno"
                                    value="{{ $interno->cpf }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="tipo" class="col-form-label"> <strong>{{ __('Tipo:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span> </label>
                                <input name="tipo[]" class="form-control" value="{{ $interno->tipo }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="tipo_vinculo"
                                    class="col-form-label"> <strong>{{ __('Tipo de vínculo:') }}</strong> <span
                                            style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                                <input name="tipo_vinculo[]" class="form-control" value="{{ $interno->tipo_vinculo }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="curso_interno"
                                    class="col-form-label"> <strong>{{ __('Curso de graduação:') }}</strong> <span
                                            style="color: red; font-weight:bold;">(caso seja um discente)</span> </label>
                                <input type="text" class="form-control" name="curso_interno[]"
                                    value="{{ $interno->curso_graduacao }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="curso_setor"
                                    class="col-form-label"> <strong>{{ __('Curso/Setor de Atuação:') }}</strong> <span
                                            style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                                <input type="text" class="form-control" name="curso_setor[]" value="{{ $interno->curso_setor }}"
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_interno"
                                    class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span></label>
                                <input type="date" class="form-control" name="data_ingresso_interno[]"
                                    value="{{ $interno->ingresso_proposta }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_interno"
                                    class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span></label>
                                <input type="date" class="form-control" name="data_conclusao_interno[]"
                                    value="{{ $interno->conclusao_proposta }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_interno"
                                    class="col-form-label">
                                    <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong> <span
                                            style="color: red; font-weight:bold;">*</span></label>
                                <input type="number" class="form-control" name="carga_horaria_interno[]"
                                    value="{{ $interno->ch_total_atuacao }}" disabled>
                            </div>
                        </div>

                        <br>
                    </div>
                @endforeach

                @if($externos->isNotEmpty())
                    <div class="row">
                        <div class="col-12">
                            <h5>Integrantes externos à UFAPE (Sem limite de integrantes)</h5>
                        </div>
                    </div>
                @endif

                @foreach($externos as $externo)
                    <div id="integrantesExternos">
                        <div class="row integranteExterno">
                            <div class="col-6">
                                <label for="nome_externo"
                                    class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                                <input type="text" class="form-control" name="nome_externo[]" value="{{ $externo->nome }}"
                                    disabled>
                            </div>
                            <div class="col-6">
                                <label for="cpf_externo"
                                    class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                                <input type="text" class="form-control" name="cpf_externo[]" id="cpf_externo"
                                    value="{{ $externo->cpf }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="intituicao_vinculo"
                                    class="col-form-label"> <strong>{{ __('Instituição de vínculo:') }}</strong> </label>
                                <input type="text" class="form-control" name="instituicao_vinculo[]"
                                    value="{{ $externo->instituicao_vinculo }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_externo"
                                    class="col-form-label">
                                    <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong> </label>
                                <input type="number" class="form-control" name="carga_horaria_externo[]"
                                    value="{{ $externo->ch_total_atuacao }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_externo"
                                    class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                                </label>
                                <input type="date" class="form-control" name="data_ingresso_externo[]"
                                    value="{{ $externo->ingresso_proposta }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_externo"
                                    class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                                </label>
                                <input type="date" class="form-control" name="data_conclusao_externo[]"
                                    value="{{ $externo->conclusao_proposta }}" disabled>
                            </div>
                        </div>
                    </div>

                    <hr>
                @endforeach

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="captacao_recursos"
                            class="col-form-label">
                            <strong>{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>

                    @if($relatorio->captacao_recursos == true)
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos"
                                    id="captacao_recursos_sim" value="true" autocomplete="off" checked disabled>
                                <label class="form-check-label" for="captacao_recursos_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos"
                                    id="captacao_recursos_nao" value="false" autocomplete="off" disabled>
                                <label class="form-check-label" for="captacao_recursos_nao">Não</label>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos"
                                    id="captacao_recursos_sim" value="true" autocomplete="off" disabled>
                                <label class="form-check-label" for="captacao_recursos_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos"
                                    id="captacao_recursos_nao" value="false" autocomplete="off" checked disabled>
                                <label class="form-check-label" for="captacao_recursos_nao">Não</label>
                            </div>
                        </div>
                    @endif
                </div>

                <br>
            </div>
            
            <hr>

            <div class="container card">
                <br>

                <div class="text-center" style="font: bold">
                <h5>PARTE 3 - RESULTADOS E OBJETIVOS ALCANÇADOS</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="resumo" class="col-form-label"> <strong>{{ __('1) Resumo:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span></label>
                        <input id="resumo" class="form-control" name="resumo" rows="4" value="{{ $relatorio->resumo }}"
                            disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="objetivos_alcancados"
                            class="col-form-label">
                            <strong>{{ __('2) Em que proporção (%) os objetivos da proposta foram alcançados?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-check-inline d-flex justify-content-between">
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_0" checked disabled>
                                <label class="form-check-label"
                                    for="objetivos_alcancados_0">{{ $relatorio->objetivos_alcancados }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="justificativa_objetivos_alcancados"
                            class="col-form-label">
                            <strong>{{ __('Caso não tenha atingido integralmente (100%) os objetivos propostos, quais deles deixaram de ser alcançados? Justifique.') }}</strong>
                        </label>
                        <input id="justificativa_objetivos_alcancados" type="text" class="form-control"
                            name="justificativa_objetivos_alcancados"
                            value="{{ $relatorio->justificativa_objetivos_alcancados }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="pessoas_beneficiadas"
                            class="col-form-label">
                            <strong>{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                        <input id="pessoas_beneficiadas" type="number" class="form-control"
                            name="pessoas_beneficiadas" value="{{ $relatorio->pessoas_beneficiadas }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="alcance_publico_estimado"
                            class="col-form-label">
                            <strong>{{ __('4) Em que proporção (%) o projeto alcançou o público estimado?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-check-inline d-flex justify-content-between">
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_0" checked disabled>
                                <label class="form-check-label"
                                    for="alcance_publico_estimado_0">{{ $relatorio->alcance_publico_estimado }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="justificativa_publico_estimado"
                            class="col-form-label">
                            <strong>{{ __('Caso não tenha atingido integralmente (100%) a estimativa de público, justifique.') }}</strong>
                        </label>
                        <input id="justificativa_publico_estimado" type="text" class="form-control"
                            name="justificativa_publico_estimado"
                            value="{{ $relatorio->justificativa_publico_estimado }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="beneficios_publico_atendido"
                            class="col-form-label">
                            <strong>{{ __('5) Quais foram os benefícios do projeto para o público atendido?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                        <input id="beneficios_publico_atendido" class="form-control"
                            name="beneficios_publico_atendido" rows="4" value="{{ $relatorio->beneficios_publico_atendido }}"
                            disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="impactos_tecnologicos_cientificos"
                            class="col-form-label">
                            <strong>{{ __('6) Descreva o/s impacto/s tecnológico/s e/ou científico/s (se houve): Tecnologias desenvolvidas, patentes, inovações etc.') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <input id="impactos_tecnologicos_cientificos" class="form-control"
                            name="impactos_tecnologicos_cientificos" rows="4"
                            value="{{ $relatorio->impactos_tecnologicos_cientificos }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="desafios_encontrados"
                            class="col-form-label">
                            <strong>{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <input id="desafios_encontrados" class="form-control" name="desafios_encontrados"
                            rows="4" value="{{ $relatorio->desafios_encontrados }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="avaliacao_projeto_executado"
                            class="col-form-label">
                            <strong>{{ __('8) Qual sua avaliação do projeto executado e qual sua expectativa quanto a continuidade dele?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <input id="avaliacao_projeto_executado" class="form-control"
                            name="avaliacao_projeto_executado" rows="4" value="{{ $relatorio->avaliacao_projeto_executado }}"
                            disabled>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="produtos_extensao_gerados"
                            class="col-form-label">
                            <strong>{{ __('9) Produtos de extensão gerados de acordo com a Política de Extensão da UFAPE (em caso de dúvidas consulte a resolução de Extensão da UFAPE') }}</strong>
                            <a href="http://ufape.edu.br/sites/default/files/resolucoes/CONSEPE_RESOLUCAO_n_006_2022.pdf"
                            target="_blank">(Acesse aqui)</a>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>
                    </div>

                    <div class="col-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" class="col-6">Modalidade</th>
                                <th scope="col" class="col-3">Especificar</th>
                                <th scope="col" class="col-3">Quantidade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td rowspan="2">
                                    <strong> Produto técnico-científico </strong><br>
                                    Publicações em revistas, anais, resumos, livros, e-books, capítulo de
                                    livro/e-book, apostilas, manuais, fascículos, guias, folders, boletins,
                                    monografias, kits e relatórios técnicos, traduções, dentre outros.
                                </td>
                                <td><input type="text" name="tecnico_cientifico" id="tecnico_cientifico"
                                        class="form-control" value="{{ $produtos_extensao_gerados->tecnico_cientifico }}"
                                        disabled></td>
                                <td><input type="number" name="qtd_tecnico_cientifico" id="qtd_tecnico_cientifico"
                                        class="form-control" value="{{ $produtos_extensao_gerados->qtd_tecnico_cientifico }}" disabled></td>
                                </tr>
                                <tr>
                                    <td colspan=" 2">
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <strong> Produto de divulgação </strong><br>
                                    Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e
                                    televisão, vídeos, podcasts, ensaios, dentre outros.
                                </td>
                                <td><input type="text" name="divulgacao" id="divulgacao" class="form-control"
                                        value="{{ $produtos_extensao_gerados->divulgacao }}" disabled></td>
                                <td><input type="number" name="qtd_divulgacao" id="qtd_divulgacao"
                                        class="form-control" value="{{ $produtos_extensao_gerados->qtd_divulgacao }}"
                                        disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <strong> Produto didático ou instrucional </strong><br>
                                    Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd’s e kits didáticos,
                                    podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="didatico_instrucional" id="didatico_instrucional"
                                        class="form-control" value="{{ $produtos_extensao_gerados->didatico_instrucional }}"
                                        disabled></td>
                                <td><input type="number" name="qtd_didatico_instrucional"
                                        id="qtd_didatico_instrucional" class="form-control"
                                        value="{{ $produtos_extensao_gerados->qtd_didatico_instrucional }}" disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <strong> Produto multimídia </strong><br>
                                    Filmes, homepages, apps, podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="multimidia" id="multimidia" class="form-control"
                                        value="{{ $produtos_extensao_gerados->multimidia }}" disabled></td>
                                <td><input type="number" name="qtd_multimidia" id="qtd_multimidia"
                                        class="form-control" value="{{ $produtos_extensao_gerados->qtd_multimidia }}"
                                        disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td rowspan="2">
                                    <strong> Produto artístico-cultural </strong><br>
                                    Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre
                                    outros.
                                </td>
                                <td><input type="text" name="artistico_cultural" id="artistico_cultural"
                                        class="form-control" value="{{ $produtos_extensao_gerados->artistico_cultural }}"
                                        disabled></td>
                                <td><input type="number" name="qtd_artistico_cultural" id="qtd_artistico_cultural"
                                        class="form-control" value="{{ $produtos_extensao_gerados->qtd_artistico_cultural }}"
                                        disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>
            </div>

            <hr>
            
            <div class="container card"> 
                <br>

                <div class="text-center" style="font: bold">
                    <h5>PARTE 4 - ESTATÍSTICAS DA AÇÃO (INDICADORES)</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="formulario_indicadores"
                            class="col-form-label">
                            <strong>{{ __('Prezado/a Coordenador/a, favor preencher o formulário eletrônico com os indicadores do projeto, através do link: ') }}</strong>
                            <a href="https://forms.gle/Qfa8YEAjBdmC2aW2A"
                            target="_blank">https://forms.gle/Qfa8YEAjBdmC2aW2A</a>
                        </label>

                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label" for="formulario_indicadores">Confirmo que preenchi o
                                    formulário de indicadores <span style="color: red; font-weight:bold;">*</span> </label>
                            </div>
                        </div>

                        @if($relatorio->formulario_indicadores == true)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores"
                                    id="formulario_indicadores_sim" value="true" checked disabled>
                                <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores"
                                    id="formulario_indicadores_nao" value="false" disabled>
                                <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                            </div>
                        @else
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores"
                                    id="formulario_indicadores_sim" value="true" disabled>
                                <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores"
                                    id="formulario_indicadores_nao" value="false" checked disabled>
                                <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                            </div>
                        @endif
                    </div>
                </div>

                <br>
            </div>
        
            <hr>

            <div class="container card">
                <br>
                
                <div class="text-center" style="font: bold">
                    <h5>
                        PARTE 5 - LISTA DE PARTICIPANTES BENEFICIADOS A SEREM CERTIFICADOS
                    </h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label class="col-form-label"
                            for="certificacao_adicinonal">
                            <strong>{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>

                    @if($relatorio->certificacao_adicinonal == true)
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                    id="certificacao_adicinonal_sim" value="true" checked disabled>
                                <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                    id="certificacao_adicinonal_nao" value="false" disabled>
                                <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                    id="certificacao_adicinonal_sim" value="true" disabled>
                                <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                    id="certificacao_adicinonal_nao" value="false" checked disabled>
                                <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                            </div>
                        </div>
                    @endif
                </div>

                @if($participantes->isNotEmpty())
                    <hr>

                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h5 class="m-0 d-inline">Participantes </h5>
                        </div>
                    </div>
                @endif

                @foreach($participantes as $participante)
                    <div id="participantes">
                        <div class="row participante">
                            <div class="col-6">
                                <label for="nome_participante"
                                    class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                                <input type="text" class="form-control" name="nome_participante[]"
                                    value="{{ $participante->nome }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="cpf_participante"
                                    class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                                <input type="text" class="form-control" name="cpf_participante[]" id="cpf_participante"
                                    value="{{ $participante->cpf }}" disabled>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_participante"
                                    class="col-form-label"> <strong>{{ __('Carga horária:') }}</strong>
                                </label>
                                <input type="number" class="form-control" name="carga_horaria_participante[]"
                                    value="{{ $participante->carga_horaria }}" disabled>
                            </div>
                        </div>
                    </div>
                @endforeach

                <br>
            </div>

            <hr>

            <div class="container card">
                <br>

                <div class="text-left" style="font: bold">
                    <h5>
                        PARECER
                    </h5>
                </div>

                <br>

                <div class="text-right">
                    <form id="formRelatFinal" method="post" action="{{ route('relatorioFinalPibex.parecer') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="relatorio_id" value="{{ $relatorio->id }}">

                        <div class="modal-footer">
                            <a class="btn btn-secondary" href="{{ route('relatorioFinalPibex.gerarPDF', ['relatorio_id' => $relatorio->id]) }}" target="_blank"> Imprimir Relatório </a>
                            <button name="parecer" type="submit" class="btn btn-danger" value="devolver">Devolver</button>
                            <button name="parecer" type="submit" class="btn btn-success" value="aprovar">Aprovar</button>
                        </div>
                    </form>
                </div>

                <br>
            </div>
    </div>
@endsection
