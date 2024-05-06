@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @endif

        <div class="row justify-content-center titulo-menu mb-0">
            <h4>Relatório Final PIBEX</h4>
        </div>

        <form id="formRelatFinal" method="post" action="{{  route('relatorioFinalPibex.salvar') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">

            <div class="modal-body">
                <div class="col-12">
                    <hr>

                    <div class="text-center" style="font: bold">
                        <h5>PARTE 1 - IDENTIFICAÇÃO DO PROJETO</h5>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="inicio_projeto" class="col-form-label">{{ __('Data de início do projeto:') }}</label>
                            <input id="inicio_projeto" type="date" class="form-control" name="inicio_projeto" value="{{ old('inicio_projeto') }}" required autocomplete="data_inicio" autofocus>
                        </div>

                        <div class="col-6">
                            <label for="conclusao_projeto" class="col-form-label">{{ __('Data de conclusão do projeto:') }}</label>
                            <input id="conclusao_projeto" type="date" class="form-control" name="conclusao_projeto" value="{{ old('conclusao_projeto') }}" required autocomplete="data_conclusao" autofocus>
                        </div>

                        <div class="col-12">
                            <label for="titulo_projeto" class="col-form-label">{{ __('Título do projeto:') }}</label>
                            <input id="titulo_projeto" type="text" class="form-control" name="titulo_projeto" value="{{ old('titulo_projeto') }}" required autocomplete="titulo_projeto" autofocus>
                        </div>
                    </div>

                    <hr>

                    <!-- Campos do Coordenador -->
                    <div class="row">
                        <div class="col-12" style="font: bold">
                            <h5>Coordenador/a do projeto</h5>
                        </div>
                        <div class="col-6">
                            <label for="nome_coordenador" class="col-form-label">{{ __('Nome:') }}</label>
                            <input id="nome_coordenador" type="text" class="form-control" name="nome_coordenador" value="{{ old('nome_coordenador') }}" required autocomplete="nome_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="email_institucional_coordenador" class="col-form-label">{{ __('E-mail Institucional:') }}</label>
                            <input id="email_institucional_coordenador" type="email" class="form-control" name="email_institucional_coordenador" value="{{ old('email_institucional_coordenador') }}" required autocomplete="email_institucional_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="cargo_coordenador" class="col-form-label">{{ __('Cargo:') }}</label>
                            <input id="cargo_coordenador" type="text" class="form-control" name="cargo_coordenador" value="{{ old('cargo_coordenador') }}" required autocomplete="cargo_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="curso_coordenador" class="col-form-label">{{ __('Curso:') }}</label>
                            <input id="curso_coordenador" type="text" class="form-control" name="curso_coordenador" value="{{ old('curso_coordenador') }}" required autocomplete="curso_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="cpf_coordenador" class="col-form-label">{{ __('CPF:') }}</label>
                            <input id="cpf_coordenador" type="text" class="form-control" name="cpf_coordenador" value="{{ old('cpf_coordenador') }}" required autocomplete="cpf_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="telefone_coordenador" class="col-form-label">{{ __('Telefone:') }}</label>
                            <input id="telefone_coordenador" type="text" class="form-control" name="telefone_coordenador" value="{{ old('telefone_coordenador') }}" required autocomplete="telefone_coordenador" autofocus>
                        </div>
                        <div class="col-6">
                            <label for="ch_coordenador" class="col-form-label">{{ __('Carga Horária:') }}</label>
                            <input id="ch_coordenador" type="text" class="form-control" name="ch_coordenador" value="{{ old('ch_coordenador') }}" required autocomplete="ch_coordenador" autofocus>
                        </div>
                    </div>

                    <hr>

                    <!-- Campos do Vice-Coordenador -->
                    <div class="row">
                        <div class="col-12">
                            <h5>Vice-Coordenador/a do projeto (caso houver)</h5>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tem_vice_coord" name="tem_vice_coord">
                                <label class="form-check-label" for="tem_vice_coord">
                                    Existe Vice-Coordenador
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="nome_vice_coord" class="col-form-label">{{ __('Nome:') }}</label>
                            <input id="nome_vice_coord" type="text" class="form-control vice-coordenador" name="nome_vice_coord" value="{{ old('nome_vice_coord') }}" autocomplete="nome_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="email_institucional_vice_coord" class="col-form-label">{{ __('E-mail:') }}</label>
                            <input id="email_institucional_vice_coord" type="email" class="form-control vice-coordenador" name="email_institucional_vice_coord" value="{{ old('email_institucional_vice_coord') }}" autocomplete="email_institucional_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="cargo_vice_coord" class="col-form-label">{{ __('Cargo:') }}</label>
                            <input id="cargo_vice_coord" type="text" class="form-control vice-coordenador" name="cargo_vice_coord" value="{{ old('cargo_vice_coord') }}" autocomplete="cargo_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="curso_vice_coord" class="col-form-label">{{ __('Curso:') }}</label>
                            <input id="curso_vice_coord" type="text" class="form-control vice-coordenador" name="curso_vice_coord" value="{{ old('curso_vice_coord') }}" autocomplete="curso_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="cpf_vice_coord" class="col-form-label">{{ __('CPF:') }}</label>
                            <input id="cpf_vice_coord" type="text" class="form-control vice-coordenador" name="cpf_vice_coord" value="{{ old('cpf_vice_coord') }}" autocomplete="cpf_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="telefone_vice_coord" class="col-form-label">{{ __('Telefone:') }}</label>
                            <input id="telefone_vice_coord" type="text" class="form-control vice-coordenador" name="telefone_vice_coord" value="{{ old('telefone_vice_coord') }}" autocomplete="telefone_vice_coord" autofocus disabled>
                        </div>
                        <div class="col-6">
                            <label for="ch_vice_coord" class="col-form-label">{{ __('Carga Horária:') }}</label>
                            <input id="ch_vice_coord" type="text" class="form-control vice-coordenador" name="ch_vice_coord" value="{{ old('ch_vice_coord') }}" autocomplete="ch_vice_coord" autofocus disabled>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <label for="area_tematica_principal" class="col-form-label">{{ __('Área(s) temática(s) principal(is) do projeto, de acordo com a Política Nacional de Extensão') }}</label>
                            <input id="area_tematica_principal" type="text" class="form-control" name="area_tematica_principal" value="{{ old('area_tematica_principal') }}" required autocomplete="area_tematica_principal" autofocus>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="ods" class="col-form-label">{{ __('Identifique qual(is) Objetivo(s) de Desenvolvimento Sustentáveis (ODS) da Agenda 2030 da ONU,
                                                                                        está(ão) presente(s) no projeto') }}
                                <a href="https://brasil.un.org/pt-br/sdgs" target="_blank"> {{ __('(para maiores esclarecimentos sobre ODS acesse o link)') }} </a>
                            </label>
                            <input id="ods" type="text" class="form-control" name="ods" value="{{ old('ods') }}" required autocomplete="ods" autofocus>
                        </div>
                    </div>

                    <hr>

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
                                <label for="nome_interno" class="col-form-label">{{ __('Nome:') }}</label>
                                <input type="text" class="form-control" name="nome_interno[]" required autocomplete="nome_interno" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="cpf_interno" class="col-form-label">{{ __('CPF:') }}</label>
                                <input type="text" class="form-control" name="cpf_interno[]" required autocomplete="cpf_interno" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="tipo" class="col-form-label">{{ __('Tipo:') }}</label>
                                <select name="tipo[]" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option value="Discente">Discente</option>
                                    <option value="Servidor">Servidor</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="tipo_vinculo" class="col-form-label">{{ __('Tipo de vínculo: (caso seja servidor)') }}</label>
                                <select name="tipo_vinculo[]" class="form-control">
                                    <option value="">Selecione...</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Substituto/a">Substituto/a</option>
                                    <option value="Técnico/a Administrativo/a">Técnico/a Administrativo/a</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="curso_interno" class="col-form-label">{{ __('Curso de graduação: (caso seja discente)') }}</label>
                                <input type="text" class="form-control" name="curso_interno[]" autocomplete="curso_interno" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="curso_setor" class="col-form-label">{{ __('Curso*/Setor de Atuação**: (caso seja servidor)') }}</label>
                                <input type="text" class="form-control" name="curso_setor[]" autocomplete="curso_setor" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_interno" class="col-form-label">{{ __('Data de ingresso na proposta:') }}</label>
                                <input type="date" class="form-control" name="data_ingresso_interno[]" required autocomplete="data_ingresso_interno" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_interno" class="col-form-label">{{ __('Data de conclusão na proposta:') }}</label>
                                <input type="date" class="form-control" name="data_conclusao_interno[]" required autocomplete="data_conclusao_interno" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_interno" class="col-form-label">{{ __('Carga corária total de atuação na proposta:') }}</label>
                                <input type="text" class="form-control" name="carga_horaria_interno[]" required autocomplete="carga_horaria_interno" autofocus>
                            </div>

                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverIntegrante">Remover</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnAddIntegranteInterno" class="btn btn-primary mt-3">Adicionar outro integrante interno</button>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h5>Integrantes externos à UFAPE (Sem limite de integrantes)</h5>
                        </div>
                    </div>
                    <div id="integrantesExternos">
                        <div class="row integranteExterno">
                            <div class="col-6">
                                <label for="nome_externo" class="col-form-label">{{ __('Nome do Integrante Externo:') }}</label>
                                <input type="text" class="form-control" name="nome_externo[]" required autocomplete="nome_externo" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="cpf_externo" class="col-form-label">{{ __('CPF do Integrante Externo:') }}</label>
                                <input type="text" class="form-control" name="cpf_externo[]" required autocomplete="cpf_externo" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="intituicao_vinculo" class="col-form-label">{{ __('Instituição de vínculo:') }}</label>
                                <input type="text" class="form-control" name="instituicao_vinculo[]" required autocomplete="intituicao_vinculo" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_externo" class="col-form-label">{{ __('Carga Horária do Integrante Externo:') }}</label>
                                <input type="text" class="form-control" name="carga_horaria_externo[]" required autocomplete="carga_horaria_externo" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_externo" class="col-form-label">{{ __('Data de Ingresso do Integrante Externo:') }}</label>
                                <input type="date" class="form-control" name="data_ingresso_externo[]" required autocomplete="data_ingresso_externo" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_externo" class="col-form-label">{{ __('Data de Conclusão do Integrante Externo:') }}</label>
                                <input type="date" class="form-control" name="data_conclusao_externo[]" required autocomplete="data_conclusao_externo" autofocus>
                            </div>
                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverExterno">Remover</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnAddIntegranteExterno" class="btn btn-primary mt-3">Adicionar outro integrante externo</button>

                    <hr>

                    <!-- Campos Comuns do Formulário -->
                    <div class="row">
                        <div class="col-12">
                            <label for="captacao_recursos" class="col-form-label">{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</label>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos" id="captacao_recursos_sim" value="true" autocomplete="off" checked>
                                <label class="form-check-label" for="captacao_recursos_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="captacao_recursos" id="captacao_recursos_nao" value="false" autocomplete="off">
                                <label class="form-check-label" for="captacao_recursos_nao">Não</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <br>

                    <div class="text-center" style="font: bold">
                        <h5>PARTE 3 - RESULTADOS E OBJETIVOS ALCANÇADOS</h5>
                    </div>

                    <br>

                    <div class="row">
                        <!-- Campo 1) Resumo -->
                        <div class="col-12">
                            <label for="resumo" class="col-form-label">{{ __('1) Resumo:') }}</label>
                            <textarea id="resumo" class="form-control" name="resumo" rows="4" maxlength="2000" required autocomplete="resumo"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 2) Proporção de Objetivos Alcançados -->
                        <div class="col-12">
                            <label for="objetivos_alcancados" class="col-form-label">{{ __('2) Em que proporção (%) os objetivos da proposta foram alcançados?') }}</label>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-check-inline d-flex justify-content-between">
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_0" value="0">
                                    <label class="form-check-label" for="objetivos_alcancados_0">0</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_10" value="10">
                                    <label class="form-check-label" for="objetivos_alcancados_10">10</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_20" value="20">
                                    <label class="form-check-label" for="objetivos_alcancados_20">20</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_30" value="30">
                                    <label class="form-check-label" for="objetivos_alcancados_30">30</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_40" value="40">
                                    <label class="form-check-label" for="objetivos_alcancados_40">40</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_50" value="50">
                                    <label class="form-check-label" for="objetivos_alcancados_50">50</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_60" value="60">
                                    <label class="form-check-label" for="objetivos_alcancados_60">60</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_70" value="70">
                                    <label class="form-check-label" for="objetivos_alcancados_70">70</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_80" value="80">
                                    <label class="form-check-label" for="objetivos_alcancados_80">80</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_90" value="90">
                                    <label class="form-check-label" for="objetivos_alcancados_90">90</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados" id="objetivos_alcancados_100" value="100">
                                    <label class="form-check-label" for="objetivos_alcancados_100">100</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="justificativa_objetivos_alcancados" class="col-form-label">{{ __('Caso não tenha atingido integralmente (100%) os objetivos propostos, quais deles deixaram de ser alcançados? Justifique.') }}</label>
                            <input id="justificativa_objetivos_alcancados" type="text" class="form-control" name="justificativa_objetivos_alcancados" value="{{ old('justificativa_objetivos_alcancados') }}" autocomplete="justificativa_objetivos_alcancados" autofocus>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 3) Pessoas Beneficiadas -->
                        <div class="col-12">
                            <label for="pessoas_beneficiadas" class="col-form-label">{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</label>
                            <input id="pessoas_beneficiadas" type="number" class="form-control" name="pessoas_beneficiadas" required autocomplete="pessoas_beneficiadas">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 4) Proporção de Alcance do Público Estimado -->
                        <div class="col-12">
                            <label for="alcance_publico_estimado" class="col-form-label">{{ __('4) Em que proporção (%) o projeto alcançou o público estimado?') }}</label>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-check-inline d-flex justify-content-between">
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_0" value="0">
                                    <label class="form-check-label" for="alcance_publico_estimado_0">0</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_10" value="10">
                                    <label class="form-check-label" for="alcance_publico_estimado_10">10</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_20" value="20">
                                    <label class="form-check-label" for="alcance_publico_estimado_20">20</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_30" value="30">
                                    <label class="form-check-label" for="alcance_publico_estimado_30">30</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_40" value="40">
                                    <label class="form-check-label" for="alcance_publico_estimado_40">40</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_50" value="50">
                                    <label class="form-check-label" for="alcance_publico_estimado_50">50</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_60" value="60">
                                    <label class="form-check-label" for="alcance_publico_estimado_60">60</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_70" value="70">
                                    <label class="form-check-label" for="alcance_publico_estimado_70">70</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_80" value="80">
                                    <label class="form-check-label" for="alcance_publico_estimado_80">80</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_90" value="90">
                                    <label class="form-check-label" for="alcance_publico_estimado_90">90</label>
                                </div>
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado" id="alcance_publico_estimado_100" value="100">
                                    <label class="form-check-label" for="alcance_publico_estimado_100">100</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="justificativa_publico_estimado" class="col-form-label">{{ __('Caso não tenha atingido integralmente (100%) a estimativa de público, justifique.') }}</label>
                            <input id="justificativa_publico_estimado" type="text" class="form-control" name="justificativa_publico_estimado" value="{{ old('justificativa_publico_estimado') }}" autocomplete="justificativa_publico_estimado" autofocus>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 5) Benefícios para o Público Atendido -->
                        <div class="col-12">
                            <label for="beneficios_publico_atendido" class="col-form-label">{{ __('5) Quais foram os benefícios do projeto para o público atendido?') }}</label>
                            <textarea id="beneficios_publico_atendido" class="form-control" name="beneficios_publico_atendido" rows="4" required autocomplete="beneficios_publico_atendido"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 6) Impactos Tecnológicos e/ou Científicos -->
                        <div class="col-12">
                            <label for="impactos_tecnologicos_cientificos" class="col-form-label">{{ __('6) Descreva o/s impacto/s tecnológico/s e/ou científico/s (se houve): Tecnologias desenvolvidas, patentes, inovações etc.') }}</label>
                            <textarea id="impactos_tecnologicos_cientificos" class="form-control" name="impactos_tecnologicos_cientificos" rows="4" required autocomplete="impactos_tecnologicos_cientificos"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 7) Dificuldades e Desafios -->
                        <div class="col-12">
                            <label for="desafios_encontrados" class="col-form-label">{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</label>
                            <textarea id="desafios_encontrados" class="form-control" name="desafios_encontrados" rows="4" required autocomplete="desafios_encontrados"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 8) Avaliação do Projeto e Expectativas -->
                        <div class="col-12">
                            <label for="avaliacao_projeto_executado" class="col-form-label">{{ __('8) Qual sua avaliação do projeto executado e qual sua expectativa quanto a continuidade dele?') }}</label>
                            <textarea id="avaliacao_projeto_executado" class="form-control" name="avaliacao_projeto_executado" rows="4" required autocomplete="avaliacao_projeto_executado"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Campo 9) Produtos de extensão gerados de acordo com a Política de Extensão da UFAPE -->
                        <div class="col-12">
                            <label for="produtos_extensao_gerados" class="col-form-label">{{ __('9) Produtos de extensão gerados de acordo com a Política de Extensão da UFAPE (em caso de dúvidas consulte a resolução de Extensão da UFAPE') }}
                                <a href="http://ufape.edu.br/sites/default/files/resolucoes/CONSEPE_RESOLUCAO_n_006_2022.pdf" target="_blank">(Acesse aqui)</a>
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
                                        Publicações em revistas, anais, resumos, livros, e-books, capítulo de livro/e-book, apostilas, manuais, fascículos, guias, folders, boletins, monografias, kits e relatórios técnicos, traduções, dentre outros.
                                    </td>
                                    <td><input type="text" name="tecnico_cientifico" id="tecnico_cientifico" class="form-control"></td>
                                    <td><input type="number" name="qtd_tecnico_cientifico" id="qtd_tecnico_cientifico" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                        <strong> Produto de divulgação </strong><br>
                                        Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e televisão, vídeos, podcasts, ensaios, dentre outros.
                                    </td>
                                    <td><input type="text" name="divulgacao" id="divulgacao" class="form-control"></td>
                                    <td><input type="number" name="qtd_divulgacao" id="qtd_divulgacao" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                        <strong> Produto didático ou instrucional </strong><br>
                                        Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd’s e kits didáticos, podcasts, games, dentre outros.
                                    </td>
                                    <td><input type="text" name="didatico_instrucional" id="didatico_instrucional" class="form-control"></td>
                                    <td><input type="number" name="qtd_didatico_instrucional" id="qtd_didatico_instrucional" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                        <strong> Produto multimídia </strong><br>
                                        Filmes, homepages, apps, podcasts, games, dentre outros.
                                    </td>
                                    <td><input type="text" name="multimidia" id="multimidia" class="form-control"></td>
                                    <td><input type="number" name="qtd_multimidia" id="qtd_multimidia" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                        <strong> Produto artístico-cultural </strong><br>
                                        Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre outros.
                                    </td>
                                    <td><input type="text" name="artistico_cultural" id="artistico_cultural" class="form-control"></td>
                                    <td><input type="number" name="qtd_artistico_cultural" id="qtd_artistico_cultural" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center" style="font: bold">
                        <h5>PARTE 4 - ESTATÍSTICAS DA AÇÃO (INDICADORES)</h5>
                    </div>

                    <br>

                    <div class="row">
                        <!-- Campo Confirmação de Preenchimento do Formulário de Indicadores -->
                        <div class="col-12">
                            <label for="formulario_indicadores" class="col-form-label">{{ __('Prezado/a Coordenador/a, favor preencher o formulário eletrônico com os indicadores do projeto, através do link: ') }}
                                <a href="https://forms.gle/5gkCNidnNZ1tNgtV9" target="_blank">https://forms.gle/5gkCNidnNZ1tNgtV9</a>
                            </label>

                            <div class="row">
                                <div class="col-12">
                                    <label class="col-form-label" for="formulario_indicadores">Confirmo que preenchi o formulário de indicadores </label>
                                </div>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_sim" value="true">
                                <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_nao" value="false">
                                <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="text-center" style="font: bold">
                        <h5>
                            PARTE 5 - LISTA DE PARTICIPANTES BENEFICIADOS A SEREM CERTIFICADOS
                        </h5>
                    </div>

                    <br>

                    <div class="row">
                        <!-- Campo Certificação de Atividade Envolvendo o Público Beneficiado -->
                        <div class="col-12">
                            <label class="col-form-label" for="certificacao_adicinonal">{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</label>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_sim" value="true">
                                <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_nao" value="false">
                                <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Campos do Participante -->
                    <div class="row">
                        <div class="col-12">
                            <h5>Participantes</h5>
                        </div>
                    </div>
                    <div id="participantes">
                        <div class="row participante">
                            <div class="col-6">
                                <label for="nome_participante" class="col-form-label">{{ __('Nome do Participante:') }}</label>
                                <input type="text" class="form-control" name="nome_participante[]" required autocomplete="nome_participante" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="cpf_participante" class="col-form-label">{{ __('CPF do Participante:') }}</label>
                                <input type="text" class="form-control" name="cpf_participante[]" required autocomplete="cpf_participante" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_participante" class="col-form-label">{{ __('Carga Horária do Participante:') }}</label>
                                <input type="text" class="form-control" name="carga_horaria_participante[]" required autocomplete="carga_horaria_participante" autofocus>
                            </div>
                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverParticipante">Remover</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btnAddParticipante" class="btn btn-primary mt-3">Adicionar outro participante</button>
                </div>
            </div>

            <br>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('btnAddIntegranteInterno').addEventListener('click', function () {
                var integranteInternoClone = document.querySelector('.integranteInterno').cloneNode(true);
                var integrantesInternosDiv = document.getElementById('integrantesInternos');
                integrantesInternosDiv.appendChild(integranteInternoClone);
            });

            document.getElementById('btnAddIntegranteExterno').addEventListener('click', function () {
                var integranteExternoClone = document.querySelector('.integranteExterno').cloneNode(true);
                var integrantesExternosDiv = document.getElementById('integrantesExternos');
                integrantesExternosDiv.appendChild(integranteExternoClone);
            });

            document.getElementById('btnAddParticipante').addEventListener('click', function () {
                var participanteClone = document.querySelector('.participante').cloneNode(true);
                var participantesDiv = document.getElementById('participantes');
                participantesDiv.appendChild(participanteClone);
            });

            $(document).on('click', '.btnRemoverIntegrante', function() {
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

            $(document).on('click', '.btnRemoverExterno', function() {
                var externos = $('.externo');
                if (externos.length > 1) {
                    var confirmacao = confirm('Tem certeza que deseja remover este integrante externo?');
                    if (confirmacao) {
                        $(this).closest('.externo').remove();
                    }
                } else {
                    alert('O primeiro integrante externo não pode ser removido.');
                }
            });

            $(document).on('click', '.btnRemoverParticipante', function() {
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

                // Limpar valores dos campos ao desmarcar o checkbox
                if (!checkbox.checked) {
                    inputsViceCoord.forEach(input => {
                        input.value = '';
                    });
                }
            });
        });
    </script>
@endsection
