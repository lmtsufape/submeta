@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 2%">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @endif

        @if (session('erro'))
            <div class="alert alert-danger" role="alert">
                {{ session('erro') }}
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
            <h4 class="mb-0">Relatório Final PIBEX - {{ $relatorio->trabalho->titulo }}</h4>
        </div>

        <form id="formRelatFinal" method="post" action="{{ route('relatorioFinalPibex.storeParte2') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="relatorio_id" value="{{ $relatorio->id }}">
            <input type="hidden" name="etapa" value="etapa2">

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
                    @if(old('nome_interno'))
                        @foreach(old('nome_interno') as $key => $value)
                            <div class="row integranteInterno">
                                <input type="hidden" name="id_integrante[]" value="{{ old('id_integrante.'.$key) }}">
                                <div class="col-6">
                                    <label for="nome_interno" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                    <input type="text" class="form-control" name="nome_interno[]" value="{{ old('nome_interno.'.$key) }}" required>
                                </div>
                                <div class="col-6">
                                    <label for="cpf_interno" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                    <input type="text" class="form-control" id="cpf_interno" name="cpf_interno[]" value="{{ old('cpf_interno.'.$key) }}" placeholder="000.000.000-00" required>
                                </div>
                                <div class="col-6">
                                    <label for="tipo" class="col-form-label"> <strong>{{ __('Tipo:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                    <select name="tipo[]" class="form-control" required>
                                        <option value="" selected hidden></option>
                                        <option value="Discente" {{ old('tipo.'.$key) == 'Discente' ? 'selected' : '' }}>Discente</option>
                                        <option value="Servidor" {{ old('tipo.'.$key) == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="tipo_vinculo" class="col-form-label"> <strong>{{ __('Tipo de vínculo:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                    <select name="tipo_vinculo[]" class="form-control" required>
                                        <option value="" selected hidden></option>
                                        <option value="Bolsista" {{ old('tipo_vinculo.0') == 'Bolsista' ? 'selected' : '' }}>Bolsista</option>
                                        <option value="Discente - Colaborador" {{ old('tipo_vinculo.0') == 'Discente - Colaborador' ? 'selected' : '' }}>Discente - Colaborador</option>
                                        <option value="Docente - Colaborador" {{ old('tipo_vinculo.0') == 'Docente - Colaborador' ? 'selected' : '' }}>Docente - Colaborador</option>
                                        <option value="Técnico/a Administrativo/a - Colaborador" {{ old('tipo_vinculo.0') == 'Técnico/a Administrativo/a - Colaborador' ? 'selected' : '' }}>Técnico/a Administrativo/a - Colaborador</option>
                                        <option value="Vice-coordenador" {{ old('tipo_vinculo.0') == 'Vice-coordenador' ? 'selected' : '' }}>Vice-coordenador</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="curso_interno" class="col-form-label"> <strong>{{ __('Curso de graduação:') }}</strong> <span style="color: red; font-weight:bold;">(caso seja um discente)</span> </label>
                                    <input type="text" class="form-control" name="curso_interno[]" value="{{ old('curso_interno.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="curso_setor" class="col-form-label"> <strong>{{ __('Curso/Setor de Atuação:') }}</strong> <span style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                                    <input type="text" class="form-control" name="curso_setor[]" value="{{ old('curso_setor.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="data_ingresso_interno" class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> <span style="color: red; font-weight:bold;">*</span></label>
                                    <input type="date" class="form-control" name="data_ingresso_interno[]" value="{{ old('data_ingresso_interno.'.$key) }}" required>
                                </div>
                                <div class="col-6">
                                    <label for="data_conclusao_interno" class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> <span style="color: red; font-weight:bold;">*</span></label>
                                    <input type="date" class="form-control" name="data_conclusao_interno[]" value="{{ old('data_conclusao_interno.'.$key) }}" required>
                                </div>
                                <div class="col-6">
                                    <label for="carga_horaria_interno" class="col-form-label">
                                        <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong>
                                        <span style="color: red; font-weight:bold;">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="carga_horaria_interno[]" value="{{ old('carga_horaria_interno.'.$key) }}" required pattern="^\d+$" title="Insira apenas números" required>
                                </div>


                                <div class="col-12 mt-3 text-right">
                                    <button type="button" class="btn btn-danger btnRemoverIntegrante">Remover integrante interno</button>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @else
                        <div class="row integranteInterno">
                            <input type="hidden" name="id_integrante[]" value="">
                            <div class="col-6">
                                <label for="nome_interno" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                <input type="text" class="form-control" name="nome_interno[]" value="{{ old('nome_interno.0') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="cpf_interno" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                <input type="text" class="form-control" id="cpf_interno" name="cpf_interno[]" value="{{ old('cpf_interno.0') }}" placeholder="000.000.000-00" required>
                            </div>
                            <div class="col-6">
                                <label for="tipo" class="col-form-label"> <strong>{{ __('Tipo:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                <select name="tipo[]" class="form-control" required>
                                    <option value="" selected hidden></option>
                                    <option value="Discente" {{ old('tipo.0') == 'Discente' ? 'selected' : '' }}>Discente</option>
                                    <option value="Servidor" {{ old('tipo.0') == 'Servidor' ? 'selected' : '' }}>Servidor</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="tipo_vinculo" class="col-form-label"> <strong>{{ __('Tipo de vínculo:') }}</strong> <span style="color: red; font-weight:bold;">*</span> </label>
                                <select name="tipo_vinculo[]" class="form-control" required>
                                    <option value="" selected hidden></option>
                                    <option value="Bolsista" {{ old('tipo_vinculo.0') == 'Bolsista' ? 'selected' : '' }}>Bolsista</option>
                                    <option value="Discente - Colaborador" {{ old('tipo_vinculo.0') == 'Discente - Colaborador' ? 'selected' : '' }}>Discente - Colaborador</option>
                                    <option value="Docente - Colaborador" {{ old('tipo_vinculo.0') == 'Docente - Colaborador' ? 'selected' : '' }}>Docente - Colaborador</option>
                                    <option value="Técnico/a Administrativo/a - Colaborador" {{ old('tipo.0') == 'Técnico/a Administrativo/a - Colaborador' ? 'selected' : '' }}>Técnico/a Administrativo/a - Colaborador</option>
                                    <option value="Vice-coordenador" {{ old('tipo_vinculo.0') == 'Vice-coordenador' ? 'selected' : '' }}>Vice-coordenador</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="curso_interno" class="col-form-label"> <strong>{{ __('Curso de graduação:') }}</strong> <span style="color: red; font-weight:bold;">(caso seja um discente)</span> </label>
                                <input type="text" class="form-control" name="curso_interno[]" value="{{ old('curso_interno.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="curso_setor" class="col-form-label"> <strong>{{ __('Curso/Setor de Atuação:') }}</strong> <span style="color: red; font-weight:bold;">(caso seja um servidor)</span> </label>
                                <input type="text" class="form-control" name="curso_setor[]" value="{{ old('curso_setor.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_interno" class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> <span style="color: red; font-weight:bold;">*</span></label>
                                <input type="date" class="form-control" name="data_ingresso_interno[]" value="{{ old('data_ingresso_interno.0') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_interno" class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> <span style="color: red; font-weight:bold;">*</span></label>
                                <input type="date" class="form-control" name="data_conclusao_interno[]" value="{{ old('data_conclusao_interno.0') }}" required>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_interno" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong> <span style="color: red; font-weight:bold;">*</span></label>
                                <input type="number" class="form-control" name="carga_horaria_interno[]" value="{{ old('carga_horaria_interno.0') }}" required>
                            </div>

                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverIntegrante">Remover integrante interno</button>
                            </div>
                        </div>
                        <br>
                    @endif
                </div>

                <div class="form-group row text-right">
                    <div class="col-4 text-left">
                        <button type="button" id="btnAddIntegranteInterno" class="btn btn-primary mt-3">
                            Adicionar outro integrante interno
                        </button>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <h5>Integrantes externos à UFAPE (Sem limite de integrantes)</h5>
                    </div>
                </div>

                <div id="integrantesExternos">
                    @if(old('nome_externo'))
                        @foreach(old('nome_externo') as $key => $value)
                            <div class="row integranteExterno">
                                <input type="hidden" name="id_externo[]" value="{{ old('id_externo.'.$key) }}">
                                <div class="col-6">
                                    <label for="nome_externo" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                                    <input type="text" class="form-control" name="nome_externo[]" value="{{ old('nome_externo.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="cpf_externo" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                                    <input type="text" class="form-control" id="cpf_externo" name="cpf_externo[]" value="{{ old('cpf_externo.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="instituicao_vinculo" class="col-form-label"> <strong>{{ __('Instituição de vínculo:') }}</strong> </label>
                                    <input type="text" class="form-control" name="instituicao_vinculo[]" value="{{ old('instituicao_vinculo.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="carga_horaria_externo" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong> </label>
                                    <input type="number" class="form-control" name="carga_horaria_externo[]" value="{{ old('carga_horaria_externo.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="data_ingresso_externo" class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> </label>
                                    <input type="date" class="form-control" name="data_ingresso_externo[]" value="{{ old('data_ingresso_externo.'.$key) }}">
                                </div>
                                <div class="col-6">
                                    <label for="data_conclusao_externo" class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> </label>
                                    <input type="date" class="form-control" name="data_conclusao_externo[]" value="{{ old('data_conclusao_externo.'.$key) }}">
                                </div>

                                <div class="col-12 mt-3 text-right">
                                    <button type="button" class="btn btn-danger btnRemoverExterno">Remover integrante externo</button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <div class="row integranteExterno">
                            <input type="hidden" name="id_externo[]" value="">
                            <div class="col-6">
                                <label for="nome_externo" class="col-form-label"> <strong>{{ __('Nome:') }}</strong> </label>
                                <input type="text" class="form-control" name="nome_externo[]" value="{{ old('nome_externo.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="cpf_externo" class="col-form-label"> <strong>{{ __('CPF:') }}</strong> </label>
                                <input type="text" class="form-control" id="cpf_externo" name="cpf_externo[]" value="{{ old('cpf_externo.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="instituicao_vinculo" class="col-form-label"> <strong>{{ __('Instituição de vínculo:') }}</strong> </label>
                                <input type="text" class="form-control" name="instituicao_vinculo[]" value="{{ old('instituicao_vinculo.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_externo" class="col-form-label"> <strong>{{ __('Carga horária total de atuação na proposta:') }}</strong> </label>
                                <input type="number" class="form-control" name="carga_horaria_externo[]" value="{{ old('carga_horaria_externo.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="data_ingresso_externo" class="col-form-label"> <strong>{{ __('Data de ingresso na proposta:') }}</strong> </label>
                                <input type="date" class="form-control" name="data_ingresso_externo[]" value="{{ old('data_ingresso_externo.0') }}">
                            </div>
                            <div class="col-6">
                                <label for="data_conclusao_externo" class="col-form-label"> <strong>{{ __('Data de conclusão na proposta:') }}</strong> </label>
                                <input type="date" class="form-control" name="data_conclusao_externo[]" value="{{ old('data_conclusao_externo.0') }}">
                            </div>

                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverExterno">Remover integrante externo</button>
                            </div>
                        </div>
                        <hr>
                    @endif
                </div>

                <div class="form-group row text-right">
                    <div class="col-4 text-left">
                        <button type="button" id="btnAddIntegranteExterno" class="btn btn-primary mt-3">
                            Adicionar outro integrante externo
                        </button>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="captacao_recursos" class="col-form-label">
                            <strong>{{ __('Houve captação de recursos oriundos de fontes de fomento externas?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="captacao_recursos" id="captacao_recursos_sim" value="true" {{ old('captacao_recursos') == 'true' ? 'checked' : '' }} autocomplete="off" required>
                            <label class="form-check-label" for="captacao_recursos_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="captacao_recursos" id="captacao_recursos_nao" value="false" {{ old('captacao_recursos') == 'false' ? 'checked' : '' }} autocomplete="off" required>
                            <label class="form-check-label" for="captacao_recursos_nao">Não</label>
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
                        ETAPA 2/4
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
        $(document).ready(function ()
        {
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

            $('#btnAddIntegranteInterno').click(function ()
            {
                var integranteInternoClone = $('.integranteInterno:first').clone();
                integranteInternoClone.find('input, select').val('').removeAttr('disabled');
                $('#integrantesInternos').append(integranteInternoClone);
            });

            $(document).on('click', '.btnRemoverIntegrante', function ()
            {
                if ($('.integranteInterno').length > 1)
                {
                    if (confirm('Tem certeza que deseja remover este integrante interno?'))
                    {
                        $(this).closest('.integranteInterno').remove();
                    }
                }
                else
                {
                    alert('O primeiro integrante interno não pode ser removido.');
                }
            });

            $('#btnAddIntegranteExterno').click(function ()
            {
                var integranteExternoClone = $('.integranteExterno:first').clone();
                integranteExternoClone.find('input, select').val('').removeAttr('disabled');
                $('#integrantesExternos').append(integranteExternoClone);
            });

            $(document).on('click', '.btnRemoverExterno', function ()
            {
                if ($('.integranteExterno').length > 1)
                {
                    if (confirm('Tem certeza que deseja remover este integrante externo?'))
                    {
                        $(this).closest('.integranteExterno').remove();
                    }
                }
                else
                {
                    alert('O primeiro integrante externo não pode ser removido.');
                }
            });
        });
    </script>
@endsection
