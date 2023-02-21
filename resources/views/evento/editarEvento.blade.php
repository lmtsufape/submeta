@extends('layouts.app')

@php
    $i=0; $numCampos=0; $avaliado=false;
    foreach ($evento->trabalhos as $trabalho) {
        $avaliacoes = $trabalho->avaliadors()->where('status', 1)->count();
        if ($avaliacoes > 0) {
            $avaliado = true;
        }
    }
@endphp


@section('content')
<div class="container">
    <div class="row titulo">
        <h1>{{$evento->nome}}</h1>
    </div>

    <form action="{{route('evento.update',$evento->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Tipo--}}
        <div class="row justify-content-start">
            <div class="col-sm-12">{{--Nome do evento--}}
                <label for="nome" class="col-form-label">{{ __('Nome:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input value="{{$evento->nome}}" id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{--End Nome do evento--}}

            {{-- Tipo do evento --}}
            <div class="col-sm-5">
                <label for="tipo" class="col-form-label">{{ __('Tipo:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <!-- <input value="{{$evento->tipo}}" id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required autocomplete="tipo" autofocus> -->
                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" required>
                    <option value="PIBIC" {{ $evento->tipo == "PIBIC" ? 'selected' :'' }}>PIBIC</option>
                    <option value="PIBIC-EM" {{ $evento->tipo == "PIBIC-EM" ?  'selected' :'' }}>PIBIC-EM</option>
                    <option value="PIBIC-AF" {{ $evento->tipo == "PIBIC-AF" ?  'selected' :'' }}>PIBIC-AF</option>
                    <option value="PIBITI" {{ $evento->tipo == "PIBITI" ?  'selected' :'' }}>PIBITI</option>
                    <option value="PIBEX" {{ $evento->tipo == "PIBEX" ?  'selected' :'' }}>PIBEX</option>
                </select>
                @error('tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{-- Tipo do evento --}}

            <div class="col-sm-2">
                <label for="natureza" class="col-form-label">{{ __('Natureza:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <select id="natureza" type="text" class="form-control @error('natureza') is-invalid @enderror" name="natureza" value="{{ old('natureza') }}" required>
                    @foreach ($naturezas as $natureza)
                    @if ($natureza->id === $evento->natureza_id)
                    <option value="{{ $natureza->id }}" selected>{{ $natureza->nome }}</option>
                    @else
                    <option value="{{ $natureza->id }}">{{ $natureza->nome }}</option>
                    @endif
                    @endforeach
                </select>

                @error('natureza')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-2">
                <label for="numParticipantes" class="col-form-label">{{ __('Nº de Discentes:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="numParticipantes" type="number" min="0" max="500" class="form-control @error('numParticipantes') is-invalid @enderror" name="numParticipantes" value="{{ $evento->numParticipantes }}" required autocomplete="numParticipantes" autofocus>

                @error('numParticipantes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end nome | Participantes | Tipo--}}

        <div class="row justify-content-start mb-1 mt-2">

            <div class="col-sm-2">
                <label for="check_docExtra" class="col-form-label">{{ __('Documento extra?') }}</label>
                <input type="checkbox" name="check_docExtra" id="check_docExtra" onclick="showDocumentoExtra()" style="margin-left: 5px" @if($evento->nome_docExtra != null ) checked @endif {{ old('check_docExtra') ? 'checked' : ''}}>
            </div>

            <div class="col-sm-5">
                <label for="consu" class="col-form-label">{{ __('Decisão da Câmara ou Conselho Pertinente: obrigatório? ') }}</label>
                <input type="checkbox" @if($evento->consu) checked @endif name="consu" id="consu">

                @error('consu')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-3">
                <label for="cotaDoutor" class="col-form-label">{{ __('Cota para recém doutor?') }}</label>
                <input type="checkbox" @if($evento->cotaDoutor) checked @endif name="cotaDoutor" id="cotaDoutor">

                @error('cotaDoutor')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{--Nome do Documento Extra--}}
            <div class='col-md-4' style='display:none'>
                <label for="nome_docExtra" class="col-form-label">{{ __('Digite o nome do Documento') }} <span style="color:red; font-weight:bold;">*</span></label>
                <input id="nome_docExtra" type="text" class="form-control @error('nome_docExtra') is-invalid @enderror" name="nome_docExtra" @if($evento->nome_docExtra != null ) value="{{$evento->nome_docExtra}}" @else value="{{ old('nome_docExtra')}}" @endif placeholder="Nome do Documento" autocomplete="nome_docExtra" autofocus>
                @error('nome_docExtra')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-3" style="display: none">
                <label for="obrigatoriedade_docExtra" class="col-form-label">{{ __('Obrigatoriedade: ') }}</label>
                <input type="checkbox" name="obrigatoriedade_docExtra" id="obrigatoriedade_docExtra" style="margin-left: 5px" @if($evento->obrigatoriedade_docExtra != null ) checked @endif {{ old('obrigatoriedade_docExtra') ? 'checked' : ''}}>
                @error('obrigatoriedade_docExtra')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- Descricao Evento --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição:<span style="color: red; font-weight: bold;">*</span></label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" value="{{ $evento->descricao }}" id="descricao" name="descricao" rows="3">{{$evento->descricao}}</textarea>
                    @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-11">
                        <label for="coordenador_id" class="col-form-label">{{ __('Coordenador: ') }}<span style="color: red; font-weight: bold;">*</span></label>

                    </div>
                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="Selecionar" data-toggle="modal" data-target="#modalCoord">
                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                        </a>
                    </div>
                </div>
                <input id="coordenador_id" name="coordenador_id" class="form-control" value="{{$evento->coordenadorId}}" hidden>
                <input style="margin-top: 5px" id="coordenador_name" name="coordenador_name" class="form-control @error('coordenador_id') is-invalid @enderror" value="{{$coordEvent->user->name}}" placeholder="Selecione um Coordenador" required readonly>
            </div>
        </div>

        <!-- Modal Coordenador -->
        <div class="modal fade" id="modalCoord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header" style="overflow-x:auto">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Coordenadores</h5>
                        <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Celular</th>
                                    <th scope="col">Instituição</th>
                                    <th scope="col">Seleção</th>
                                </tr>
                            </thead>
                            <tbody id="projetos">
                                @foreach($coordenadores as $coordenador)
                                <tr>
                                    <td>{{$coordenador->user->name}}</td>
                                    <td>{{$coordenador->user->email}}</td>
                                    @if($coordenador->user->celular != null)
                                    <td>{{$coordenador->user->celular}}</td>
                                    @else
                                    <td>Não Definido</td>
                                    @endif
                                    @if($coordenador->user->instituicao != null)
                                    <td>{{$coordenador->user->instituicao}}</td>
                                    @else
                                    <td>Não Definida</td>
                                    @endif
                                    <td style="text-align-last:center"><input type="button" class="btn-primary btn" value="Definir" onclick="defCoord({{$coordenador->id}},'{{$coordenador->user->name}}')" style="width: 100px"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Projetos</p>
            </div>
        </div>
        {{-- dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">

            {{-- Início da Submissão --}}
            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input value="{{$evento->inicioSubmissao}}" id="inicioSubmissao" type="date" class="form-control @error('inicioSubmissao') is-invalid @enderror" name="inicioSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>{{-- end Início da Submissão --}}
            {{-- Fim da submissão --}}
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input value="{{$evento->fimSubmissao}}" id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime(old('inicioSubmissao'))) . '.' }}</strong>
                </span>
                @enderror
            </div>{{-- end Fim da submissão --}}
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <label for="inicioRevisao" class="col-form-label">{{ __('Início da Avaliação:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input value="{{$evento->inicioRevisao}}" id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

                @error('inicioRevisao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimRevisao" class="col-form-label">{{ __('Fim da Avaliação:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input value="{{$evento->fimRevisao}}" id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

                @error('fimRevisao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime( old('inicioRevisao') )) . '.' }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- inicioRevisao | fimRevisao | inicioResultado | fimResultado--}}
        <div class="row justify-content-left">
            <div class="col-sm-6">
                <label for="resultado_preliminar" class="col-form-label">{{ __('Resultado Preliminar:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="resultado_preliminar" value="{{$evento->resultado_preliminar}}" type="date" class="form-control @error('resultado_preliminar') is-invalid @enderror" name="resultado_preliminar" value="{{ old('resultado_preliminar') }}" required autocomplete="resultado_preliminar" autofocus>

                @error('resultado_preliminar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="inicio_recurso" class="col-form-label">{{ __('Início do recurso:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="inicio_recurso" type="date" value="{{ $evento->inicio_recurso }}" class="form-control @error('inicio_recurso') is-invalid @enderror" name="inicio_recurso" value="{{ old('inicio_recurso') }}" required autocomplete="inicio_recurso" autofocus>

                @error('inicio_recurso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>

        </div>
        <div class="row justify-content-left">
            <div class="col-sm-6">
                <label for="fim_recurso" class="col-form-label">{{ __('Fim do Recurso:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="fim_recurso" type="date" value="{{ $evento->fim_recurso }}" class="form-control @error('fim_recurso') is-invalid @enderror" name="fim_recurso" value="{{ old('fim_recurso') }}" required autocomplete="resultado" autofocus>

                @error('fim_recurso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-6">
                <label for="resultado_final" class="col-form-label">{{ __('Resultado Final:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="resultado_final" type="date" value="{{ $evento->resultado_final }}" class="form-control @error('resultado_final') is-invalid @enderror" name="resultado_final" value="{{ old('resultado_final') }}" required autocomplete="resultado" autofocus>

                @error('resultado_final')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <!-- AKI -->
        <div class="row justify-content-left">
            <div class="col-sm-6">
                <label for="inicioProjeto" class="col-form-label">{{ __('Início do Projeto:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="inicioProjeto" type="date" value="{{ $evento->inicioProjeto }}" class="form-control @error('inicioProjeto') is-invalid @enderror" name="inicioProjeto" value="{{ old('inicioProjeto') }}" required autocomplete="inicioProjeto" autofocus>

                @error('inicioProjeto')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-6">
                <label for="fimProjeto" class="col-form-label">{{ __('Fim do Projeto:') }}<span style="color: red; font-weight: bold;">*</span></label>
                <input id="fimProjeto" type="date" value="{{ $evento->fimProjeto }}" class="form-control @error('fimProjeto') is-invalid @enderror" name="fimProjeto" value="{{ old('fimProjeto') }}" required autocomplete="fimProjeto" autofocus>

                @error('fimProjeto')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Relatórios</p>
            </div>
        </div>
        <div class="row justify-content-left">
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Início do Relatório Parcial:'])
                <input id="dt_inicioRelatorioParcial" type="date" value="{{ $evento->dt_inicioRelatorioParcial }}" class="form-control @error('dt_inicioRelatorioParcial') is-invalid @enderror" name="dt_inicioRelatorioParcial" value="{{ old('dt_inicioRelatorioParcial') }}" required autocomplete="dt_inicioRelatorioParcial" autofocus title="Início para o período do envio do relatório parcial">
                @error('dt_inicioRelatorioParcial')
                <span class="invalid-feedback" role="alert">
                    <strong>Apenas será aceita data posterior ao dia do Resultado Final ({{date('d/m/Y', strtotime($evento->resultado_final ?? ''))}})</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Fim do Relatório Parcial:'])
                <input id="dt_fimRelatorioParcial" type="date" value="{{ $evento->dt_fimRelatorioParcial }}" class="form-control @error('dt_fimRelatorioParcial') is-invalid @enderror" name="dt_fimRelatorioParcial" value="{{ old('dt_fimRelatorioParcial') }}" required autocomplete="dt_fimRelatorioParcial" autofocus title="Final do período do envio do relatório parcial">
                @error('dt_fimRelatorioParcial')
                <span class="invalid-feedback" role="alert">
                    <strong>A data deve ser igual ou posterior a data de início do Relatório Parcial ({{date('d/m/Y', strtotime($evento->dt_inicioRelatorioParcial ?? ''))}})</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Início do Relatório Final:'])
                <input id="dt_inicioRelatorioFinal" type="date" value="{{ $evento->dt_inicioRelatorioFinal }}" class="form-control @error('dt_inicioRelatorioFinal') is-invalid @enderror" name="dt_inicioRelatorioFinal" value="{{ old('dt_inicioRelatorioFinal') }}" required autocomplete="dt_inicioRelatorioFinal" autofocus title="Início para o período do envio do relatório final">
                @error('dt_inicioRelatorioFinal')
                <span class="invalid-feedback" role="alert">
                    <strong>Apenas será aceita data posterior ao fim do Relatório Parcial ({{date('d/m/Y', strtotime($evento->dt_fimRelatorioParcial ?? ''))}})</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Fim do Relatório Final:'])
                <input id="dt_fimRelatorioFinal" type="date" value="{{ $evento->dt_fimRelatorioFinal }}" class="form-control @error('dt_fimRelatorioFinal') is-invalid @enderror" name="dt_fimRelatorioFinal" value="{{ old('dt_fimRelatorioFinal') }}" required autocomplete="dt_fimRelatorioFinal" autofocus title="Final do período do envio do relatório final">
                @error('dt_fimRelatorioFinal')
                <span class="invalid-feedback" role="alert">
                    <strong>A data deve ser igual ou posterior a data de início do Relatório Final ({{date('d/m/Y', strtotime($evento->dt_inicioRelatorioFinal ?? ''))}})</strong>
                </span>
                @enderror
                @endcomponent
            </div>
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Avaliação</p>
            </div>
        </div>

        @if($avaliado)
            <div class="alert alert-primary col-sm-12" role="alert">
                <strong>Você não pode alterar a avaliação após algum trabalho já ter sido avaliado.</strong>
            </div>
        @endif
        
        <div class="my-2" >
            <p style="font-size: 16px">Como a avaliação será realizada?</p>
        </div>

        <div class="mb-2">
            @if (old('tipoAvaliacao') != null)
                <input type="radio" id="radioForm" name="tipoAvaliacao" onchange="displayTipoAvaliacao('form')" 
                    @if((old('tipoAvaliacao') == 'form') || old('tipoAvaliacao') == "") checked @endif value="form" @if($avaliado) disabled @endif>
                <label for="radioForm" style="margin-right: 5px">Formulário (em pdf)</label>

                <input type="radio" id="radioCampos" name="tipoAvaliacao" onchange="displayTipoAvaliacao('campos')" 
                    @if(old('tipoAvaliacao') == 'campos') checked @endif value="campos" @if($avaliado) disabled @endif>
                <label for="radioCampos" style="margin-right: 5px">Barema</label>

                <input type="radio" id="radioLink" name="tipoAvaliacao" onchange="displayTipoAvaliacao('link')" 
                    @if(old('tipoAvaliacao') == 'link') checked @endif value="link" @if($avaliado) disabled @endif>
                <label for="radioLink" style="margin-right: 5px">Link</label><br>
            @else
                <input type="radio" id="radioForm" name="tipoAvaliacao" onchange="displayTipoAvaliacao('form')" 
                @if($evento->tipoAvaliacao == 'form' || $evento->tipoAvaliacao == '') checked @endif value="form" @if($avaliado) disabled @endif>
                <label for="radioForm" style="margin-right: 5px">Formulário (em pdf)</label>

                <input type="radio" id="radioCampos" name="tipoAvaliacao" onchange="displayTipoAvaliacao('campos')" 
                    @if($evento->tipoAvaliacao == 'campos') checked @endif value="campos" @if($avaliado) disabled @endif>
                <label for="radioCampos" style="margin-right: 5px">Barema</label>

                <input type="radio" id="radioLink" name="tipoAvaliacao" onchange="displayTipoAvaliacao('link')" 
                    @if($evento->tipoAvaliacao == 'link') checked @endif value="link" @if($avaliado) disabled @endif>
                <label for="radioLink" style="margin-right: 5px">Link</label><br>
            @endif
        </div>

        <!-- Garante envio do tipo de avaliação, mesmo com a avaliação desativada -->
        @if($avaliado)
            @if($evento->tipoAvaliacao == 'form' || $evento->tipoAvaliacao == '')
                <input type="hidden" id="radioForm" name="tipoAvaliacao" value="form">
            @elseif($evento->tipoAvaliacao == 'campos')
                <input type="hidden" id="radioCampos" name="tipoAvaliacao" value="campos">
            @elseif($evento->tipoAvaliacao == 'link')
                <input type="hidden" id="radioLink" name="tipoAvaliacao" value="link">
            @endif
        @endif

        <div class="row justify-content-center" style="margin-top:10px" id="displayForm">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfEdital">Formulário para avaliador <i>ad hoc</i>:<span style="color: red; font-weight: bold;">*</span></label>
                    @if ($evento->tipoAvaliacao == "form")
                        <a href="{{route('download', ['file' => $evento->formAvaliacaoExterno])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                    @else
                        <a>
                            <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                        </a>
                    @endif
                    <input type="file" accept=".pdf,.doc,.docx,.xlsx,.xls,.csv,.zip" class="form-control-file @error('pdfFormAvalExterno') is-invalid @enderror" name="pdfFormAvalExterno" value="{{ old('pdfFormAvalExterno') }}" id="pdfFormAvalExterno" @if($avaliado) disabled @endif>
                    <small>O arquivo selecionado deve ter até 2mb.</small>
                    @error('pdfFormAvalExterno')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfEdital">Documento auxiliar para Avaliador:</label>
                    @if($evento->docTutorial != null)
                        <a href="{{route('download', ['file' => $evento->docTutorial])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                    @else
                        <a>
                            <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                        </a>
                    @endif
                    <input type="file" class="form-control-file @error('docTutorial') is-invalid @enderror" name="docTutorial" value="{{ old('docTutorial') }}" id="docTutorial" @if($avaliado) disabled @endif>
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('docTutorial')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row justify-content-center" style="margin-top:10px; display: none" id="displayCampos">
            <div class="row align-items-end mb-4">
                <label class="col-sm-3" for="pontuacao">Valor total da pontuação por Barema:<span style="color:red; font-weight:bold;">*</span></label>
                <input type="number" name="pontuacao" min="0" class="col-sm-1 form-control" id="pontuacao" value="{{old('pontuacao')?old('pontuacao'):$pontuacao}}" @if($avaliado) disabled @endif/>
            </div>
            <label>Campos do Barema:</label>
            <table class="table table-bordered col-sm-12" id="dynamicAddRemove">
                <tr>
                    <th>Nome<span style="color:red; font-weight:bold;">*</span></th>
                    <th>Descrição</th>
                    <th>Nota Máxima<span style="color:red; font-weight:bold;">*</span></th>
                    <th>Prioridade<span style="color:red; font-weight:bold;">*</span></th>
                    <th>Ação</th>
                </tr>
                @if ($camposAvaliacao->count() != 0)
                    @php $somaNotas = 0; @endphp
                    @foreach ($camposAvaliacao as $campoAvaliacao)
                        @php $somaNotas += $campoAvaliacao->nota_maxima; @endphp
                    
                        @if ($numCampos == 0)
                        <tr>
                            <td><input type="text" name="inputField[{{$i}}][nome]" class="form-control nome @error('inputField.*.nome') is-invalid @enderror" value="{{ $campoAvaliacao->nome }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td><input type="text" name="inputField[{{$i}}][descricao]" class="form-control descricao @error('inputField.*.descricao') is-invalid @enderror" value="{{ $campoAvaliacao->descricao }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.descricao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td><input type="number" min="1"  step="1" name="inputField[{{$i}}][nota_maxima]" class="form-control nota_maxima @error('inputField.*.nota_maxima') is-invalid @enderror" value="{{ $campoAvaliacao->nota_maxima }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.nota_maxima')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td>
                                <select name="inputField[{{$i}}][prioridade]" class="form-control prioridade @error('inputField.*.prioridade') is-invalid @enderror" @if($avaliado) disabled @endif>
                                    <option value="" >-- ORDEM --</option>
                                    <option value="1" class="ordem_option">1</option>                                  
                                </select>
                                @error('inputField.*.prioridade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary" @if($avaliado) disabled @endif>Adicionar</button></td>
                        </tr>
                        @else
                        <tr>
                            <td><input type="text" name="inputField[{{$i}}][nome]" class="form-control nome @error('inputField.*.nome') is-invalid @enderror" value="{{ $campoAvaliacao->nome }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td><input type="text" name="inputField[{{$i}}][descricao]" class="form-control descricao @error('inputField.*.descricao') is-invalid @enderror" value="{{ $campoAvaliacao->descricao }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.descricao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td><input type="number" min="1"  step="1" name="inputField[{{$i}}][nota_maxima]" class="form-control nota_maxima @error('inputField.*.nota_maxima') is-invalid @enderror" value="{{ $campoAvaliacao->nota_maxima }}" @if($avaliado) disabled @endif/>
                            @error('inputField.*.nota_maxima')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </td>
                            <td>
                                <select name="inputField[{{$i}}][prioridade]" class="form-control prioridade @error('inputField.*.prioridade') is-invalid @enderror" @if($avaliado) disabled @endif>
                                    <option value="" >-- ORDEM --</option>
                                    <option value="1" class="ordem_option">1</option>                                  
                                </select>
                                @error('inputField.*.prioridade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                            <td><button type="button" class="btn btn-outline-danger remove-input-field" name="removeButton[{{$i}}]" @if($avaliado) disabled @endif>Remover</button></td>
                        </tr>
                        @endif
                        @php ++$i; ++$numCampos; @endphp
                    @endforeach
                    
                @else
                    <tr>
                        <td><input type="text" name="inputField[0][nome]" class="form-control nome @error('inputField.*.nome') is-invalid @enderror" value="{{ old('inputField[0][nome]') }}" @if($avaliado) disabled @endif/>
                        @error('inputField.*.nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </td>
                        <td><input type="text" name="inputField[0][descricao]" class="form-control descricao @error('inputField.*.descricao') is-invalid @enderror" value="{{ old('inputField[0][descricao]') }}" @if($avaliado) disabled @endif/>
                        @error('inputField.*.descricao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </td>
                        <td><input type="number" min="1"  step="1" name="inputField[0][nota_maxima]" class="form-control nota_maxima @error('inputField.*.nota_maxima') is-invalid @enderror" value="{{ old('inputField[0][nota_maxima]') }}" @if($avaliado) disabled @endif/>
                        @error('inputField.*.nota_maxima')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </td>
                        <td>
                            <select name="inputField[0][prioridade]" class="form-control prioridade @error('inputField.*.prioridade') is-invalid @enderror" @if($avaliado) disabled @endif>
                                <option value="" selected>-- ORDEM --</option>
                                <option value="1" class="ordem_option">1</option>                                  
                            </select>
                            @error('inputField.*.prioridade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </td>
                        <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary" @if($avaliado) disabled @endif>Adicionar</button></td>
                    </tr>
                    @php ++$i; ++$numCampos; @endphp
                @endif
            </table>

            @if($errors->has('inputField.*'))
                <div class="col-sm-12 alert alert-danger" id="inputFieldError">
                    Você deve preencher os campos obrigatórios.
                </div>
            @endif

            <div class="col-sm-12 alert alert-danger" style="display: none" id="nota_maxima_invalida">
                A soma das notas máximas deve ser igual a pontuação total definida.
            </div>

            <input type="checkbox" id="checkB[0]" checked name="campos[]" value="0" hidden disabled>

            <input type="number" name="somaNotas" value="0" id="somaNotas" hidden>

        </div>

        <div class="col-sm-12 row" style="margin-top:10px; display: none" id="displayLink">
            <label for="link" class="col-form-label">{{ __('Link para o formulário:') }}<span style="color:red; font-weight:bold;">*</span></label>
            <input id="link" type="text" class="form-control @error("link") is-invalid @enderror" name="link" value="{{ ($evento->tipoAvaliacao == "link") ? $evento->formAvaliacaoExterno : old('link') }}" @if($avaliado) disabled @endif>
            @error('link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Documentos</p>
            </div>
        </div>
        
        {{-- Pdf Edital --}}
        <div class="row justify-content-center" style="margin-top:10px">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfEdital">PDF do Edital:<span style="color: red; font-weight: bold;">*</span></label>
                    @if($evento->pdfEdital != null)
                        <a href="{{route('download', ['file' => $evento->pdfEdital])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                    @else
                        <a>
                            <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                        </a>
                    @endif
                    <input type="file" class="form-control-file @error('pdfEdital') is-invalid @enderror" name="pdfEdital" value="{{ old('pdfEdital') }}" id="pdfEdital">
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('pdfEdital')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
       
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="modeloDocumento">Arquivo com os modelos de documentos do edital:</label>
                    @if($evento->modeloDocumento != null)
                        <a href="{{route('download', ['file' => $evento->modeloDocumento])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                    @else
                        <a>
                            <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                        </a>
                    @endif
                    <input type="file" class="form-control-file @error('modeloDocumento') is-invalid @enderror" name="modeloDocumento" value="{{ old('modeloDocumento') }}" id="modeloDocumento">
                    <small>O arquivo selecionado deve ter até 2mb.</small>
                    @error('modeloDocumento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>

           
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="pdfEdital">Formulário de avaliação do relatório:</label>
                    @if($evento->formAvaliacaoRelatorio != null)
                        <a href="{{route('download', ['file' => $evento->formAvaliacaoRelatorio])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                    @else
                    <a>
                        <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                    </a>
                    @endif
                    
                    <input type="file" class="form-control-file @error('pdfFormAvalRelatorio') is-invalid @enderror" name="pdfFormAvalRelatorio" value="{{ old('pdfFormAvalRelatorio') }}" id="pdfFormAvalRelatorio">
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('pdfFormAvalRelatorio')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
        </div>

        <div class="row justify-content-center" style="margin: 20px 0 20px 0">

            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="{{ route('admin.editais') }}" style="width:100%">Cancelar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </form>
</div>



@endsection
@section('javascript')
<script type="text/javascript">
        var i = "{{$i}}";
        var numCampos = "{{$numCampos}}";
        var currentOptions = {'0': ''}

        $(document).ready(function() {
            displayTipoAvaliacao("{{ old('tipoAvaliacao') == null ? $evento->tipoAvaliacao : old('tipoAvaliacao')}}")
            
            if (numCampos > 1) {
                for (let y = 1; y < (numCampos); y++) {
                    $("#displayCampos").append('<input type="checkbox" id="checkB[' + y + ']" checked name="campos[]" value="' + y + '" hidden disabled>');
                    addOrdemPrioridade();
                }
            }
            @if(old('tipoAvaliacao') == 'campos' || $evento->tipoAvaliacao == 'campos')
                $('#somaNotas').val('{{$somaNotas}}');
            @endif

            z = 0
            @foreach($camposAvaliacao as $campoAvaliacao)
                selectId = z
                newOption = "{{$campoAvaliacao->prioridade}}"
                displayPrioridades(selectId, newOption)
                ++z
            @endforeach
            
        });

        // Habilita edição dos campos
        $("input[name^='inputField']").on('change', function() {
            $("input[name^='campos']").prop('disabled', false);
        });

        // Adiciona campo de avaliação
        $("#dynamic-ar").click(function () {
            // Habilita edição dos campos
            $("input[name^='campos']").prop('disabled', false);
            
            $("#dynamicAddRemove").append(
                '<tr><td><input type="text" name="inputField[' + i + '][nome]" class="form-control nome @error("inputField.*.nome") is-invalid @enderror" /></td><td><input type="text" name="inputField[' + i + '][descricao]" class="form-control descricao @error("inputField.*.descricao") is-invalid @enderror"/></td><td><input type="number" min="1"  step="1" name="inputField[' + i + '][nota_maxima]" class="form-control nota_maxima @error("inputField.*.nota_maxima") is-invalid @enderror" /></td><td><select name="inputField[' + i + '][prioridade]" class="form-control prioridade @error("inputField.*.prioridade") is-invalid @enderror"><option value="" selected>-- ORDEM --</option><option value="1" class="ordem_option">1</option></select></td><td><button type="button" class="btn btn-outline-danger remove-input-field" name="removeButton[' + i + ']">Remover</button></td></tr>'
            );

            $("#displayCampos").append('<input type="checkbox" id="checkB[' + i + ']" checked name="campos[]" value="' + i + '" hidden>');

            ++i;
            ++numCampos;
            
            addOrdemPrioridade();
            
            
        });

        function addOrdemPrioridade() {

            $(".prioridade").children().remove(".dynamic");

            // Exibe opções caso estejam ocultas
            $('.ordem_option').show();

            $(".prioridade").each(function() {

                // Resetando os valores selecionados
                $(this).val("").change();

                selectId = $(this).attr('name').replace(/\D/g, "").toString();
                currentOptions[selectId] = '';

                for (let x = 2; x <= numCampos; x++) {
                    
                    $(this).append('<option value="' + x + '" class="ordem_option dynamic">' + x + '</option>')
                    
                }

            })
        }

        
        // Exclui campo de avaliação
        $(document).on('click', '.remove-input-field', function () {
            // Habilita edição dos campos
            $("input[name^='campos']").prop('disabled', false);
            $(this).parents('tr').remove();

            selectId = $(this).attr('name').replace(/\D/g, "").toString();
            currentOption = currentOptions[selectId];

            document.getElementById('checkB[' + selectId + ']').remove();

            $('.ordem_option[value|="' + currentOption + '"]').show();
            delete currentOptions[selectId];

            $('.dynamic[value|="' + numCampos + '"]').remove();

            --numCampos;


        });

        function displayPrioridades(id, newOption) {
            currentOption = currentOptions[id];

            $('.ordem_option[value|="' + currentOption + '"]').show();

            $('.ordem_option[value|="' + newOption + '"]').hide();

            $('select[name="inputField[' + id + '][prioridade]"]').val(newOption);

            currentOptions[id] = newOption;

        }

        $("#dynamicAddRemove").on('change', '.prioridade', function () {

            selectId = $(this).attr('name').replace(/\D/g, "").toString();
            newOption = $(this).val();
            
            displayPrioridades(selectId, newOption);
        });

        $('#pontuacao').on('input', function () {
            validateNotas();
        })

        $("#dynamicAddRemove").on('input', '.nota_maxima', function () {
            validateNotas();
        });

        function validateNotas() {
            pontuacao = $("#pontuacao").val();

            if (pontuacao == "") {
                alert("Escolha o valor total da pontuação antes de adicionar as notas máximas!")
                $('.nota_maxima').val("");
            } else {
                somaNotas = 0;

                $(".nota_maxima").each(function() {
                    valor = Number($(this).val());
                    if  (valor != 0) {
                        somaNotas += valor;
                    }
                    
                });

                $('#somaNotas').val(somaNotas);

                if (somaNotas != pontuacao) {
                    $('.nota_maxima').css('border', '1px solid red');
                    document.getElementById("nota_maxima_invalida").style.display = "";
                } else {
                    $('.nota_maxima').css('border', '');
                    document.getElementById("nota_maxima_invalida").style.display = "none";
                }
            }
        }


        // Tipo de avaliação
        function displayTipoAvaliacao(valor){
        if (valor == "form"){
            document.getElementById("radioForm").checked = true;
            document.getElementById("radioCampos").checked = false;
            document.getElementById("radioLink").checked = false;
            document.getElementById("displayForm").style.display = "";
            document.getElementById("displayCampos").style.display = "none";
            document.getElementById("displayLink").style.display = "none";
        } else if (valor == "campos"){
            document.getElementById("radioForm").checked = false;
            document.getElementById("radioCampos").checked = true;
            document.getElementById("radioLink").checked = false;
            document.getElementById("displayForm").style.display = "none";
            document.getElementById("displayCampos").style.display = "inline";
            document.getElementById("displayLink").style.display = "none";
        } else if (valor == "link") {
            document.getElementById("radioForm").checked = false;
            document.getElementById("radioCampos").checked = false;
            document.getElementById("radioLink").checked = true;
            document.getElementById("displayForm").style.display = "none";
            document.getElementById("displayCampos").style.display = "none";
            document.getElementById("displayLink").style.display = "";
        }
        }

    function defCoord(data, data2) {
        document.getElementById('coordenador_id').value = data;
        document.getElementById('coordenador_name').value = data2;
        $("#modalCoord").modal('hide');

    }

    function showDocumentoExtra() {
        var nome_docExtra = document.getElementById('nome_docExtra');
        var check_docExtra = document.getElementById("check_docExtra");
        var obrigatoriedade_docExtra = document.getElementById('obrigatoriedade_docExtra');
        if (check_docExtra.checked == true) {
            nome_docExtra.parentElement.style.display = '';
            obrigatoriedade_docExtra.parentElement.style.display = '';
        } else {
            nome_docExtra.parentElement.style.display = 'none';
            obrigatoriedade_docExtra.parentElement.style.display = 'none';
        }
    }

    window.onload = showDocumentoExtra();
</script>

    @if($errors->has('somaNotas'))
    <script>
        $('.nota_maxima').css('border', '1px solid red');
        document.getElementById("nota_maxima_invalida").style.display = "";
    </script>
    @endif

@endsection