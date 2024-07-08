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


        <form id="editarRelatorioParte1" method="post" action="{{  route('relatorioFinalPibex.updateParte1') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="relatorio_id" value="{{ $relatorio->id }}">

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
                               value="{{ $relatorio->inicio_projeto }}" required autocomplete="data_inicio" autofocus>
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
                               value="{{ $relatorio->conclusao_projeto }}" required autocomplete="data_conclusao"
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
                               value="{{ $relatorio->titulo_projeto }}" required autocomplete="titulo_projeto" autofocus>
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
                               autofocus>
                    </div>
                    <div class="col-6">
                        <label for="email_institucional_coordenador"
                               class="col-form-label"> <strong>{{ __('E-mail Institucional:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="email_institucional_coordenador" type="email" class="form-control"
                               name="email_institucional_coordenador"
                               value="{{ $coordenador->email_institucional }}" required
                               autocomplete="email_institucional_coordenador" autofocus>
                    </div>
                    <div class="col-6">
                        <label for="cargo_coordenador" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <select id="cargo_coordenador" class="form-control" name="cargo_coordenador" required
                                autocomplete="cargo_coordenador" autofocus>
                            <option value="{{ $coordenador->cargo }}">{{ $coordenador->cargo }}</option>
                            <option value="Docente">Docente</option>
                            <option value="Técnico/a administrativo/a">Técnico/a administrativo/a</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="curso_coordenador" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="curso_coordenador" type="text" class="form-control" name="curso_coordenador"
                               value="{{ $coordenador->curso_setor }}" required autocomplete="curso_coordenador"
                               autofocus>
                    </div>
                    <div class="col-6">
                        <label for="cpf_coordenador" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="cpf" type="text" class="form-control" name="cpf_coordenador"
                               value="{{ $coordenador->cpf }}" required autocomplete="cpf_coordenador"
                               autofocus>
                    </div>
                    <div class="col-6">
                        <label for="telefone_coordenador" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="celular" type="text" class="form-control"
                               name="telefone_coordenador" value="{{ $coordenador->telefone }}" required
                               autocomplete="telefone_coordenador" autofocus>
                    </div>
                    <div class="col-6">
                        <label for="ch_coordenador" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                            <span
                                    style="color: red; font-weight:bold;">*</span> </label>
                        <input id="ch_coordenador" type="number" class="form-control" name="ch_coordenador"
                               value="{{ $coordenador->ch_total_atuacao }}" required autocomplete="ch_coordenador" autofocus>
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
                               name="nome_vice_coord" value="{{ $vice_coordenador->nome }}"
                               autocomplete="nome_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="email_institucional_vice_coord"
                               class="col-form-label"> <strong>{{ __('E-mail institucional:') }}</strong> </label>
                        <input id="email_institucional_vice_coord" type="email"
                               class="form-control vice-coordenador" name="email_institucional_vice_coord"
                               value="{{ $vice_coordenador->email_institucional }}"
                               autocomplete="email_institucional_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="cargo_vice_coord" class="col-form-label"> <strong>{{ __('Cargo:') }}</strong> </label>
                        <select id="cargo_vice_coord" class="form-control vice-coordenador"
                                name="cargo_vice_coord" autocomplete="cargo_vice_coord" autofocus disabled>
                            <option value="{{ $vice_coordenador->cargo }}">{{ $vice_coordenador->cargo }}</option>
                            <option value="Docente">Docente</option>
                            <option value="Técnico/a administrativo/a">Técnico/a administrativo/a</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="curso_vice_coord" class="col-form-label"> <strong>{{ __('Curso:') }}</strong> </label>
                        <input id="curso_vice_coord" type="text" class="form-control vice-coordenador"
                               name="curso_vice_coord" value="{{ $vice_coordenador->curso_setor }}"
                               autocomplete="curso_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="cpf_vice_coord" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                        <input id="cpf_vice_coord" type="text" class="form-control vice-coordenador"
                               name="cpf_vice_coord" value="{{ $vice_coordenador->cpf }}"
                               autocomplete="cpf_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="telefone_vice_coord" class="col-form-label"> <strong>{{ __('Telefone:') }}</strong>
                        </label>
                        <input id="celular" type="text" class="form-control vice-coordenador"
                               name="telefone_vice_coord" value="{{ $vice_coordenador->telefone }}"
                               autocomplete="telefone_vice_coord" autofocus disabled>
                    </div>
                    <div class="col-6">
                        <label for="ch_vice_coord" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                        </label>
                        <input id="ch_vice_coord" type="number" class="form-control vice-coordenador"
                               name="ch_vice_coord" value="{{ $vice_coordenador->ch_total_atuacao }}" autocomplete="ch_vice_coord"
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
                            @foreach($areas_selecionadas as $area_tematica)
                                <input class="form-check-input" type="checkbox" name="select_area_tematica[]"
                                       id="area_tematica_{{ $area_tematica->id }}" value="{{ $area_tematica->id }}" checked>
                                <label class="form-check-label" for="area_tematica_{{ $area_tematica->id }}">
                                    {{ $area_tematica->nome }}
                                </label><br>
                            @endforeach

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
                            @foreach($ods_selecionadas as $od)
                                <input class="form-check-input" type="checkbox" name="select_ods[]" id="od_{{ $od->id }}"
                                       value="{{ $od->id }}" checked>
                                <label class="form-check-label" for="od_{{ $od->id }}">
                                    {{ $od->nome }}
                                </label><br>
                            @endforeach

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

                <div class="text-left" style="font: bold">
                    <h5>
                        ETAPA 1/4
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

        document.addEventListener('DOMContentLoaded', function ()
        {
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
