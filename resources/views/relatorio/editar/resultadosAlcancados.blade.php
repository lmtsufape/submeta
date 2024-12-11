@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 2%">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @endif

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
            <h4 class="mb-0">Editar - Relatório Final PIBEX - {{ $trabalho->titulo }}</h4>
        </div>


        <form id="formRelatFinal" method="post" action="{{  route('relatorioFinalPibex.updateParte3') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="relatorio_id" value="{{ $relatorio->id }}">

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
                                  autocomplete="resumo">{{ $relatorio->resumo }}</textarea>
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
                            @for ($i = 0; $i <= 100; $i += 10)
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="objetivos_alcancados"
                                           id="objetivos_alcancados_{{ $i }}" value="{{ $i }}"
                                            {{ $relatorio->objetivos_alcancados == $i ? 'checked' : '' }}>
                                    <label class="form-check-label" for="objetivos_alcancados_{{ $i }}">{{ $i }}</label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="justificativa_objetivos_alcancados"
                               class="col-form-label">
                            <strong>{{ __('Caso não tenha atingido integralmente (100%) os objetivos propostos, quais deles deixaram de ser alcançados? Justifique.') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>
                        <input id="justificativa_objetivos_alcancados" type="text" class="form-control"
                               name="justificativa_objetivos_alcancados"
                               value="{{ $relatorio->justificativa_objetivos_alcancados }}"
                               autocomplete="justificativa_objetivos_alcancados" autofocus required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="pessoas_beneficiadas"
                               class="col-form-label">
                            <strong>{{ __('3) Quantas pessoas foram diretamente beneficiadas pela atividade?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span></label>
                        <input id="pessoas_beneficiadas" type="number" class="form-control"
                               name="pessoas_beneficiadas" required autocomplete="pessoas_beneficiadas" value="{{ $relatorio->pessoas_beneficiadas }}">
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
                            @for ($i = 0; $i <= 100; $i += 10)
                                <div class="w-10">
                                    <input class="form-check-input" type="radio" name="alcance_publico_estimado"
                                           id="alcance_publico_estimado_{{ $i }}" value="{{ $i }}"
                                            {{ $relatorio->alcance_publico_estimado == $i ? 'checked' : '' }}>
                                    <label class="form-check-label" for="alcance_publico_estimado_{{ $i }}">{{ $i }}</label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="justificativa_publico_estimado"
                               class="col-form-label">
                            <strong>{{ __('Caso não tenha atingido integralmente (100%) a estimativa de público, justifique.') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>
                        <input id="justificativa_publico_estimado" type="text" class="form-control"
                               name="justificativa_publico_estimado"
                               value="{{ $relatorio->justificativa_publico_estimado }}"
                               autocomplete="justificativa_publico_estimado" autofocus required>
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
                                  autocomplete="beneficios_publico_atendido">{{ $relatorio->beneficios_publico_atendido }}</textarea>
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
                                  autocomplete="impactos_tecnologicos_cientificos">{{ $relatorio->impactos_tecnologicos_cientificos }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="desafios_encontrados"
                               class="col-form-label">
                            <strong>{{ __('7) Descreva a/s dificuldade/s e/ou desafio/s encontrado/s na execução do projeto? (se houve).') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span> </label>
                        <textarea id="desafios_encontrados" class="form-control" name="desafios_encontrados"
                                  rows="4" required autocomplete="desafios_encontrados">{{ $relatorio->desafios_encontrados }}</textarea>
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
                                  autocomplete="avaliacao_projeto_executado">{{ $relatorio->avaliacao_projeto_executado }}</textarea>
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
                                           class="form-control" value="{{ $produtos_extensao_gerados->tecnico_cientifico }}" required></td>
                                <td><input type="number" name="qtd_tecnico_cientifico" id="qtd_tecnico_cientifico"
                                           class="form-control" value="{{ $produtos_extensao_gerados->qtd_tecnico_cientifico }}" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto de divulgação </strong><br>
                                    Folders, cartazes, revistas, reportagens, entrevistas, programas de rádio e
                                    televisão, vídeos, podcasts, ensaios, dentre outros.
                                </td>
                                <td><input type="text" name="divulgacao" id="divulgacao" class="form-control" value="{{ $produtos_extensao_gerados->divulgacao }}"required></td>
                                <td><input type="number" name="qtd_divulgacao" id="qtd_divulgacao"
                                           class="form-control"  value="{{ $produtos_extensao_gerados->qtd_divulgacao }}"required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto didático ou instrucional </strong><br>
                                    Manuais, cartilhas, apostilas, vídeos, modelos didáticos, cd’s e kits didáticos,
                                    podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="didatico_instrucional" id="didatico_instrucional"
                                           class="form-control" value="{{ $produtos_extensao_gerados->didatico_instrucional }}" required></td>
                                <td><input type="number" name="qtd_didatico_instrucional"
                                           id="qtd_didatico_instrucional" class="form-control" value="{{ $produtos_extensao_gerados->qtd_didatico_instrucional }}" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto multimídia </strong><br>
                                    Filmes, homepages, apps, podcasts, games, dentre outros.
                                </td>
                                <td><input type="text" name="multimidia" id="multimidia" class="form-control" value="{{ $produtos_extensao_gerados->multimidia }}" required></td>
                                <td><input type="number" name="qtd_multimidia" id="qtd_multimidia"
                                           class="form-control" value="{{ $produtos_extensao_gerados->qtd_multimidia }}" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong> Produto artístico-cultural </strong><br>
                                    Filmes, vídeos, peças teatrais, partituras, performances artísticas, dentre
                                    outros.
                                </td>
                                <td><input type="text" name="artistico_cultural" id="artistico_cultural"
                                           class="form-control" value="{{ $produtos_extensao_gerados->artistico_cultural }}" required></td>
                                <td><input type="number" name="qtd_artistico_cultural" id="qtd_artistico_cultural"
                                           class="form-control" value="{{ $produtos_extensao_gerados->qtd_artistico_cultural }}" required></td>
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

                <div class="text-left" style="font: bold">
                    <h5>
                        ETAPA 3/4
                    </h5>
                </div>

                <br>

                <div class="form-group row text-right">
                    <div class="col-6 text-left">
                        <h6 class="card-title mb-0" style="color:red">* Campos obrigatórios</h6>
                    </div>
                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-success">Próximo</button>
                    </div>
                </div>

                <br>
            </div>
        </form>
    </div>
@endsection
