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

        <form id="formRelatFinal" method="post" action="{{ route('relatorioFinalPibex.storeParte4') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="etapa" value="etapa4">
            <input type="hidden" name="relatorio_id" value="{{ $relatorio->id }}">

            <div class="container card">
                <br>

                <div class="text-center" style="font: bold">
                    <h5>PARTE 4 - ESTATÍSTICAS DA AÇÃO (INDICADORES)</h5>
                </div>

                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="formulario_indicadores" class="col-form-label">
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
                                   id="formulario_indicadores_sim" value="true" {{ old('formulario_indicadores') === 'true' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="formulario_indicadores_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="formulario_indicadores"
                                   id="formulario_indicadores_nao" value="false" {{ old('formulario_indicadores') === 'false' ? 'checked' : '' }} required>
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
                    <div class="col-12">
                        <label class="col-form-label" for="certificacao_adicinonal">
                            <strong>{{ __('O projeto desenvolvido contou com alguma atividade passível de certificação envolvendo o público beneficiado?') }}</strong>
                            <span style="color: red; font-weight:bold;">*</span>
                        </label>

                        <br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                   id="certificacao_adicinonal_sim" value="true" {{ old('certificacao_adicinonal') === 'true' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="certificacao_adicinonal_sim">Sim</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="certificacao_adicinonal"
                                   id="certificacao_adicinonal_nao" value="false" {{ old('certificacao_adicinonal') === 'false' ? 'checked' : '' }} required>
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
                    @forelse (old('nome_participante', []) as $index => $nome)
                        <div class="row participante">
                            <div class="col-6">
                                <label for="nome_participante_{{ $index }}" class="col-form-label">
                                    <strong>{{ __('Nome do Participante:') }}</strong>
                                </label>
                                <input type="text" class="form-control" name="nome_participante[]" id="nome_participante_{{ $index }}" value="{{ $nome }}" autocomplete="nome_participante" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="cpf_participante_{{ $index }}" class="col-form-label">
                                    <strong>{{ __('CPF do Participante:') }}</strong>
                                </label>
                                <input type="text" class="form-control" id="cpf_participante_{{ $index }}" name="cpf_participante[]" value="{{ old('cpf_participante.' . $index) }}" autocomplete="cpf_participante" placeholder="000.000.000-00" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_participante_{{ $index }}" class="col-form-label">
                                    <strong>{{ __('Carga horária do participante:') }}</strong>
                                </label>
                                <input type="number" class="form-control" name="carga_horaria_participante[]" id="carga_horaria_participante_{{ $index }}" value="{{ old('carga_horaria_participante.' . $index) }}" autocomplete="carga_horaria_participante" autofocus>
                            </div>
                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverParticipante">Remover participante</button>
                            </div>
                        </div>
                    @empty
                        <div class="row participante">
                            <div class="col-6">
                                <label for="nome_participante_0" class="col-form-label">
                                    <strong>{{ __('Nome do Participante:') }}</strong>
                                </label>
                                <input type="text" class="form-control" name="nome_participante[]" id="nome_participante_0" value="" autocomplete="nome_participante" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="cpf_participante_0" class="col-form-label">
                                    <strong>{{ __('CPF do Participante:') }}</strong>
                                </label>
                                <input type="text" class="form-control" id="cpf_participante_0" name="cpf_participante[]" value="" autocomplete="cpf_participante" placeholder="000.000.000-00" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="carga_horaria_participante_0" class="col-form-label">
                                    <strong>{{ __('Carga horária do participante:') }}</strong>
                                </label>
                                <input type="number" class="form-control" name="carga_horaria_participante[]" id="carga_horaria_participante_0" value="" autocomplete="carga_horaria_participante" autofocus>
                            </div>
                            <div class="col-12 mt-3 text-right">
                                <button type="button" class="btn btn-danger btnRemoverParticipante">Remover participante</button>
                            </div>
                        </div>
                    @endforelse
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

                        <input type="file" class="form-control-file" name="anexo" value="{{ old('anexo') }}" id="anexo" required>
                    </div>
                </div>
            </div>

            <hr>

            <div class="container card">
                <br>

                <div class="text-left" style="font: bold">
                    <h5>ETAPA 4/4</h5>
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
            document.getElementById('btnAddParticipante').addEventListener('click', function () {
                var participanteClone = document.querySelector('.participante').cloneNode(true);

                var camposClone = participanteClone.querySelectorAll('input, select, textarea');
                camposClone.forEach(function (campo) {
                    campo.value = '';
                });
                var participantesDiv = document.getElementById('participantes');
                participantesDiv.appendChild(participanteClone);
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