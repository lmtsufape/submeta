@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 2%">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="titulo-menu justify-content-between align-items-center text-center">
            <h4 class="mb-0">Relatório Final PIBEX - {{ $trabalho->titulo }}</h4>
        </div>


        <form id="formRelatFinal" method="post" action="{{  route('relatorioFinalPibex.salvar') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">

            <div class="container card">
                <br>
                <div class="text-center" style="font: bold">
                    <h5>PARTE 1 - IDENTIFICAÇÃO DO PROJETO</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-6">
                        <label for="inicio_projeto"
                            class="col-form-label"> <strong>{{ __('Data de início do projeto:') }}</strong><span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="inicio_projeto" type="date" class="form-control" name="inicio_projeto"
                            value="{{ old('inicio_projeto') }}" required autocomplete="data_inicio" autofocus>
                        <!-- @error('inicio_projeto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->
                    </div>

                    <div class="col-6">
                        <label for="conclusao_projeto"
                            class="col-form-label"> <strong>{{ __('Data de conclusão do projeto:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="conclusao_projeto" type="date" class="form-control" name="conclusao_projeto"
                            value="{{ old('conclusao_projeto') }}" required autocomplete="data_conclusao"
                            autofocus>
                        <!--@error('conclusao_projeto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->
                    </div>

                    <div class="col-12">
                        <label for="titulo_projeto" class="col-form-label"> <strong>{{ __('Título do projeto:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="titulo_projeto" type="text" class="form-control" name="titulo_projeto"
                            value="{{ old('titulo_projeto') }}" required autocomplete="titulo_projeto" autofocus>
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
                            value="{{ old('nome_coordenador') }}" required autocomplete="nome_coordenador"
                            autofocus>
                    </div>
                    <div class="col-6">
                        <label for="email_institucional_coordenador"
                            class="col-form-label"> <strong>{{ __('E-mail Institucional:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="email_institucional_coordenador" type="email" class="form-control"
                            name="email_institucional_coordenador"
                            value="{{ old('email_institucional_coordenador') }}" required
                            autocomplete="email_institucional_coordenador" autofocus>
                    </div>
                    <div class="col-6">
                        <label for="cargo_coordenador" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <select id="cargo_coordenador" class="form-control" name="cargo_coordenador" required
                                autocomplete="cargo_coordenador" autofocus>
                            <option value="">Selecione uma opcão</option>
                            <option value="Docente">Docente</option>
                            <option value="Técnico/a administrativo/a">Técnico/a administrativo/a</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="curso_coordenador" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="curso_coordenador" type="text" class="form-control" name="curso_coordenador"
                            value="{{ old('curso_coordenador') }}" required autocomplete="curso_coordenador"
                            autofocus>
                    </div>
                    <div class="col-6">
                        <label for="cpf_coordenador" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="cpf" type="text" class="form-control" name="cpf_coordenador"
                            value="{{ old('cpf_coordenador') }}" required autocomplete="cpf_coordenador"
                            autofocus>
                    </div>
                    <div class="col-6">
                        <label for="telefone_coordenador" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="celular" type="text" class="form-control"
                            name="telefone_coordenador" value="{{ old('telefone_coordenador') }}" required
                            autocomplete="telefone_coordenador" autofocus>
                    </div>
                    <div class="col-6">
                        <label for="ch_coordenador" class="col-form-label"> <strong>{{ __('Carga horaria total de atuação na proposta:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="ch_coordenador" type="number" class="form-control" name="ch_coordenador"
                            value="{{ old('ch_coordenador') }}" required autocomplete="ch_coordenador" autofocus>
                    </div>
                </div>

                <hr>

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
                            name="nome_vice_coord" value="{{ old('nome_vice_coord') }}"
                            autocomplete="nome_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="email_institucional_vice_coord"
                            class="col-form-label"> <strong>{{ __('E-mail institucional:') }}</strong> </label>
                        <input id="email_institucional_vice_coord" type="email"
                            class="form-control vice-coordenador" name="email_institucional_vice_coord"
                            value="{{ old('email_institucional_vice_coord') }}"
                            autocomplete="email_institucional_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="cargo_vice_coord" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> </label>
                        <select id="cargo_vice_coord" class="form-control vice-coordenador"
                            name="cargo_vice_coord" autocomplete="cargo_vice_coord" autofocus disabled>
                            <option value="">Selecione uma opcão</option>
                            <option value="Docente">Docente</option>
                            <option value="Técnico/a administrativo/a">Técnico/a administrativo/a</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="curso_vice_coord" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> </label>
                        <input id="curso_vice_coord" type="text" class="form-control vice-coordenador"
                            name="curso_vice_coord" value="{{ old('curso_vice_coord') }}"
                            autocomplete="curso_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="cpf_vice_coord" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                        <input id="cpf_vice_coord" type="text" class="form-control vice-coordenador"
                            name="cpf_vice_coord" value="{{ old('cpf_vice_coord') }}"
                            autocomplete="cpf_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="telefone_vice_coord" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                        </label>
                        <input id="celular" type="text" class="form-control vice-coordenador"
                            name="telefone_vice_coord" value="{{ old('telefone_vice_coord') }}"
                            autocomplete="telefone_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="ch_vice_coord" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                        </label>
                        <input id="ch_vice_coord" type="number" class="form-control vice-coordenador"
                            name="ch_vice_coord" value="{{ old('ch_vice_coord') }}" autocomplete="ch_vice_coord"
                            autofocus disabled>
                    </div>
                </div>

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
                                    id="area_tematica_{{ $area_tematica->id }}" value="{{ $area_tematica->id }}">
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
                                    value="{{ $od->id }}">
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
                <div id="integrantesInternos">
                    <div class="row integranteInterno">
                        <div class="col-6">
                            <label for="nome_interno" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span> </label>
                            <input type="text" class="form-control" name="nome_interno[]" required
                                autocomplete="nome_interno" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="cpf_interno" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span> </label>
                            <input type="text" class="form-control" name="cpf_interno[]" id="cpf_interno" required
                                autocomplete="cpf_interno" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="tipo" class="col-form-label"> <strong>{{ __('Tipo:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span> </label>
                            <select name="tipo[]" class="form-control" required>
                                <option value="">Selecione...</option>
                                <option value="Discente">Discente</option>
                                <option value="Servidor">Servidor</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="tipo_vinculo"
                                class="col-form-label"> <strong>{{ __('Tipo de vínculo:') }}</strong> <span
                                        style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                            <select name="tipo_vinculo[]" class="form-control">
                                <option value="">Selecione...</option>
                                <option value="Docente">Docente</option>
                                <option value="Substituto/a">Substituto/a</option>
                                <option value="Técnico/a Administrativo/a">Técnico/a Administrativo/a</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="curso_interno"
                                class="col-form-label"> <strong>{{ __('Curso de graduação:') }}</strong> <span
                                        style="color: red; font-weight:bold;">(caso seja um discente)</span> </label>
                            <input type="text" class="form-control" name="curso_interno[]"
                                autocomplete="curso_interno" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="curso_setor"
                                class="col-form-label"> <strong>{{ __('Curso/Setor de Atuação:') }}</strong> <span
                                        style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                            <input type="text" class="form-control" name="curso_setor[]" autocomplete="curso_setor"
                                autofocus>
                        </div>
                        <div class="col-6">
                            <label for="data_ingresso_interno"
                                class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span></label>
                            <input type="date" class="form-control" name="data_ingresso_interno[]" required
                                autocomplete="data_ingresso_interno" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="data_conclusao_interno"
                                class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span></label>
                            <input type="date" class="form-control" name="data_conclusao_interno[]" required
                                autocomplete="data_conclusao_interno" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="carga_horaria_interno"
                                class="col-form-label">
                                <strong>{{ __('Carga corária total de atuação na proposta:') }}</strong> <span
                                        style="color: red; font-weight:bold;">*</span></label>
                            <input type="number" class="form-control" name="carga_horaria_interno[]" required
                                autocomplete="carga_horaria_interno" autofocus>
                        </div>

                        <div class="col-12 mt-3 text-right">
                            <button type="button" class="btn btn-danger btnRemoverIntegrante">Remover integrante interno</button>
                        </div>
                    </div>
                </div>

                <div class="form-group row text-right">
                    <div class="col-4 text-left">
                        <button type="button" id="btnAddIntegranteInterno" class="btn btn-primary mt-3">
                            Adicionar outro integrante interno
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h5>Integrantes externos à UFAPE (Sem limite de integrantes)</h5>
                    </div>
                </div>
                <div id="integrantesExternos">
                    <div class="row integranteExterno">
                        <div class="col-6">
                            <label for="nome_externo"
                                class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                            <input type="text" class="form-control" name="nome_externo[]"
                                autocomplete="nome_externo" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="cpf_externo"
                                class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                            <input type="text" class="form-control" name="cpf_externo[]" id="cpf_externo"
                                autocomplete="cpf_externo" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="intituicao_vinculo"
                                class="col-form-label"> <strong>{{ __('Instituição de vínculo:') }}</strong> </label>
                            <input type="text" class="form-control" name="instituicao_vinculo[]"
                                autocomplete="intituicao_vinculo" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="carga_horaria_externo"
                                class="col-form-label">
                                <strong>{{ __('Carga corária total de atuação na proposta:') }}</strong> </label>
                            <input type="number" class="form-control" name="carga_horaria_externo[]"
                                autocomplete="carga_horaria_externo" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="data_ingresso_externo"
                                class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                            </label>
                            <input type="date" class="form-control" name="data_ingresso_externo[]"
                                autocomplete="data_ingresso_externo" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="data_conclusao_externo"
                                class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                            </label>
                            <input type="date" class="form-control" name="data_conclusao_externo[]"
                                autocomplete="data_conclusao_externo" autofocus>
                        </div>
                        <div class="col-12 mt-3 text-right">
                            <button type="button" class="btn btn-danger btnRemoverExterno">Remover integrante externo</button>
                        </div>
                    </div>
                </div>

                <div class="form-group row text-right">
                    <div class="col-4 text-left">
                        <button type="button" id="btnAddIntegranteExterno" class="btn btn-primary mt-3">
                            Adicionar outro integrante externo
                        </button>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <label for="captacao_recursos"
                            class="col-form-label">
                            <strong>{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="captacao_recursos"
                                id="captacao_recursos_sim" value="true" autocomplete="off" checked>
                            <label class="form-check-label" for="captacao_recursos_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="captacao_recursos"
                                id="captacao_recursos_nao" value="false" autocomplete="off">
                            <label class="form-check-label" for="captacao_recursos_nao">Não</label>
                        </div>
                    </div>
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
                        <label for="resumo" class="col-form-label"> <strong>{{ __('1) Resumo:') }} </strong> <span style="color: red; font-weight:bold;">* (máximo 3000 caracteres)</span></label>
                        <textarea id="resumo" class="form-control" name="resumo" rows="4" maxlength="3000" required
                                autocomplete="resumo"></textarea>
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
                                    id="objetivos_alcancados_0" value="0">
                                <label class="form-check-label" for="objetivos_alcancados_0">0</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_10" value="10">
                                <label class="form-check-label" for="objetivos_alcancados_10">10</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_20" value="20">
                                <label class="form-check-label" for="objetivos_alcancados_20">20</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_30" value="30">
                                <label class="form-check-label" for="objetivos_alcancados_30">30</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_40" value="40">
                                <label class="form-check-label" for="objetivos_alcancados_40">40</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_50" value="50">
                                <label class="form-check-label" for="objetivos_alcancados_50">50</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_60" value="60">
                                <label class="form-check-label" for="objetivos_alcancados_60">60</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_70" value="70">
                                <label class="form-check-label" for="objetivos_alcancados_70">70</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_80" value="80">
                                <label class="form-check-label" for="objetivos_alcancados_80">80</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_90" value="90">
                                <label class="form-check-label" for="objetivos_alcancados_90">90</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                    id="objetivos_alcancados_100" value="100">
                                <label class="form-check-label" for="objetivos_alcancados_100">100</label>
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
                            value="{{ old('justificativa_objetivos_alcancados') }}"
                            autocomplete="justificativa_objetivos_alcancados" autofocus>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="pessoas_beneficiadas"
                            class="col-form-label">
                            <strong>{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                        <input id="pessoas_beneficiadas" type="number" class="form-control"
                            name="pessoas_beneficiadas" required autocomplete="pessoas_beneficiadas">
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
                                    id="alcance_publico_estimado_0" value="0">
                                <label class="form-check-label" for="alcance_publico_estimado_0">0</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_10" value="10">
                                <label class="form-check-label" for="alcance_publico_estimado_10">10</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_20" value="20">
                                <label class="form-check-label" for="alcance_publico_estimado_20">20</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_30" value="30">
                                <label class="form-check-label" for="alcance_publico_estimado_30">30</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_40" value="40">
                                <label class="form-check-label" for="alcance_publico_estimado_40">40</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_50" value="50">
                                <label class="form-check-label" for="alcance_publico_estimado_50">50</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_60" value="60">
                                <label class="form-check-label" for="alcance_publico_estimado_60">60</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_70" value="70">
                                <label class="form-check-label" for="alcance_publico_estimado_70">70</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_80" value="80">
                                <label class="form-check-label" for="alcance_publico_estimado_80">80</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_90" value="90">
                                <label class="form-check-label" for="alcance_publico_estimado_90">90</label>
                            </div>
                            <div class="w-10">
                                <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                    id="alcance_publico_estimado_100" value="100">
                                <label class="form-check-label" for="alcance_publico_estimado_100">100</label>
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
                            value="{{ old('justificativa_publico_estimado') }}"
                            autocomplete="justificativa_publico_estimado" autofocus>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="beneficios_publico_atendido"
                            class="col-form-label">
                            <strong>{{ __('5) Quais foram os benefícios do projeto para o público atendido?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                        <textarea id="beneficios_publico_atendido" class="form-control"
                                name="beneficios_publico_atendido" rows="4" required
                                autocomplete="beneficios_publico_atendido"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="impactos_tecnologicos_cientificos"
                            class="col-form-label">
                            <strong>{{ __('6) Descreva o/s impacto/s tecnológico/s e/ou científico/s (se houve): Tecnologias desenvolvidas, patentes, inovações etc.') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <textarea id="impactos_tecnologicos_cientificos" class="form-control"
                                name="impactos_tecnologicos_cientificos" rows="4" required
                                autocomplete="impactos_tecnologicos_cientificos"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="desafios_encontrados"
                            class="col-form-label">
                            <strong>{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <textarea id="desafios_encontrados" class="form-control" name="desafios_encontrados"
                                rows="4" required autocomplete="desafios_encontrados"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="avaliacao_projeto_executado"
                            class="col-form-label">
                            <strong>{{ __('8) Qual sua avaliação do projeto executado e qual sua expectativa quanto a continuidade dele?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <textarea id="avaliacao_projeto_executado" class="form-control"
                                name="avaliacao_projeto_executado" rows="4" required
                                autocomplete="avaliacao_projeto_executado"></textarea>
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
                                <th scope="col" class="col-3">Especificar o tipo</th>
                                <th scope="col" class="col-3">Quantidade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <strong> Produto técnico-científico </strong><br>
                                    Publicações em revistas, anais, resumos, livros, e-books, capítulo de
                                    livro/e-book, apostilas, manuais, fascículos, guias, folders, boletins,
                                    monografias, kits e relatórios técnicos, traduções, dentre outros.
                                </td>
                                <td><input type="text" name="tecnico_cientifico" id="tecnico_cientifico"
                                        class="form-control" required></td>
                                <td><input type="number" name="qtd_tecnico_cientifico" id="qtd_tecnico_cientifico"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto de divulgação </strong><br>
                                    Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e
                                    televisão, vídeos, podcasts, ensaios, dentre outros.
                                </td>
                                <td><input type="text" name="divulgacao" id="divulgacao" class="form-control" required></td>
                                <td><input type="number" name="qtd_divulgacao" id="qtd_divulgacao"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto didático ou instrucional </strong><br>
                                    Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd’s e kits didáticos,
                                    podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="didatico_instrucional" id="didatico_instrucional"
                                        class="form-control" required></td>
                                <td><input type="number" name="qtd_didatico_instrucional"
                                        id="qtd_didatico_instrucional" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto multimídia </strong><br>
                                    Filmes, homepages, apps, podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="multimidia" id="multimidia" class="form-control" required></td>
                                <td><input type="number" name="qtd_multimidia" id="qtd_multimidia"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto artístico-cultural </strong><br>
                                    Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre
                                    outros.
                                </td>
                                <td><input type="text" name="artistico_cultural" id="artistico_cultural"
                                        class="form-control" required></td>
                                <td><input type="number" name="qtd_artistico_cultural" id="qtd_artistico_cultural"
                                        class="form-control" required></td>
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
                            <a href="https://forms.gle/Qfa8YEAjBdmC2aW2A" target="_blank">https://forms.gle/Qfa8YEAjBdmC2aW2A</a>
                        </label>

                        <div class="row">
                            <div class="col-12">
                                <label class="col-form-label" for="formulario_indicadores">Confirmo que preenchi o
                                    formulário de indicadores <span style="color: red; font-weight:bold;">*</span> </label>
                            </div>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="formulario_indicadores"
                                id="formulario_indicadores_sim" value="true" >
                            <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="formulario_indicadores"
                                id="formulario_indicadores_nao" value="false">
                            <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                        </div>
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
                    <!-- Campo Certificação de Atividade Envolvendo o Público Beneficiado -->
                    <div class="col-12">
                        <label class="col-form-label"
                            for="certificacao_adicinonal">
                            <strong>{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                id="certificacao_adicinonal_sim" value="true">
                            <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                id="certificacao_adicinonal_nao" value="false">
                            <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row align-items-center">
                    <div class="col-auto">
                        <h5 class="m-0 d-inline">Participantes </h5><span style="color: red; font-weight: bold;">(caso tenha preenchido "sim" acima)</span>
                    </div>
                </div>

                <br>

                <div id="participantes">
                    <div class="row participante">
                        <div class="col-6">
                            <label for="nome_participante"
                                class="col-form-label"> <strong>{{ __('Nome do Participante:') }}</strong> </label>
                            <input type="text" class="form-control" name="nome_participante[]"
                                autocomplete="nome_participante" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="cpf_participante"
                                class="col-form-label"> <strong>{{ __('CPF do Participante:') }}</strong> </label>
                            <input type="text" class="form-control" name="cpf_participante[]" id="cpf_participante"
                                autocomplete="cpf_participante" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="carga_horaria_participante"
                                class="col-form-label"> <strong>{{ __('Carga Horária do Participante:') }}</strong>
                            </label>
                            <input type="number" class="form-control" name="carga_horaria_participante[]"
                                autocomplete="carga_horaria_participante" autofocus>
                        </div>
                        <div class="col-12 mt-3 text-right">
                            <button type="button" class="btn btn-danger btnRemoverParticipante">Remover participante</button>
                        </div>
                    </div>
                </div>

                <div>

                </div>

                <div class="form-group row text-right">
                    <div class="col-3 text-left">
                        <button type="button" id="btnAddParticipante" class="btn btn-primary btn-block mt-3">
                            Adicionar outro participante
                        </button>
                    </div>
                </div>

                <br>
            </div>

            <hr>

            <div class="container card">
                <br>

                <div class="text-center" style="font: bold">
                    <h5>ANEXOS</h5>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">
                            {{ __('O/A coordenador/a deverá também anexar em formato PDF os itens descritos abaixo:') }} <span style="color: red; font-weight: bold;">(em um único arquivo .pdf)</span> <span style="color: red; font-weight:bold">*</span><br>
                        </label>

                        <label for="anexoProjeto" class="col-form-label font-tam text-justify">
                            {{ __('I. Atas de frequências mensais do/a bolsista;') }} <br>
                            {{ __('II. Formulário de prestação de contas;') }} <br>
                            {{ __('III. Certificado/s de apresentação e/ou publicação dos resultados parciais e/ou finais em Eventos de Extensão.') }} <br>
                        </label>
                        <input type="file" class="input-group-text" name="anexo_relatorio" accept="application/pdf" required/>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container card">
                <br>

                <div class="text-left" style="font: bold">
                    <h5>
                        FINALIZAR
                    </h5>
                </div>

                <br>

                <div class="form-group row text-right">
                    <div class="col-6 text-left">
                        <h6 class="card-title mb-0" style="color:red">* Campos obrigatórios</h6>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-success">Enviar relatório</button>
                    </div>
                </div>

                <br>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function ($) {
            $('#cpf, #cpf_vice_coord, #cpf_interno, #cpf_externo, #cpf_participante').mask('000.000.000-00');
            var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
            $('#celular').mask(SPMaskBehavior, spOptions);
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('btnAddIntegranteInterno').addEventListener('click', function () {
                var integranteInternoClone = document.querySelector('.integranteInterno').cloneNode(true);

                var camposClone = integranteInternoClone.querySelectorAll('input, select, textarea');
                camposClone.forEach(function (campo) {
                    campo.value = '';
                });
                var integrantesInternosDiv = document.getElementById('integrantesInternos');
                integrantesInternosDiv.appendChild(integranteInternoClone);
            });


            document.getElementById('btnAddIntegranteExterno').addEventListener('click', function () {
                var integranteExternoClone = document.querySelector('.integranteExterno').cloneNode(true);

                var camposClone = integranteExternoClone.querySelectorAll('input, select, textarea');
                camposClone.forEach(function (campo) {
                    campo.value = '';
                });
                var integrantesExternosDiv = document.getElementById('integrantesExternos');
                integrantesExternosDiv.appendChild(integranteExternoClone);
            });


            document.getElementById('btnAddParticipante').addEventListener('click', function () {
                var participanteClone = document.querySelector('.participante').cloneNode(true);

                var camposClone = participanteClone.querySelectorAll('input, select, textarea');
                camposClone.forEach(function (campo) {
                    campo.value = '';
                });
                var participantesDiv = document.getElementById('participantes');
                participantesDiv.appendChild(participanteClone);
            });


            $(document).on('click', '.btnRemoverIntegrante', function () {
                var integrantes = $('.integranteInterno');
                if (integrantes.length > 1) {
                    var confirmacao = confirm('Tem certeza que deseja remover este integrante interno?');
                    if (confirmacao) {
                        $(this).closest('.integranteInterno').remove();
                    }
                } else {
                    alert('O primeiro integrante interno não pode ser removido.');
                }
            });

            $(document).on('click', '.btnRemoverExterno', function () {
                var externos = $('.integranteExterno');
                if (externos.length > 1) {
                    var confirmacao = confirm('Tem certeza que deseja remover este integrante externo?');
                    if (confirmacao) {
                        $(this).closest('.integranteExterno').remove();
                    }
                } else {
                    alert('O primeiro integrante externo não pode ser removido.');
                }
            });

            $(document).on('click', '.btnRemoverParticipante', function () {
                var participantes = $('.participante');
                if (participantes.length > 1) {
                    var confirmacao = confirm('Tem certeza que deseja remover este participante?');
                    if (confirmacao) {
                        $(this).closest('.participante').remove();
                    }
                } else {
                    alert('O primeiro participante não pode ser removido.');
                }
            });

            const checkbox = document.querySelector('#tem_vice_coord');
            const inputsViceCoord = document.querySelectorAll('.vice-coordenador');

            checkbox.addEventListener('change', function () {
                inputsViceCoord.forEach(input => {
                    input.disabled = !checkbox.checked;
                });

                if (!checkbox.checked) {
                    inputsViceCoord.forEach(input => {
                        input.value = '';
                    });
                }
            });
        });
    </script>
@endsection
