<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Relatório Final - {{ $trabalho->evento->nome  }}</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Times New Roman', Times, serif;
            }

            .titulo-menu {
                color: rgb(0, 140, 255);
            }
        </style>
    </head>

    <body>
        <div class="text-center titulo-menu">
            <h4>Relatório Final - {{ $trabalho->titulo }}</h4>
        </div>

        <br>

        <div class="text-center" style="font-size: 16px; font-weight: bold">
            PARTE 1 - IDENTIFICAÇÃO DO PROJETO
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label"> <strong>{{ __('Edital:') }}</strong>
                    {{ $relatorio->trabalho->evento->nome }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Data de início do projeto:') }}</strong>
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $relatorio->inicio_projeto)->format('d/m/Y') }}
                </label>
            </div>

            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Data de conclusão do projeto:') }}</strong>
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $relatorio->conclusao_projeto)->format('d/m/Y') }}
                </label>
            </div>

            <div class="col-md-12">
                <label class="col-form-label"> <strong>{{ __('Título do projeto:') }}</strong>
                    {{ $relatorio->titulo_projeto }}
                </label>
            </div>
        </div>

        <br>

        <div>
            <h6>Coordenador/a do projeto:</h6>
        </div>
        <div class="row" style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px">
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Nome:') }}</strong>
                    {{ $coordenador->nome }}
                </label>
            </div>

            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('E-mail Institucional:') }}</strong>
                    {{ $coordenador->email_institucional }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Cargo:') }}</strong>
                    {{ $coordenador->cargo }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Curso:') }}</strong>
                    {{ $coordenador->curso_setor }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('CPF:') }}</strong>
                    {{ $coordenador->cpf }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                    {{ $coordenador->telefone }}
                </label>
            </div>
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Carga horária de atuação na proposta:') }}</strong>
                    {{ $coordenador->ch_total_atuacao }}
                </label>
            </div>
        </div>

        <br>

        @if($vice_coordenador)
            <div class="col-md-12">
                <h6>Vice-Coordenador/a do projeto (caso houver)</h6>
            </div>
            <div class="row" style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px">
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Nome:') }}</strong>
                        {{ $vice_coordenador->nome }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('E-mail Institucional:') }}</strong>
                        {{ $vice_coordenador->email_institucional }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Cargo:') }}</strong>
                        {{ $vice_coordenador->cargo }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Curso:') }}</strong>
                        {{ $vice_coordenador->curso_setor }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('CPF:') }}</strong>
                        {{ $vice_coordenador->cpf }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                        {{ $vice_coordenador->telefone }}
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                        {{ $vice_coordenador->ch_total_atuacao }}
                    </label>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <label for="area_tematica_principal" class="col-form-label">
                    <strong>{{ __('Área(s) temática(s) principal(is) do projeto, de acordo com a Política Nacional de Extensão') }}</strong>
                </label>
                <div>
                    @foreach($areas_tematicas as $area_tematica)
                        <label class="form-check-label" for="area_tematica_{{ $area_tematica->id }}">
                            {{ $area_tematica->nome }}
                        </label>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <label for="ods" class="col-form-label">
                    <strong>{{ __('Identifique qual(is) Objetivo(s) de Desenvolvimento Sustentáveis (ODS) da Agenda 2030 da ONU, está(ão) presente(s) no projeto') }}</strong>
                    <a href="https://brasil.un.org/pt-br/sdgs" target="_blank">{{ __('(para maiores esclarecimentos sobre ODS acesse o link)') }}</a>
                </label>
                <div>
                    @foreach($ods as $od)
                        <label class="form-check-label" for="od_{{ $od->id }}">
                            {{ $od->nome }}
                        </label><br>
                    @endforeach
                </div>
            </div>
        </div>

        <hr>

        <div class="text-center" style="font-size: 16px; font-weight: bold">
            PARTE 2 - IDENTIFICAÇÃO DA EQUIPE E PARCERIAS
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <h6>Equipe: Integrantes internos à UFAPE</h6>
            </div>
        </div>

        @foreach($internos as $interno)
            <div id="integrantesInternos">
                <div class="row integranteInterno" style="border: 1px solid #ccc; padding: 2px; margin-left: 0px; margin-right: 0px">
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Nome:') }}</strong>
                            {{ $interno->nome }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('CPF:') }}</strong>
                            {{ $interno->cpf }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Tipo:') }}</strong>
                            {{ $interno->tipo }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Tipo de vínculo:') }}</strong>
                            {{ $interno->tipo_vinculo }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Curso de graduação:') }}</strong>
                            {{ $interno->curso_graduacao }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Curso/Setor de Atuação:') }}</strong>
                            {{ $interno->curso_setor }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $interno->ingresso_proposta)->format('d/m/Y') }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $interno->conclusao_proposta)->format('d/m/Y') }}
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                            {{ $interno->ch_total_atuacao }}
                        </label>
                    </div>
                </div>
            </div>

            <br>
        @endforeach

        <br>

        @if($externos->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <h6>Equipe: Integrantes externos à UFAPE</h6>
                </div>
            </div>
        @endif

        @foreach($externos as $externo)
            <div class="row" style="border: 1px solid #ccc; padding: 2px; margin-left: 0px; margin-right: 0px">
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Nome:') }}</strong>
                        {{ $externo->nome }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('CPF:') }}</strong>
                        {{ $externo->cpf }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Instituição de vínculo:') }}</strong>
                        {{ $externo->instituicao_vinculo }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                        {{ $externo->ch_total_atuacao }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong>
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $externo->ingresso_proposta)->format('d/m/Y') }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong>
                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $externo->conclusao_proposta)->format('d/m/Y') }}
                    </label>
                </div>
            </div>

            <br>
        @endforeach

        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</strong></label>
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

        <hr>

        <div class="text-center" style="font-size: 16px; font-weight: bold">
            PARTE 3 - RESULTADOS E OBJETIVOS ALCANÇADOS
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('1) Resumo:') }}</strong> </label>
                <br>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->resumo }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('2) Em que proporção (%) os objetivos da proposta foram alcançados?') }}</strong></label>

                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->objetivos_alcancados }}%
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('Caso não tenha atingido integralmente (100%) os objetivos propostos, quais deles deixaram de ser alcançados? Justifique.') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->justificativa_objetivos_alcancados }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->pessoas_beneficiadas }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('4) Em que proporção (%) o projeto alcançou o público estimado?') }}</strong></label>

                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->alcance_publico_estimado }}%
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('Caso não tenha atingido integralmente (100%) a estimativa de público, justifique.') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->justificativa_publico_estimado }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('5) Quais foram os benefícios do projeto para o público atendido?') }}</strong> </label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->beneficios_publico_atendido }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('6) Descreva o/s impacto/s tecnológico/s e/ou científico/s (se houve): Tecnologias desenvolvidas, patentes, inovações etc.') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->impactos_tecnologicos_cientificos }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->desafios_encontrados }}
                </div>
            </div>

            <br>

            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('8) Qual sua avaliação do projeto executado e qual sua expectativa quanto a continuidade dele?') }}</strong></label>
                <div style="border: 1px solid #ccc; padding: 2px; margin-bottom: 10px; margin-left: 0px; margin-right: 0px; text-align: justify">
                    {{ $relatorio->avaliacao_projeto_executado }}
                </div>
            </div>

            <br>

            <div class="col-md-12">
                <label class="col-form-label"><strong>{{ __('9) Produtos de extensão gerados de acordo com a Política de Extensão da UFAPE (em caso de dúvidas consulte a resolução de Extensão da UFAPE') }}</strong> <a href="http://ufape.edu.br/sites/default/files/resolucoes/CONSEPE_RESOLUCAO_n_006_2022.pdf" target="_blank">(Acesse aqui)</a></label>
            </div>

            <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="col-md-6 text-center">Modalidade</th>
                        <th scope="col" class="col-md-3 text-center">Especificar</th>
                        <th scope="col" class="col-md-3 text-center">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <strong>Produto técnico-científico</strong><br>
                            Publicações em revistas, anais, resumos, livros, e-books, capítulo de livro/e-book, apostilas, manuais, fascículos, guias, folders, boletins, monografias, kits e relatórios técnicos, traduções, dentre outros.
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->tecnico_cientifico }}
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->qtd_tecnico_cientifico }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Produto de divulgação</strong><br>
                            Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e televisão, vídeos, podcasts, ensaios, dentre outros.
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->divulgacao }}
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->qtd_divulgacao }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Produto didático ou instrucional</strong><br>
                            Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd’s e kits didáticos, podcasts, games, dentre outros.
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->didatico_instrucional }}
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->qtd_didatico_instrucional }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Produto multimídia</strong><br>
                            Filmes, homepages, apps, podcasts, games, dentre outros.
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->multimidia }}
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->qtd_multimidia }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <strong>Produto artístico-cultural</strong><br>
                            Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre outros.
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->artistico_cultural }}
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                {{ $produtos_extensao_gerados->qtd_artistico_cultural }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div class="text-center" style="font-size: 16px; font-weight: bold">
            PARTE 4 - ESTATÍSTICAS DA AÇÃO (INDICADORES)
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label"> <strong>{{ __('Prezado/a Coordenador/a, favor preencher o formulário eletrônico com os indicadores do projeto, através do link: ') }}</strong>
                    <a href="https://forms.gle/Qfa8YEAjBdmC2aW2A" target="_blank">https://forms.gle/Qfa8YEAjBdmC2aW2A</a>
                </label>
            </div>

            <div class="col-md-12">
                <label class="col-form-label" for="formulario_indicadores">Confirmo que preenchi o formulário de indicadores</label>
            </div>

            @if($relatorio->formulario_indicadores == true)
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_sim" value="true" checked disabled>
                        <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_nao" value="false" disabled>
                        <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_sim" value="true" disabled>
                        <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="formulario_indicadores" id="formulario_indicadores_nao" value="false" checked disabled>
                        <label class="form-check-label" for="formulario_indicadores_nao">Não</label>
                    </div>
                </div>
            @endif
        </div>

        <hr>

        <div class="text-center" style="font-size: 16px; font-weight: bold">
            PARTE 5 - LISTA DE PARTICIPANTES BENEFICIADOS A SEREM CERTIFICADOS
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <label class="col-form-label"><strong>{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</strong></label>
            </div>

            @if($relatorio->certificacao_adicinonal == true)
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_sim" value="true" checked disabled>
                        <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_nao" value="false" disabled>
                        <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_sim" value="true" disabled>
                        <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="certificacao_adicinonal" id="certificacao_adicinonal_nao" value="false" checked disabled>
                        <label class="form-check-label" for="certificacao_adicinonal_nao">Não</label>
                    </div>
                </div>
            @endif
        </div>

        <br>

        @if($participantes->isNotEmpty())
            <div class="row">
                <div class="col-12">
                    <h6>Participantes</h6>
                </div>
            </div>
        @endif

        @foreach($participantes as $participante)
            <div class="row" style="border: 1px solid #ccc; padding: 2px; margin-left: 0px; margin-right: 0px">
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Nome:') }}</strong>
                        {{ $participante->nome }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('CPF:') }}</strong>
                        {{ $participante->cpf }}
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="col-form-label"> <strong>{{ __('Carga horária:') }}</strong>
                        {{ $participante->carga_horaria }}
                    </label>
                </div>
            </div>

            <br>
        @endforeach

        <hr>
    </body>
</html>
