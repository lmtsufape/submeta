@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    @php
        $grandesAreas = \App\GrandeArea::all();
        $hoje = \Carbon\Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
    @endphp
    <div class="container">
    <div class="row justify-content-center" style="margin-top: 4rem;">
        <!--Titulos -->
        <div class="col-md-12">
            @if (session('sucesso'))
                <div class="alert alert-success">
                    <strong>{{ session('sucesso') }}</strong>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mt-1" >
                    {{$errors->first()}}
                </div>
            @endif
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">

                            <div class="col-md-12">
                                <h5 style="color: #234B8B; font-weight: bold">Informações da Proposta
                                    @if($trabalho->arquivado == false)
                                        <a title="Arquivar"  href='javascript:arquivar.submit()'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ed1212" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>                                        </a>
                                        <form method="GET" name='arquivar' action='{{route('projeto.arquivar')}}' >
                                            @csrf
                                            <input value='{{$trabalho->id}}' name='trabalho_id' type='hidden'/>
                                            <input value='1' name='arquivar_tipo' type='hidden'/>
                                        </form>
                                    @else
                                        <a title="Desarquivar"  href='javascript:arquivar.submit()'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#808080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h5l2 3h9a2 2 0 0 1 2 2v11zM9.9 16.1L14 12M9.9 11.9L14 16"/></svg>
                                        </a>
                                        <form method="GET" name='arquivar' action='{{route('projeto.arquivar')}}' >
                                            @csrf
                                            <input value='{{$trabalho->id}}' name='trabalho_id' type='hidden'/>
                                            <input value='0' name='arquivar_tipo' type='hidden'/>
                                        </form>
                                    @endif
                                </h5>
                                <hr style="border-top: 1px solid#1492E6">
                            </div>

                            <div class="col-md-12">
                                    @if(Auth::user()->tipo == 'administrador')
                                    <a class="ml-2 mb-5" href="{{ route('trabalho.editar', ['id' => $trabalho->id]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#234B8B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                                    </a>
                                    @endif
                            </div>
                            
                            <div class="col-md-12">
                                <p><b>Edital: </b>{{$evento->nome}}</p>
                            </div>

                            <div class="col-md-12">
                                <p><b>Título: </b>{{$trabalho->titulo}}</p>
                            </div>

                            @if($evento->natureza_id == 3)
                            <div class="col-md-12">
                                <p style="color: #4D4D4D; padding: 0px">
                                    <b>Proponente:</b> {{ App\Proponente::find($trabalho->proponente_id)->user->name }}</p>
                            </div>


                            <div class="col-md-12">
                                @if($evento->tipo == "PIBAC")
                                    <p><b>Área Temática: </b></p>
                                    @foreach($trabalho->area_tematica_pibac as $area_tematica)<p>- {{$area_tematica->nome}}</p> @endforeach
                                @else
                                    <p><b>Área temática: </b>{{$trabalho->areaTematica->nome}}</p>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <p><b>ODS: </b></p>
                                @foreach($trabalho->ods as $ods)<p>- {{$ods->nome}}</p> @endforeach
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Areas-->
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                @if($trabalho->evento->natureza_id != 3)
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Área de Ensino</h5>
                            </div>
                            <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem">
                                    {{App\GrandeArea::where('id', $trabalho->grande_area_id)->first()->nome}} >
                                    {{App\Area::where('id', $trabalho->area_id)->first()->nome}}
                                    @if(App\SubArea::where('id', $trabalho->sub_area_id)->first() != null)
                                        > {{App\SubArea::where('id', $trabalho->sub_area_id)->first()->nome}}@endif

                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
    <!--Informações Proponente-->
    @if($evento->natureza_id != 3)
    <div class="row justify-content-center" style="margin-top: 20px;">
        <br>
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Informações do
                                    Proponente</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">
                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <p style="color: #4D4D4D; padding: 0px">
                                    <b>Nome:</b> {{ App\Proponente::find($trabalho->proponente_id)->user->name }}</p>
                            </div>
                            <div class="col-md-12">
                                <b style="color: #4D4D4D;">Lattes:</b>
                                @if(App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes != null)
                                    <a style="color: #4D4D4D;"
                                       href="{{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}"
                                       target="_blank"
                                    >{{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}</a>
                                @endif
                            </div>

                            @if($evento->tipo != "PIBEX" && $evento->tipo != "CONTINUO" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC")
                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Grupo de Pesquisa: </b>
                                    <a style="color: #4D4D4D;" href="{{ $trabalho->linkGrupoPesquisa }}"
                                       target="_blank"
                                    >{{ $trabalho->linkGrupoPesquisa }}</a>
                                </div>

                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Valor da Planilha de Pontuação: </b>
                                    <a style="color: #4D4D4D;">{{$trabalho->pontuacaoPlanilha}}</a>
                                </div>
                            @endif
                            @if($trabalho->modalidade != null)
                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Modalidade: </b>
                                    <a style="color: #4D4D4D;">{{$trabalho->modalidade}}</a>
                                </div>
                            @endif
                            @if ($evento->numParticipantes == 0) 
                            @php 
                            $arquivo = App\Arquivo::where("trabalhoId", $trabalho->id)->first();
                            @endphp
                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Título do Plano de Trabalho: </b>
                                    <a style="color: #4D4D4D;">{{$arquivo->titulo}}</a>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <label for="anexoProjeto" class="col-form-label font-tam"
                                        style="font-weight: bold">{{ __('Anexo do Plano de Trabalho: ') }}</label>
                                    <a href="{{ route('baixar.plano', ['id' => $arquivo->id])}}">
                                        <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt="">
                                    </a>
                                </div>
                            @endif
                            @if ($trabalho->conflitosInteresse != null)
                                <div class="col-md-12">
                                    <br>
                                    <b style="color: #4D4D4D;">Conflitos de Interesse: </b>
                                    <a style="color: #4D4D4D;">{{ $trabalho->conflitosInteresse }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--Discentes-->
    @if ($evento->numParticipantes != 0)
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Discentes</h5></div>
                            <div class="col-sm-3 text-sm-right">
                                @if($substituicoesPendentes->count() > 0)
                                    <a href="" data-toggle="modal" data-target="#modalVizuSubstituicao" class="button">Substituições
                                        Pendentes</a>
                                    <img class="" src="{{asset('img/icons/warning.ico')}}" style="width:15px" alt="">
                                @else
                                    <a href="" data-toggle="modal" data-target="#modalVizuSubstituicao" class="button">Substituições/Desligamentos</a>
                                @endif
                            </div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->participantes as $participante)
                                <div class="col-sm-1">
                                    <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                </div>
                                <div class="col-sm-5">
                                    <h5>{{$participante->user->name}}</h5>
                                    
                                    <h6>
                                        <a href="" data-toggle="modal"
                                           data-target="#modalVizuParticipante{{$participante->id}}" class="button">Informações</a>
                                    </h6>
                                </div>

                                <!-- Modal visualizar informações participante -->
                                <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1"
                                     role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                                                    Informações Participante
                                                    @if(isset($participante->planoTrabalho))
                                                        @if($participante->planoTrabalho->arquivado == false)

                                                            <a title="Arquivar"  href='javascript:arquivar1{{$participante->id}}.submit()' >
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ed1212" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>                                        </a>
                                                            <form method="GET" name='arquivar1{{$participante->id}}' action='{{route('arquivo.arquivar')}}' >
                                                                @csrf
                                                                <input value='{{$participante->planoTrabalho->id}}' name='arquivo_id' type='hidden'/>
                                                                <input value='1' name='arquivar_tipo' type='hidden'/>
                                                            </form>
                                                        @else
                                                            <a @if($trabalho->arquivado == true) style="pointer-events: none" @endif title="Desarquivar"  href='javascript:arquivar2{{$participante->id}}.submit()'>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#808080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h5l2 3h9a2 2 0 0 1 2 2v11zM9.9 16.1L14 12M9.9 11.9L14 16"/></svg>
                                                            </a>
                                                            <form method="GET" name='arquivar2{{$participante->id}}' action='{{route('arquivo.arquivar')}}' >
                                                                @csrf
                                                                <input value='{{$participante->planoTrabalho->id}}' name='arquivo_id' type='hidden'/>
                                                                <input value='0' name='arquivar_tipo' type='hidden'/>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </h5>

                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body"
                                                 style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1, 'edital' => $evento])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($substituicoesProjeto as $subs)

                                <!-- Modal vizualizar info participante substituido -->
                                    <div class="modal fade"
                                         id="modalVizuParticipanteSubstituido{{$subs->participanteSubstituido()->withTrashed()->first()->id}}"
                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                    <h5 class="modal-title" id="exampleModalLabel"
                                                        style="color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" aria-label="Close"
                                                            style="padding-top: 8px; color:#1492E6"
                                                            onclick="abrirHistorico({{$subs->participanteSubstituido()->withTrashed()->first()->id}}, 1)">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body"
                                                     style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                    @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituto -->
                                    <div class="modal fade"
                                         id="modalVizuParticipanteSubstituto{{$subs->participanteSubstituto()->withTrashed()->first()->id}}"
                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                    <h5 class="modal-title" id="exampleModalLabel"
                                                        style="color:#1492E6">Informações Participante
                                                    </h5>

                                                    <button type="button" class="close" aria-label="Close"
                                                            style="padding-top: 8px; color:#1492E6"
                                                            onclick="abrirHistorico({{$subs->participanteSubstituto()->withTrashed()->first()->id}}, 2)">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body"
                                                     style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                    @include('administrador.vizualizarParticipante')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{--Janelas para aprovação ou reprovação de substituição--}}
    <div class="modal fade" id="modalCancelarSubst" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header" style="overflow-x:auto">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                            Cancelar Substituição</h5>

                        <button type="button" class="close" id="closeCancel" aria-label="Close"
                                style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" id="CancelarSubParticForm"
                              action="{{route('trabalho.aprovarSubstituicao')}}">
                            @csrf
                            <input type="hidden" name="substituicaoID" id="negaId" value="">
                            <input type="hidden" name="aprovar" value="false">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="justificativaTextArea">Justificativa:</label>
                                        <textarea class="form-control"
                                                  id="justificativaTextArea" rows="3"
                                                  name="textJustificativa" minlength="20"
                                                  required></textarea>
                                    </div>
                                    <select class="custom-select" name="selectJustificativa">
                                        <option value="DESISTENCIA">DESISTÊNCIA</option>
                                        <option value="OUTRAS">OUTRAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-end mt-4">
                                <div class="col-md-auto">
                                    <div>
                                        <button type="submit" class="btn btn-success">Cancelar
                                            Substituição
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

        <!-- Modal aprovar substituição -->
    <div class="modal fade" id="modalResultadoSubst" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="overflow-x:auto">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                            Proceder Com Substituição</h5>

                        <button id="closeAcept" type="button" class="close" aria-label="Close"
                                style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>

                <div class="modal-body">
                    <form method="POST" id="AprovarSubParticForm" action="{{route('trabalho.aprovarSubstituicao')}}">
                        @csrf
                        <input type="hidden" name="substituicaoID" id="aprovaId" value="">
                        <input type="hidden" name="aprovar" value="true">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                        <label for="justificativaTextArea">Justificativa:</label>
                                        <textarea class="form-control"
                                                  id="justificativaTextArea" rows="3"
                                                  name="textJustificativa" minlength="20"
                                                  required>Substituição cumpre com todos os requisitos</textarea>
                                </div>
                                <select class="custom-select" name="selectJustificativa">
                                    <option value="DESISTENCIA">DESISTÊNCIA</option>
                                    <option value="OUTRAS">OUTRAS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end mt-4">
                            <div class="col-md-auto">
                                <div>
                                    <button type="submit" class="btn btn-success">Aprovar
                                        Substituição
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Anexos-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <div class="row justify-content-start">
                        @if($evento->tipo != "CONTINUO")
                            {{-- Anexo do Projeto --}}
                                {{-- Arquivo  --}}
                                <div class="col-sm-4">
                                    <label for="anexoProjeto" class="col-form-label font-tam"
                                        style="font-weight: bold">{{ __('Projeto: ') }}</label>
                                    <a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><img class=""
                                                                                                            src="{{asset('img/icons/pdf.ico')}}"
                                                                                                            style="width:40px"
                                                                                                            alt=""></a>

                                </div>

                                @if($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC")
                                    <div class="col-sm-4">
                                        <label for="anexoLatterCoordenador" class="col-form-label font-tam"
                                            style="font-weight: bold">{{ __('Lattes do Coordenador: ') }}</label>
                                        <a href="{{ route('baixar.anexo.lattes', ['id' => $trabalho->id]) }}"> <img class=""
                                                                                                                    src="{{asset('img/icons/pdf.ico')}}"
                                                                                                                    style="width:40px"
                                                                                                                    alt=""></a>

                                    </div>
                                @endif

                                @if($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC")
                                    <div class="col-sm-4">
                                        @if($trabalho->anexoAutorizacaoComiteEtica != null)
                                            <label title="Declaração da autorização especial" for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
                                            <a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                        @else
                                            <label title="Declaração de não necessidade de autorização especial" for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Declaração Autorização Especial: ') }}</label>
                                            @if($trabalho->justificativaAutorizacaoEtica != null)
                                                <a href="{{ route('baixar.anexo.justificativa', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </div>
                                @endif

                                @if($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC")
                                    <div class="col-sm-4">
                                        <label for="anexoPlanilha" class="col-form-label font-tam"
                                            style="font-weight: bold">{{ __('Planilha de Pontuação: ') }}</label>
                                        <a href="{{ route('baixar.anexo.planilha', ['id' => $trabalho->id]) }}"><img
                                                    class="" src="{{asset('img/icons/xlsx.ico')}}" style="width:40px"
                                                    alt=""></a>

                                    </div>
                                @endif

                                @if($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC")
                                    <div class="col-sm-4">
                                        <label for="nomeTrabalho" class="col-form-label font-tam"
                                            style="font-weight: bold">{{ __('Grupo de Pesquisa: ') }}</label>
                                        @if($trabalho->anexoGrupoPesquisa != null)
                                            <a href="{{ route('baixar.anexoGrupoPesquisa', ['id' => $trabalho->id]) }}"><img
                                                        class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px"
                                                        alt=""></a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                @endif

                                @if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM' || $evento->tipo == "PIBEX" ||  $evento->tipo == "PIACEX" || $evento->tipo == "PIBAC")
                                    {{-- Decisão do CONSU --}}
                                    <div class="col-sm-4">
                                        <label title="Decisão da Câmara ou Conselho Pertinente" for="anexoCONSU" class="col-form-label font-tam"
                                            style="font-weight: bold">{{ __('Câmara ou Conselho Pertinente: ') }}</label>
                                        <a href="{{ route('baixar.anexo.consu', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                    </div>
                                @endif
                                @if($evento->tipo == 'PIBIC' && $evento->natureza_id == 2)
                                    <div class="col-sm-4">
                                    <label title="Decisão da Câmara ou Conselho Pertinente" for="anexo_acao_afirmativa" class="col-form-label font-tam" style="font-weight: bold">{{ __('Ação Afirmativa: ') }}</label>
                                    <a href="{{ route('baixar.anexo.acao.afirmativa', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                    </div>
                                @endif
                                @if($evento->tipo == 'PIBITI' && $evento->natureza_id == 2)
                                    <div class="col-sm-4">
                                    <label title="Decisão da Câmara ou Conselho Pertinente" for="anexo_carta_anuencia" class="col-form-label font-tam" style="font-weight: bold">{{ __('Carta de Anuência: ') }}</label>
                                    <a href="{{ route('baixar.anexo.carta.anuencia', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                    </div>
                                @endif
                                @if($evento->nome_docExtra != null)
                                    {{-- Documento Extra --}}
                                    <div class="col-sm-4">
                                        <label title="{{$evento->nome_docExtra}}" for="anexo_docExtra" class="col-form-label font-tam" style="font-weight: bold">{{$evento->nome_docExtra}}:</label>
                                        @if($trabalho->anexo_docExtra)
                                            <a href="{{ route('baixar.anexo.docExtra', ['id' => $trabalho->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                        @else
                                            <a>
                                                <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                        @else
                            <div class="col-sm-4">
                                    <label for="anexo_SIPAC" class="col-form-label font-tam"
                                        style="font-weight: bold">{{ __('Anexo SIPAC: ') }}</label>
                                    <a href="{{ route('baixar.anexo.SIPAC', ['id' => $trabalho->id])}}"><img class=""
                                                                                                            src="{{asset('img/icons/pdf.ico')}}"
                                                                                                            style="width:40px"
                                                                                                            alt=""></a>

                            </div>                                
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!--Relatórios-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Relatórios</h5></div>
                            <div class="col-sm-3 text-sm-right">
                                @if($substituicoesPendentes->count() == 0 || $evento->numParticipantes == 0)
                                    <a href="{{route('planos.listar', ['id' => $trabalho->id])}}" class="button">Listar
                                        Relatórios</a>
                                @else
                                    <a href="{{route('planos.listar', ['id' => $trabalho->id])}}" class="button" title="Existe uma Substituição pendente" style="color: red">Listar
                                        Relatórios</a>
                                @endif
                            </div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <div class="row justify-content-center">
                            {{-- Relatório Parcial  --}}
                            @if($evento->tipo != 'PIBEX' && $evento->tipo != 'PIACEX' && $evento->tipo != 'PIBAC' && $evento->tipo != 'CONTINUO')
                                <div class="col-sm-3">
                                    <label for="dt_inicioRelatorioParcial" class="col-form-label font-tam"
                                        style="font-weight: bold">{{ __('Início do Relatório Parcial: ') }}</label>
                                </div>
                                <div class="col-sm-3">
                                    <input id="dt_inicioRelatorioParcial{{$evento->id}}" type="date" class="form-control"
                                        name="dt_inicioRelatorioParcial" value="{{$evento->dt_inicioRelatorioParcial}}"
                                        required autocomplete="dt_inicioRelatorioParcial" disabled autofocus>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dt_fimRelatorioParcial" class="col-form-label font-tam"
                                        style="font-weight: bold">{{ __('Fim do Relatório Parcial: ') }}</label>
                                </div>
                                <div class="col-sm-3">
                                    <input id="dt_fimRelatorioParcial{{$evento->id}}" type="date" class="form-control"
                                        name="dt_fimRelatorioParcial" value="{{$evento->dt_fimRelatorioParcial}}"
                                        required autocomplete="dt_fimRelatorioParcial" disabled autofocus>
                                </div>
                            @endif
                            {{-- Relatório Final --}}
                            <div class="col-sm-3">
                                <label for="dt_inicioRelatorioFinal" class="col-form-label font-tam"
                                       style="font-weight: bold">{{ __('Início do Relatório Final:') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_inicioRelatorioFinal{{$evento->id}}" type="date" class="form-control"
                                       name="dt_inicioRelatorioFinal" value="{{$evento->dt_inicioRelatorioFinal}}"
                                       required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>
                            </div>
                            <div class="col-sm-3">
                                <label for="dt_fimRelatorioFinal" class="col-form-label font-tam"
                                       style="font-weight: bold">{{ __('Fim do Relatório Final:') }}</label>
                            </div>
                            <div class="col-sm-3">
                                <input id="dt_fimRelatorioFinal{{$evento->id}}" type="date" class="form-control"
                                       name="dt_fimRelatorioFinal" value="{{$evento->dt_fimRelatorioFinal}}" required
                                       autocomplete="dt_fimRelatorioFinal" disabled autofocus>
                            </div>
                        </div>

                        <div class="form-row mt-3">
                            @if($evento->tipo != 'CONTINUO' && $evento->tipo != 'PIBEX' && $evento->tipo != 'PIBAC')
                            <div class="col-sm-11"><h5 style="color: #234B8B; font-weight: bold">Avaliações de
                                    Relatórios</h5></div>
                            @endif

                            @if((($evento->dt_fimRelatorioParcial < $hoje && $hoje<$evento->dt_inicioRelatorioFinal)
                                || ($hoje>$evento->dt_fimRelatorioFinal)) && ($substituicoesPendentes->count() == 0 || $evento->numParticipantes == 0) )
                                <div class="col-md-1 text-sm-right">
                                    <a type="button" value="{{ $trabalho->id }}" id="atribuir1" data-toggle="modal"
                                       data-target="#avaliacaoRelatorioModal">
                                        <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                                    </a>
                                </div>
                            @else
                                @if($evento->tipo != 'CONTINUO' && $evento->tipo != 'PIBEX' && $evento->tipo != 'PIBAC')
                                    <div class="col-md-1 text-sm-right">
                                        <a type="button" value="{{ $trabalho->id }}" id="atribuir1">
                                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                                        </a>
                                    </div>
                                @endif
                            @endif
                            <!-- Modal -->
                            @if($substituicoesPendentes->count() == 0 || $evento->numParticipantes == 0)
                            <div class="modal fade" id="avaliacaoRelatorioModal" data-bs-backdrop="static"
                                 data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                 aria-hidden="true" style="overflow-y: auto">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content modal-submeta modal-xl">
                                        <div class="modal-header modal-header-submeta">
                                            <div class="col-md-8" style="padding-left: 0px">
                                                <h5 class="modal-title titulo-table" id="avaliacaoModalLongTitle">
                                                    @if($substituicoesPendentes->count() == 0 || $evento->numParticipantes == 0) Seleciones o(s) avaliador(es) @else Pendências de Substituição @endif</h5>
                                            </div>
                                            <div class="col-md-4" style="text-align: right">
                                                <button type="button" id="enviarConviteButton" class="btn btn-info"
                                                        data-toggle="modal" onclick="abrirModalConviteRelatorio()">
                                                    Enviar Convites
                                                </button>
                                                <button type="button" class="close" aria-label="Close"
                                                        data-dismiss="modal"
                                                        style="color: rgb(182, 182, 182);padding-right: 0px;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        @if(isset($participante->planoTrabalho) || $evento->numParticipantes == 0)
                                        <div class="modal-body">
                                            @if (session('error'))
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <p>{{ session('error') }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <form action="{{ route('avaliacaoRelatorio.atribuicao.avaliador') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                                                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                                @if(($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC") && $evento->dt_fimRelatorioParcial < $hoje && $hoje<$evento->dt_inicioRelatorioFinal)
                                                    <input type="hidden" name="tipo_relatorio" value="Parcial">
                                                    @php $tipoTemp = "Parcial"; @endphp
                                                @else
                                                    <input type="hidden" name="tipo_relatorio" value="Final">
                                                    @php $tipoTemp = "Final"; @endphp
                                                @endif
                                                <div class="form-group">
                                                    <div class="row" style="margin-left: 2px;margin-bottom: 1px">
                                                        <div class="col-md-6">
                                                            @if(($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC") && $evento->dt_fimRelatorioParcial < $hoje && $hoje<$evento->dt_inicioRelatorioFinal)
                                                                <label for="exampleFormControlSelect2"
                                                                       style="font-size: 16px;">Selecione o(s) avaliador(es)
                                                                    para a(s) avaliacões de relatorio parcial</label>
                                                            @else
                                                                <label for="exampleFormControlSelect2"
                                                                       style="font-size: 16px;">Selecione o(s) avaliador(es)
                                                                    para a(s) avaliacões de relatorio final</label>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3 offset-md-3" style="display:flex; align-items: end; max-width: 250px;">
                                                            <input type="text" class="form-control form-control-edit" placeholder="Nome do avaliador" onkeyup="buscarAvalRelatorio(this)"> <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
                                                        </div>
                                                    </div>
                                                    @if ($evento->numParticipantes == 0)
                                                        <div class="col-md-6">
                                                            <label style="font-weight: bold;font-size: 18px">Plano: {{$arquivo->titulo}}</label>
                                                        </div>
                                                        @php
                                                            $avaliacoesId = \App\AvaliacaoRelatorio::where("arquivo_id",$arquivo->id)->where("tipo",$tipoTemp)->pluck('user_id');
                                                            $avalProjeto = \Illuminate\Support\Facades\DB::table('users')->join('avaliadors','users.id','=','avaliadors.user_id')->whereNotIn('users.id', $avaliacoesId)->orderBy('users.name')->get();
                                                        @endphp

                                                        <select name="avaliadores_{{$arquivo->id}}_id[]" multiple
                                                            class="form-control" id="avaliacaoSelect"
                                                            style="height: 200px;font-size:15px">
                                                        @foreach ($avalProjeto as $avaliador)
                                                                <option value="{{ $avaliador->user_id }}"> {{ $avaliador->name }}
                                                                    > {{$avaliador->instituicao ?? 'Instituição Indefinida'}}
                                                                    > {{$avaliador->tipo}}
                                                                    > {{$avaliador->email}}</option>
                                                        @endforeach
                                                        </select>
                                                    @else
                                                    @foreach($trabalho->participantes as $participante)
                                                        @if($participante->planoTrabalho != null)
                                                            <div class="col-md-6">
                                                                <label style="font-weight: bold;font-size: 18px">Plano: {{$participante->planoTrabalho->titulo}}</label>
                                                            </div>
                                                            @php
                                                                $avaliacoesId = \App\AvaliacaoRelatorio::where("arquivo_id",$participante->planoTrabalho->id)->where("tipo",$tipoTemp)->pluck('user_id');
                                                                $avalProjeto = \Illuminate\Support\Facades\DB::table('users')->join('avaliadors','users.id','=','avaliadors.user_id')->whereNotIn('users.id', $avaliacoesId)->orderBy('users.name')->get();
                                                            @endphp

                                                            <select name="avaliadores_{{$participante->planoTrabalho->id}}_id[]" multiple
                                                                    class="form-control" id="avaliacaoSelect"
                                                                    style="height: 200px;font-size:15px">
                                                                @foreach ($avalProjeto as $avaliador)
                                                                        <option value="{{ $avaliador->user_id }}"> {{ $avaliador->name }}
                                                                            > {{$avaliador->instituicao ?? 'Instituição Indefinida'}}
                                                                            > {{$avaliador->tipo}}
                                                                            > {{$avaliador->email}}</option>

                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    <small id="emailHelp" class="form-text text-muted">Segure SHIFT do
                                                        teclado para selecionar mais de um.</small>
                                                </div>

                                                <div>
                                                    <button type="submit" class="btn btn-info" style="width: 100%">
                                                        Atribuir
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                        @else
                                            <div class="modal-body">
                                                <h4>Existem solicitações de substituição pendentes, por favor verifique-as antes de prosseguir</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        @if(count($arquivos) > 0 && ($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC" && $evento->tipo != 'CONTINUO'))
                            <div class="row justify-content-start" style="alignment: center">
                                <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliações de Relatórios Parciais</h6></div>
                            </div>
                            @for ($i = 0; $i < count($arquivos); $i++)
                                <div class='row justify-content-start' style='margin-top:40px;'>
                                <h6 class='col-4' style="color: black; font-weight: bold">Título:<span style="font-weight: normal"> {{$arquivos[$i]->titulo}}</span><h6>
                                    <h6 class='col-9' style="color: black; font-weight: bold">Média das avaliações:<span style="font-weight: normal"> {{$mediaAval[$i]['relatorio_parcial']}}</span><h6>
                                    <h6 class='col-4' style="color: black; font-weight: bold">Média da apresentação:<span style="font-weight: normal"> {{$mediaAval[$i]['apresentacao_parcial']}}</span><h6>
                                    <h6 class='col-3' style="color: black; font-weight: bold">Avaliações pendentes: <span style="font-weight: normal"> {{$mediaAval[$i]['pendentes_parcial']}}</span><h6>   
                                    <br><br>
                                </div>
                                <div class="row justify-content-start" style="alignment: center">
                                    @foreach($mediaAval[$i]['avaliacoes_parciais'] as $aval)
                                        <div class="col-sm-1" style="margin-bottom: 7px">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-3">
                                            <h5>{{\App\User::find($aval->user_id)->name}}</h5>
                                            <h6><a href="" data-toggle="modal"
                                                data-target="#modalVizuRelatParcial{{$aval->id}}" class="button">
                                                    @if($aval->nota == null) Pendente </a>@else Avaliação</a> @endif</h6>
                                            @if($aval->nota == null)
                                            <h6><a href="" data-toggle="modal"
                                                data-target="#removerAvaliadorReltorioParcial{{$aval->id}}" class="button"><b style="color: red">Remover</b></a></h6>
                                            @endif
                                        </div>

                                        <!-- Modal Remover -->
                                        <div class="modal fade" id="removerAvaliadorReltorioParcial{{ $aval->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Remover Avaliador Do Relatório Parcial</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Você tem certeza que deseja remover o avaliador: {{ $aval->user->name }}?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <a type="button" class="btn btn-danger" href="{{route('avaliacaoRelatorio.remover.avaliador',$aval->id)}}">Remover</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Modal visualizar informações participante -->
                                        <div class="modal fade" id="modalVizuRelatParcial{{$aval->id}}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                                                            Avaliação do relatório parcial @if($aval->nota == null) <b style="color: red">Pendente</b>@endif</h5>

                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body"
                                                        style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                        @include('avaliacaoRelatorio.avaliacao', ['avaliacao' => $aval])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endfor 
                        @endif

                        @if(count($arquivos) > 0)
                            @foreach ($mediaAval as $aval)
                                @if(count($aval['avaliacoes_finais']) > 0)
                                <br><hr style="border-top: 1px solid#1492E6">
                                <div class="row justify-content-start" style="alignment: center" >
                                    <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliações de Relatórios Finais</h6></div>
                                </div>


                                @for ($i = 0; $i < count($arquivos); $i++)
                                    <div class='row justify-content-start'  style='margin-top:40px;'>
                                        <h6 class='col-4' style="color: black; font-weight: bold">Título:<span style="font-weight: normal"> {{$arquivos[$i]->titulo}}</span><h6>
                                    </div>
                                    <div class='row justify-content-start'>
                                        <h6 class='col-4' style="color: black; font-weight: bold">Média das avaliações:<span style="font-weight: normal"> {{$mediaAval[$i]['relatorio_final']}}</span><h6>
                                        <h6 class='col-4' style="color: black; font-weight: bold">Média da apresentação:<span style="font-weight: normal"> {{$mediaAval[$i]['apresentacao_final']}}</span><h6>
                                        <h6 class='col-3' style="color: black; font-weight: bold">Avaliações pendentes: <span style="font-weight: normal"> {{$mediaAval[$i]['pendentes_final']}}</span><h6>   
                                        <br><br>
                                    </div>
                                    <div class="row justify-content-start" style="alignment: center">
                                        @foreach($mediaAval[$i]['avaliacoes_finais'] as $aval)
                                            <div class="col-sm-1" style="margin-bottom: 7px">
                                                <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                            </div>
                                            <div class="col-sm-3">
                                                <h5>{{\App\User::find($aval->user_id)->name}}</h5>
                                                <h6><a href="" data-toggle="modal"
                                                    data-target="#modalVizuRelatFinal{{$aval->id}}" class="button">
                                                        @if($aval->nota == null) Pendente </a>@else Avaliação</a> @endif</h6>
                                                @if($aval->nota == null)
                                                <h6><a href="" data-toggle="modal"
                                                    data-target="#removerAvaliadorReltorioFinal{{$aval->id}}" class="button"><b style="color: red">Remover</b></a></h6>
                                                @endif

                                            </div>

                                            <!-- Modal Remover -->
                                            <div class="modal fade" id="removerAvaliadorReltorioFinal{{ $aval->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Remover Avaliador Do Relatório Final</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Você tem certeza que deseja remover o avaliador: {{ $aval->user->name }}?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <a type="button" class="btn btn-danger" href="{{route('avaliacaoRelatorio.remover.avaliador',$aval->id)}}">Remover</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal visualizar informações participante -->
                                            <div class="modal fade" id="modalVizuRelatFinal{{$aval->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">

                                                        <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                            <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                                                                Avaliação do relatório final @if($aval->nota == null) <b style="color: red">Pendente</b>@endif</h5>

                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body"
                                                            style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                            @include('avaliacaoRelatorio.avaliacao', ['avaliacao' => $aval])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endfor
                                @break
                                @endif
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!--Avaliadores-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Avaliadores</h5></div>
                            @if($hoje >= $evento->inicioRevisao && $hoje <= $evento->fimRevisao)
                                <div class="col-md-1 text-sm-right">
                                    <a type="button" value="{{ $trabalho->id }}" id="atribuir1" data-toggle="modal" data-target="#avaliadorModalCenter">
                                        <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                                    </a>
                                </div>
                            @endif
                            <!-- Modal -->
                            <div class="modal fade" id="avaliadorModalCenter" data-bs-backdrop="static"
                                 data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                 aria-hidden="true" style="overflow-y: auto">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content modal-submeta modal-xl">
                                        <div class="modal-header modal-header-submeta">
                                            <div class="col-md-8" style="padding-left: 0px">
                                                <h5 class="modal-title titulo-table" id="avaliadorModalLongTitle">
                                                    Seleciones o(s) avaliador(es)</h5>
                                            </div>
                                            <div class="col-md-4" style="text-align: right">
                                                <button type="button" id="enviarConviteButton" class="btn btn-info"
                                                        data-toggle="modal" onclick="abrirModalConvite()">
                                                    Enviar Convites
                                                </button>
                                                <button type="button" class="close" aria-label="Close"
                                                        data-dismiss="modal"
                                                        style="color: rgb(182, 182, 182);padding-right: 0px;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            @if (session('error'))
                                                <div class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <p>{{ session('error') }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <form action="{{ route('admin.atribuicao.projeto') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                                                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                                <div class="form-group align-items-start">
                                                    <div class="row" style="margin-left: 2px;margin-bottom: 1px">

                                                        <div class="col-md-4">
                                                            <label for="exampleFormControlSelect2"
                                                                   style="font-size: 16px;">Selecione o(s) avaliador(es)
                                                                para esse projeto</label>
                                                        </div>


                                                        <div class="col-md-3"
                                                             style="text-align: center;overflow-y:  auto;overflow-x:  auto">

                                                            <select class="form-control" id="grandeArea"
                                                                    name="grande_area_id" onchange="areasFiltro()">
                                                                <option value="" disabled selected hidden>-- Grande Área
                                                                    --
                                                                </option>
                                                                @foreach($grandesAreas as $grandeArea)
                                                                    <option title="{{$grandeArea->nome}}"
                                                                            value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2"
                                                             style="text-align: center;overflow-y:  auto;overflow-x:  auto">
                                                            <input type="hidden" id="oldArea" value="{{ old('area') }}">
                                                            <select class="form-control @error('area') is-invalid @enderror"
                                                                    id="area" name="area_id"
                                                                    onchange="(consultaExterno(),consultaInterno())">
                                                                <option value="" disabled selected hidden>-- Área --
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-3" style="display:flex; align-items: end;">
                                                        <input type="text" class="form-control form-control-edit" placeholder="Nome do avaliador" onkeyup="buscar(this)" style="max-width: 200px;"> <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
                                                        </div>

                                                    </div>
                                                   
                                                    @if($evento->natureza_id != 3)
                                                    <div class="col-md-6">
                                                        <label style="font-weight: bold;font-size: 18px">Internos</label>
                                                    </div>
                                                    <input type="hidden" id="oldAvalInterno"
                                                           value="{{ old('exampleFormControlSelect2') }}">
                                                    <select name="avaliadores_internos_id[]" multiple
                                                            class="form-control" id="exampleFormControlSelect2"
                                                            style="height: 200px;font-size: 15px">

                                                        @foreach ($trabalho->avaliadors as $avaliador)
                                                            @if(($avaliador->tipo == "Interno" && $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 1) ||
                                                                (($avaliador->user->instituicao == "UFAPE" || $avaliador->user->instituicao == "Universidade Federal do Agreste de Pernambuco") && ($avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == null || $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 1) ))
                                                                <option value="{{ $avaliador->id }}">{{ $avaliador->user->name }}
                                                                    > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}}
                                                                    > {{$avaliador->area->nome ?? 'Indefinida'}}
                                                                    > {{$avaliador->user->email}}</option>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($trabalho->aval as $avaliador)
                                                            @if($avaliador->tipo == "Interno" || $avaliador->user->instituicao == "UFAPE" || $avaliador->user->instituicao == "Universidade Federal do Agreste de Pernambuco")
                                                                <option value="{{ $avaliador->id }}"> {{ $avaliador->user->name }}
                                                                     > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}}
                                                                     > {{$avaliador->area->nome ?? 'Indefinida'}}
                                                                     > {{$avaliador->user->email}}</option>
                                                                @endif
                                                        @endforeach
                                                    </select>
                                                    @endif

                                                    <div class="col-md-6">
                                                        <label style="font-weight: bold;font-size: 18px"><i>Ad Hoc</i></label>
                                                    </div>

                                                    <input type="hidden" id="trab" value="{{$trabalho->id}}">
                                                    <input type="hidden" id="oldAvalExterno"
                                                           value="{{ old('exampleFormControlSelect3') }}">
                                                    <select name="avaliadores_externos_id[]" multiple
                                                            class="form-control" id="exampleFormControlSelect3"
                                                            style="height: 200px;font-size:15px">
                                                        @foreach ($trabalho->avaliadors as $avaliador)
                                                            @if($avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 2 || ($avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == null && $avaliador->tipo == "Interno"))
                                                                <option value="{{ $avaliador->id }}">{{ $avaliador->user->name }}
                                                                    > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}}
                                                                    > {{$avaliador->area->nome ?? 'Indefinida'}}
                                                                    > {{$avaliador->user->email}}</option>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($trabalho->aval as $avaliador)
                                                                <option value="{{ $avaliador->id }}"> {{ $avaliador->user->name }}
                                                                    > {{$avaliador->user->instituicao ?? 'Instituição Indefinida'}}
                                                                    > {{$avaliador->area->nome ?? 'Indefinida'}}
                                                                    > {{$avaliador->user->email}}</option>
                                                        @endforeach
                                                    </select>

                                                    <small id="emailHelp" class="form-text text-muted">Segure SHIFT do
                                                        teclado para selecionar mais de um.</small>
                                                </div>

                                                <div>
                                                    <button type="submit" class="btn btn-info" style="width: 100%">
                                                        Atribuir
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        <!--Comissão Interna-->
                        <div class="row justify-content-start" style="alignment: center">
                            <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliadores -
                                    Internos</h6></div>
                        </div>
                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->avaliadors as $avaliador)
                                @if(($avaliador->tipo == 'Interno' && ($avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == null || $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 2 || $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 3)) || (($avaliador->user->instituicao == "UFAPE" || $avaliador->user->instituicao == "Universidade Federal do Agreste de Pernambuco") && $avaliador->tipo == null && ($avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == null || $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 2 || $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso == 3)))
                                    @if ($evento->tipoAvaliacao == 'form')
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>
                                            @php
                                                $parecerInterno = App\ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                            @endphp
                                            <h9>@if($parecerInterno == null) Pendente @else <a
                                                        href="{{ route('admin.visualizarParecerInterno', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif
                                            </h9>
                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerInterno{{ $avaliador->id }}" >
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @elseif ($evento->tipoAvaliacao == "campos")
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>
                                            @php
                                                $avaliacaoTrabalho = App\AvaliacaoTrabalho::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                            @endphp
                                            <h9>@if($avaliacaoTrabalho == null) Pendente @else <a
                                                        href="{{ route('admin.visualizarParecerBarema', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id, 'evento_id' => $evento->id]) }}">Avaliado</a> @endif
                                            </h9>
                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerInterno{{ $avaliador->id }}" >
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @elseif ($evento->tipoAvaliacao == "link")
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>

                                                <h9>@if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->status == false)
                                                        Pendente @else <a
                                                                href="{{ route('admin.visualizarParecerLink', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif
                                                </h9>

                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerAdHoc{{ $avaliador->id }}">
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @endif
                                @endif
                                <!-- Modal Remover -->
                                    <div class="modal fade" id="removerInterno{{ $avaliador->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Remover Avaliador Interno</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Você tem certeza que deseja remover o avaliador: {{ $avaliador->user->name }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <a type="button" class="btn btn-danger" href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id,'flag'=>1]) }}">Remover</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        <br>
                        <!--Comissão Externa-->
                        <div class="row justify-content-start" style="alignment: center">
                            <div class="col-md-11"><h6 style="color: #234B8B; font-weight: bold">Avaliadores -
                                    <i>Ad Hoc</i></h6></div>
                        </div>
                        <div class="row justify-content-start" style="alignment: center">
                            @foreach($trabalho->avaliadors as $avaliador)
                                @php
                                    $acesso = $avaliador->trabalhos()->where("trabalho_id",$trabalho->id)->first()->pivot->acesso;
                                    $instituicao_avaliador = $avaliador->user->instituicao;
                                @endphp
                                @if(
                                        ($acesso == null && $avaliador->tipo == "Externo")
                                        ||
                                        $acesso == 1
                                        ||
                                        $acesso == 3
                                        ||
                                        (
                                            (
                                                $instituicao_avaliador != "UFAPE"
                                                &&
                                                $instituicao_avaliador != "Universidade Federal do Agreste de Pernambuco"
                                            )
                                            &&
                                            $avaliador->tipo == null
                                            &&
                                            (
                                                $acesso == null
                                                ||
                                                $acesso == 1
                                                ||
                                                $acesso == 3
                                            )
                                        )
                                    )
                                    @if ($evento->tipoAvaliacao == 'form')
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>

                                                <h9>@if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->status == false)
                                                        Pendente @else <a
                                                                href="{{ route('admin.visualizarParecer', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif
                                                </h9>

                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerAdHoc{{ $avaliador->id }}">
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @elseif ($evento->tipoAvaliacao == "campos")
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>
                                            @php
                                                $avaliacaoTrabalho = App\AvaliacaoTrabalho::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                            @endphp
                                            <h9>@if($avaliacaoTrabalho == null) Pendente @else <a
                                                        href="{{ route('admin.visualizarParecerBarema', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id, 'evento_id' => $evento->id]) }}">Avaliado</a> @endif
                                            </h9>
                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerInterno{{ $avaliador->id }}" >
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @elseif ($evento->tipoAvaliacao == "link")
                                        <div class="col-sm-1">
                                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                        </div>
                                        <div class="col-sm-5">
                                            <h5>{{$avaliador->user->name}}</h5>

                                                <h9>@if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->status == false)
                                                        Pendente @else <a
                                                                href="{{ route('admin.visualizarParecerLink', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}">Avaliado</a> @endif
                                                </h9>

                                            <br>
                                            <a href="" data-toggle="modal" data-target="#removerAdHoc{{ $avaliador->id }}">
                                                Remover
                                            </a>
                                            <br>
                                            <a href="{{ route('admin.reenviar.atribuicao.projeto', ['evento_id' => $evento->id, 'avaliador_id'=>$avaliador->id, 'trabalho_id' => $trabalho->id]) }}">
                                                Reenviar convite
                                            </a>
                                        </div>
                                    @endif
                                @endif

                                <!-- Modal Remover -->
                                    <div class="modal fade" id="removerAdHoc{{ $avaliador->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Remover Avaliador Ad Hoc</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Você tem certeza que deseja remover o avaliador: {{ $avaliador->user->name }}?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <a type="button" class="btn btn-danger" href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id,'flag'=>0]) }}">Remover</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Aprovar ou Negar Proposta-->
    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Recomendação da Proposta</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">
                        <form action="{{ route('trabalho.aprovarProposta', ['id' => $trabalho->id]) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <a class="col-md-12 text-left"
                                       style="padding-left: 0px;color: #234B8B; font-weight: bold;">Comentário</a>
                                    <textarea class="col-md-12" id="comentario" name="comentario"
                                              style="border-radius:5px 5px 0 0;height: 71px;" required
                                    >@if($trabalho->comentario != null){{$trabalho->comentario}}@endif</textarea>
                                </div>
                                <div class="col-md-3" style="margin-top: 15px">
                                    <input class="col-md-1" type="radio" id="aprovado" name="statusProp"
                                           value="aprovado" required
                                           @if($trabalho->status=="aprovado") checked @endif>
                                    <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Recomendada</a>
                                    <br>

                                    <input class="col-md-1" type="radio" id="reprovado" name="statusProp"
                                           value="reprovado" required
                                           @if($trabalho->status=="reprovado") checked @endif>
                                    <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Não Recomendada</a>
                                </div>
                            </div>

                            <button id="enviar" name="enviar" type="submit" class="btn btn-primary"
                                    style="padding: 5px 10px;font-size: 18px;">
                                Salvar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.analisar', ['evento_id' => $evento->id]) }}" class="btn btn-primary"
               style="font-size: 16px; float: right; margin-top: 10px;">Voltar</a>

        </div>
    </div>


    <!-- Modal visualizar substituição-->
    <div class="modal fade" id="modalVizuSubstituicao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header" style="overflow-x:auto">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #234B8B; font-weight: bold">
                        Substituição de Discentes</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="padding-top: 8px; color:#1492E6">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="TabControl">
                        <div id="header" style="border: none">
                            <ul class="abas" style="list-style-type:none;">
                                <li>
                                    <div class="aba1 aba">
                                        <span>Substituções </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="aba2 aba">
                                        <span> Histórico</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="aba3 aba">
                                        <span> Desligamentos</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="content">
                            <div class="justify-content-center conteudo" id="tela1"
                                 style="margin-top: 0px;border: none;overflow-x: auto;">
                                <div class="col-md-12" id="tela1" style="padding: 0px">
                                    <div class="card" id="tela1" style="border-radius: 5px">
                                        <div class="card-body" id="tela1"
                                             style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="" id="tela1">
                                                <div class="justify-content-start" id="tela1" style="alignment: center">
                                                    @foreach($substituicoesPendentes as $subs)
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold"
                                                                    class="col-md-12">Substituição</h5>
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}"
                                                                             style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4"
                                                                         style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuParticipante({{$subs->participanteSubstituido()->withTrashed()->first()->id}})"
                                                                           class="button">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                    <div class="col-md-1 text-left"
                                                                         style="padding-left: 0px;">
                                                                        <img src="{{asset('img/seta.png')}}"
                                                                             style="width:40px;margin-left: 5px;margin-right: 10px;"
                                                                             alt="">
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}"
                                                                             style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4"
                                                                         style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="fecharModalSubstituto({{$subs->participanteSubstituto()->withTrashed()->first()->id}})"
                                                                           class="button">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h5 style="color: #234B8B; font-weight: bold"
                                                                    class="col-md-12 text-center"> Ações</h5>
                                                                <div class="col-md-12 text-center" id="tela1"
                                                                     style="border: solid#1111; padding: 10px; ">
                                                                    <form>
                                                                        <input type="radio" id="aceitar" name="opcao"
                                                                               value="aceitar"> Aprovar
                                                                        <input type="radio" id="negar" name="opcao"
                                                                               value="negar"> Negar
                                                                        <br>
                                                                        <button id="submeter" name="submeter"
                                                                                type="button" class="btn btn-primary"
                                                                                style="padding: 5px 10px;"
                                                                                value="{{$subs->id}}">
                                                                            Submeter
                                                                        </button>
                                                                    </form>
                                                                    {{--fsasfafsasaffafsafas--}}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="justify-content-center conteudo" id="tela2"
                                 style="margin-top: 0px;border: none;overflow-x: auto;">
                                {{--<div class="col-md-12" id="tela2" style="padding: 0px">
                                    <div class="card" id="tela2" style="border-radius: 5px">
                                        <div class="card-body" id="tela2" style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="" id="tela2">
                                                <div class="justify-content-start" id="tela2" style="alignment: center">
                                                    @foreach($substituicoesProjeto as $subs)
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold" class="col-md-12">Substituição</h5>
                                                                <div class="row">
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuPartici({{$subs->participanteSubstituido()->withTrashed()->first()->id}})" class="button tiro">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</a>
                                                                    </div>
                                                                    <div class="col-md-1 text-left" style="padding-left: 0px;">
                                                                        <img src="{{asset('img/seta.png')}}" style="width:40px;margin-left: 5px;margin-right: 10px;" alt="">
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}" style="width:50px" alt="">
                                                                    </div>
                                                                    <div class="col-md-4" style="padding-left: 20px;padding-right: 5px;">
                                                                        <a onclick="vizuPartici({{$subs->participanteSubstituto()->withTrashed()->first()->id}})" class="button">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                @if($subs->tipo == 'ManterPlano')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Manter Plano</>
                                                                @elseif($subs->tipo == 'TrocarPlano')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Alterar Plano</h5>
                                                                @elseif($subs->tipo == 'Completa')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Tipo: Completa</h5>
                                                                @endif
                                                                @if($subs->status == 'Finalizada')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Concluída</h5>
                                                                @elseif($subs->status == 'Negada')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Negada</h5>
                                                                @elseif($subs->status == 'Em Aguardo')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Status: Pendente</h5>
                                                                @endif
                                                                @if($subs->status == 'Em Aguardo')
                                                                    <h5 style="color: #234B8B; " class="col-md-12 text-center">Pendente</h5>
                                                                @else
                                                                    <a onclick="vizuJustificativa('{{$subs->justificativa}}')" class="button"><h5 style="color: #234B8B; " class="col-md-12 text-center">Visualizar</h5></a>
                                                                @endif

                                                            </div>
                                                        </div>

                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div style="margin-top: 5px">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-3">
                                                <h6 class="card-title" style="color:#234B8B">
                                                    Participante Substituído
                                                </h6>
                                            </div>
                                            <div class="col-3">
                                                <h6 class="card-title" style="color:#234B8B">
                                                    Participante Substituto
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="card-title" style="color:#234B8B">
                                                    Tipo
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="card-title" style="color:#234B8B">
                                                    Status
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <h6 class="card-title" style="color:#234B8B">
                                                    Justificativa
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        @foreach($substituicoesProjeto as $subs)
                                            <div class="row" style="margin-bottom: 20px;">
                                                <div class="col-3">
                                                    <a href="" data-toggle="modal" class="button"
                                                       onclick="fecharModalSubstituido({{$subs->participanteSubstituido()->withTrashed()->first()->id}})">
                                                        <h6 style="font-size:18px;  color: black">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h6>
                                                    </a>
                                                    <h6 style="color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_entrada))}}
                                                        - @if($subs->participanteSubstituido()->withTrashed()->first()->data_saida == null)
                                                            Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_saida))}} @endif</h6>
                                                </div>
                                                <div class="col-3">
                                                    <a href="" data-toggle="modal" class="button"
                                                       onclick="fecharModalSubstituto({{$subs->participanteSubstituto()->withTrashed()->first()->id}})">
                                                        <h6 style="font-size:18px;  color: black">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h6>
                                                    </a>
                                                    <h6 style="color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_entrada))}}
                                                        - @if($subs->participanteSubstituto()->withTrashed()->first()->data_saida == null)
                                                            Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_saida))}} @endif</h6>
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->tipo == 'ManterPlano')
                                                        <h6>Manter Plano</h6>
                                                    @elseif($subs->tipo == 'TrocarPlano')
                                                        <h6>Alterar Plano</h6>
                                                    @elseif($subs->tipo == 'Completa')
                                                        <h6>Completa</h6>
                                                    @endif
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->status == 'Finalizada')
                                                        <h6>Concluída</h6>
                                                    @elseif($subs->status == 'Negada')
                                                        <h6>Negada</h6>
                                                    @elseif($subs->status == 'Em Aguardo')
                                                        <h6>Pendente</h6>
                                                    @endif
                                                </div>
                                                <div class="col-2">
                                                    @if($subs->status == 'Em Aguardo')
                                                        <h6>Pendente</h6>
                                                    @else
                                                        <a href="" data-toggle="modal" class="button"
                                                           onclick="vizuJustificativa('{{$subs->justificativa}}')"><h5
                                                                    style="font-size:18px">Visualizar</h5></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-center conteudo" id="tela3"
                                 style="margin-top: 0px;border: none;overflow-x: auto;">
                                <div class="col-md-12" style="padding: 0px">
                                    <div class="card" style="border-radius: 5px">
                                        <div class="card-body"
                                             style="padding-top: 0.2rem;padding-right: 0px;padding-left: 5px;padding-bottom: 5px;">
                                            <div class="">
                                                <div class="justify-content-start" style="alignment: center">
                                                    @foreach($trabalho->desligamentos as $desligamento)
                                                        <div class="row justify-content-between">
                                                            <div class="col-md-9">
                                                                <h5 style="color: #234B8B; font-weight: bold"
                                                                    class="col-md-12">Desligamento</h5>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="col-md-2">
                                                                        <img src="{{asset('img/icons/usuario.svg')}}"
                                                                             style="width:50px" alt="" class="img-flex">
                                                                    </div>
                                                                    <div class="col-md-10">
                                                                        <a onclick="vizuParticipante({{$desligamento->participante()->withTrashed()->first()->id}})"
                                                                           class="button">{{$desligamento->participante()->withTrashed()->first()->user->name}}</a>
                                                                        <br><label
                                                                                for="justificativa">Justificativa: </label>
                                                                        {{$desligamento->justificativa}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                @if($desligamento->status == \App\Desligamento::STATUS_ENUM['solicitado'])
                                                                    <h5 style="color: #234B8B; font-weight: bold"
                                                                        class="col-md-12 text-center"> Ações</h5>
                                                                    <div class="col-md-12 text-center"
                                                                         style="border: solid#1111; padding: 10px; ">
                                                                        <form id="resposta-desligamento{{$desligamento->id}}"
                                                                              method="POST"
                                                                              action="{{route('coordenador.resposta.desligamento', ['desligamento_id' => $desligamento->id]) }}">
                                                                            @csrf
                                                                            <input type="hidden" id="desligamento"
                                                                                   name="desligamento"
                                                                                   value="{{$desligamento->id}}">
                                                                            <input type="radio"
                                                                                   id="aceitar{{$desligamento->id}}"
                                                                                   name="opcao"
                                                                                   value="{{\App\Desligamento::STATUS_ENUM['aceito']}}">
                                                                            Aprovar
                                                                            <input type="radio"
                                                                                   id="negar{{$desligamento->id}}"
                                                                                   name="opcao"
                                                                                   value="{{\App\Desligamento::STATUS_ENUM['recusado']}}">
                                                                            Negar
                                                                            <br>
                                                                            <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    form="resposta-desligamento{{$desligamento->id}}">
                                                                                Submeter
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    <h5 style="color: #234B8B; font-weight: bold"
                                                                        class="col-md-12 text-center"> Status</h5>
                                                                    <div class="col-md-12 text-center"
                                                                         style="border: solid#1111; padding: 10px; ">
                                                                        {{$desligamento->getStatus()}}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                {{--<div class="modal-body">
                    @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1])
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Modal vizualizar justificativa -->
    <div class="modal fade" id="modalVizuJustificativa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="overflow-x:auto">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Justificativa</h5>
                    <button type="button" class="close" onclick="closeJustificativa()" aria-label="Close"
                            style="padding-top: 8px; color:#1492E6">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 style="font-size:18px" id="conteudoJustificativa"></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal enviar convite e atribuir -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-submeta">
                <div class="modal-header modal-header-submeta">
                    <h5 class="modal-title titulo-table" id="exampleModalLongTitle" style="font-size: 20px;">Enviar
                        Convite</h5>
                    <button type="button" class="close" onclick="fecharModalConvite()" aria-label="Close"
                            style="color: rgb(182, 182, 182)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-left: 20px; margin-right: 20px;">
                    
                    <form action="{{ route('admin.convite.atribuicao.projeto') }}" method="POST" class="labels-blue" id="formConvite">
                        @csrf
                        <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                        <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nome Completo <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="nomeAvaliador" id="exampleInputNome1"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="emailAvaliador" id="exampleInputEmail1"
                                   required>
                        </div>                       

                        @if($evento->natureza_id == 3)
                            <div class="form-group">
                                <label for="areasTemeticas" class="col-form-label">{{ __('Áreas Temáticas') }}<span style="color: red; font-weight:bold">*</span></label>
                                <select class="form-control" id="areaTematicaConvite" style="width: 425px" name="areasTemeticas[]" multiple="multiple" required>
                                    @foreach($areasTematicas as $areaTematica)
                                        <option value="{{$areaTematica->id}}">{{$areaTematica->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span
                                            style="color: red; font-weight:bold">*</span></label>
                                <select class="form-control" id="grandeAreaConvite" name="grande_area_id" onchange="areas()"
                                        required>
                                    <option value="" disabled selected hidden>-- Grande Área --</option>
                                    @foreach($grandeAreas as $grandeArea)
                                        <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                                    @endforeach
                                </select>

                                <label for="area" class="col-form-label">{{ __('Área') }} <span
                                            style="color: red; font-weight:bold">*</span></label>
                                <select class="form-control @error('area') is-invalid @enderror" id="areaConvite"
                                        name="area_id" required>
                                    <option value="" disabled selected hidden>-- Área --</option>
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tipo</label>
                            <select class="form-control" name="tipo" id="exampleFormControlSelect1" disabled>
                                <option value="avaliador">Avaliador</option>
                            </select>
                        </div>

                        @if($evento->natureza_id != 3)
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Instituição <span
                                            style="color: red; font-weight:bold">*</span></label>
                                <select class="form-control" name="instituicao" id="membro" required
                                        onchange="mostrarDiv(this)">
                                    <option value="" disabled>-- Selecione a instituição --</option>
                                    <option value="ufape">Universidade Federal do Agreste de Pernambuco</option>
                                    <option value="outra">Outra</option>
                                </select>
                            </div>
                        @endif

                        <div class="form-group" id="div-outra"
                             style="@if(old('instituicao') != null && old('instituicao') == "outra") display: block; @else display: none; @endif">
                            <label for="outra">{{ __('Digite o nome da instituição') }}<span
                                        style="color: red; font-weight: bold;"> *</span></label>
                            <input id="outra" class="form-control @error('outra') is-invalid @enderror" type="text"
                                   name="outra" value="{{old('outra')}}" autocomplete="outra"
                                   placeholder="Universidade Federal ...">
                            @error('outra')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-top: 40px; margin-bottom: 40px;">
                            <button type="submit" class="btn btn-info" style="width: 100%">Enviar</button>
                        </div>
                        <div class="form-group texto-info">
                            O convite será enviador por e-mail e o preenchimento dos dados será de inteira
                            responsabilidade do usuário convidado.
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        body {
            font-family: Calibri, Tahoma, Arial
        }

        .TabControl {
            width: 100%;
            overflow: hidden;
            height: 400px
        }

        .TabControl #header {
            width: 100%;
            overflow: hidden
        }

        .TabControl #content {
            width: 100%;
            overflow: hidden;
            height: 100%;
        }

        .TabControl .abas {
            display: inline;
        }

        .TabControl .abas li {
            float: left
        }

        .aba {
            width: 100px;
            height: 30px;
            border-radius: 5px 5px 0 0;
            text-align: center;
            padding-top: 5px;
        }

        .ativa {
            width: 100px;
            height: 30px;
            border-radius: 5px 5px 0 0;
            text-align: center;
            padding-top: 5px;
            background: #27408B;
        }

        .ativa span, .selected span {
            color: #fff
        }

        .TabControl .conteudo {
            width: 100%;
            display: none;
            height: 100%;
        }

        .selected {
            width: 100px;
            height: 30px;
            border-radius: 5px 5px 0 0;
            text-align: center;
            padding-top: 5px;
            background: #27408B
        }
    </style>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
    $("#areaTematicaConvite").select2({
        placeholder: 'Selecione as áreas temáticas',
        allowClear: true
    });
    </script>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
        var avaliacaoForm;

        $(document).ready(function () {
            $("#content div:nth-child(1)").show();
            $(".abas li:first div").addClass("selected");
            $(".aba2").click(function () {
                $(".aba1").removeClass("selected");
                $(".aba3").removeClass("selected");
                $(this).addClass("selected");
                $("#tela1").hide();
                $("#tela3").hide();
                $("#tela2").show();
            });
            $(".aba1").click(function () {
                $(".aba2").removeClass("selected");
                $(".aba3").removeClass("selected");
                $(this).addClass("selected");
                $("#tela2").hide();
                $("#tela3").hide();
                $("#tela1").show();
            });
            $(".aba3").click(function () {
                $(".aba2").removeClass("selected");
                $(".aba1").removeClass("selected");
                $(this).addClass("selected");
                $("#tela2").hide();
                $("#tela1").hide();
                $("#tela3").show();
            });

            let textTemp = document.getElementById("comentario").innerHTML;

            document.getElementById("aprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = 'Proposta cumpriu todos os requisitos estabelecidos no edital.';
            };
            document.getElementById("reprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = textTemp;
            };
            document.getElementById("parcialAprovado").onclick = function () {
                var s = document.getElementById("comentario");
                s.innerHTML = textTemp;
            };


        });
    </script>
    <script>

        function vizuParticipante(id) {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $("#modalVizuParticipante" + id).modal();
            }, 500);
        }

        function vizuPartici(id) {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $("#modalVizuParticipanteSubstituto" + id).modal();
            }, 500);
        }

        function vizuJustificativa(texto) {
            $("#modalVizuSubstituicao").modal('hide');
            document.getElementById("conteudoJustificativa").innerHTML = texto;
            setTimeout(() => {
                $("#modalVizuJustificativa").modal();
            }, 500);
        }

        function closeJustificativa() {
            $("#modalVizuJustificativa").modal('hide');
            setTimeout(() => {
                $("#modalVizuSubstituicao").modal();
            }, 500);
        }

    </script>

    <style>
        h6, a, b, p, .font-tam {
            font-size: 18.4px;
        }

        h5 {
            font-size: 20px;
        }
    </style>

    <script type="text/javascript">
        var e = document.getElementById("submeter");
        e.onclick = function () {
            myFunction(e.value)
        };
        document.getElementById("closeAcept").onclick = function () {
            $("#modalResultadoSubst").modal('hide');
        };
        document.getElementById("closeCancel").onclick = function () {
            $("#modalCancelarSubst").modal('hide');
        };

        document.getElementById("teste").onclick = function () {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $(document.getElementById("teste").getAttribute("name")).modal();
            }, 500);
        };

        document.getElementById("teste2").onclick = function () {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $(document.getElementById("teste2").getAttribute("name")).modal();
            }, 500);
        };

        document.getElementById("teste3").onclick = function () {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $(document.getElementById("teste2").getAttribute("name")).modal();
            }, 500);
        };

        document.getElementById("teste4").onclick = function () {
            $("#modalVizuSubstituicao").modal('hide');
            setTimeout(() => {
                $(document.getElementById("teste2").getAttribute("name")).modal();
            }, 500);
        };

        function myFunction(id) {
            if (document.getElementById("aceitar").checked) {
                document.getElementById("aprovaId").value = id;
                $("#modalVizuSubstituicao").modal('hide');
                $("#modalResultadoSubst").modal();
            } else if (document.getElementById("negar").checked) {
                document.getElementById("negaId").value = id;
                $("#modalVizuSubstituicao").modal('hide');
                $("#modalCancelarSubst").modal();
            }
        }

        function areasFiltro() {
            var grandeArea = $('#grandeArea').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('area.consulta') }}',
                data: 'id=' + grandeArea,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        if ($('#oldArea').val() == null || $('#oldArea').val() == "") {
                            var option = '<option selected disabled>-- Área --</option>';
                        }
                        $.each(dados, function (i, obj) {
                            if ($('#oldArea').val() != null && $('#oldArea').val() == obj.id) {
                                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
                            } else {
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            }
                        })
                    } else {
                        var option = "<option selected disabled>-- Área --</option>";
                    }
                    $('#area').html(option).show();
                    subareas();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }
    </script>
    <script>
        function consultaExterno() {
            var area = $('#area').val();
            var job = $('#trab').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('aval.consultaExterno') }}',
                data: 'id=' + area + "&trabalho_id=" + job,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        $.each(dados, function (i, obj) {

                            if (obj.instituicao == null) {
                                option += '<option value="' + obj.id + '">' + obj.name + ' > ' + 'Instituição indefinida' + ' > ' + obj.nome + ' > ' + obj.email + '</option>';
                            } else {
                                option += '<option value="' + obj.id + '">' + obj.name + ' > ' + obj.instituicao + ' > ' + obj.nome + ' > ' + obj.email + '</option>';

                            }
                        })
                    } else {
                        var option = "<option selected disabled>Sem Resultado</option>";
                    }
                    $('#exampleFormControlSelect3').html(option).show();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }

        function consultaInterno() {
            var area = $('#area').val();
            var job = $('#trab').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('aval.consultaInterno') }}',
                data: 'id=' + area + "&trabalho_id=" + job,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        $.each(dados, function (i, obj) {

                            if (obj.instituicao == null) {
                                option += '<option value="' + obj.id + '">' + obj.name + ' > ' + 'Instituição indefinida' + ' > ' + obj.nome + ' > ' + obj.email + '</option>';
                            } else {
                                option += '<option value="' + obj.id + '">' + obj.name + ' > ' + obj.instituicao + ' > ' + obj.nome + ' > ' + obj.email + '</option>';
                            }

                        })
                    } else {
                        var option = "<option selected disabled>Sem Resultado</option>";
                    }
                    $('#exampleFormControlSelect2').html(option).show();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }
    </script>

    <script>
        if ({!! json_encode(session('error'), JSON_HEX_TAG) !!}) {
            $(document).ready(function () {
                $('#avaliadorModalCenter').modal('show');
            });
        }
    </script>

    <script>
        function fecharModalSubstituido(id) {
            $('#modalVizuSubstituicao').modal('toggle');
            setTimeout(() => {
                $("#modalVizuParticipanteSubstituido" + id).modal();
            }, 500);
        }

        function fecharModalSubstituto(id) {
            $('#modalVizuSubstituicao').modal('toggle');
            setTimeout(() => {
                $("#modalVizuParticipanteSubstituto" + id).modal();
            }, 500);
        }

        function abrirHistorico(id, modal) {
            if (modal == 1) {
                $('#modalVizuParticipanteSubstituido' + id).modal('hide');
            } else if (modal == 2) {
                $('#modalVizuParticipanteSubstituto' + id).modal('hide');
            } else if (modal == 0) {
                $('#modalVizuParticipante' + id).modal('hide');
            }
            setTimeout(() => {
                $("#modalVizuSubstituicao").modal();
            }, 500);
        }
    </script>

    <script>
        function abrirModalConvite() {
            $("#avaliadorModalCenter").modal('toggle');
            $("#formConvite").attr('action', '{{ route('admin.convite.atribuicao.projeto') }}');
            setTimeout(() => {
                $("#exampleModalCenter").modal();
            }, 500);
            $('#exampleModalCenter').focus();
        }

        function fecharModalConvite() {
            $('#exampleModalCenter').modal('toggle');
            if($("#tipo_avaliacao_id").val() == 1){
                setTimeout(() => {
                    $("#avaliadorModalCenter").modal();
                }, 500);
                $('#avaliadorModalCenter').focus();
            }else{
                setTimeout(() => {
                    $("#avaliacaoRelatorioModal").modal();
                }, 500);
                $('#avaliacaoRelatorioModal').focus();
            }

        }

        function abrirModalConviteRelatorio() {
            $("#avaliacaoRelatorioModal").modal('toggle');
            $("#formConvite").attr('action', '{{ route('admin.enviarConvite') }}');
            setTimeout(() => {
                $("#exampleModalCenter").modal();
            }, 500);
            $('#exampleModalCenter').focus();

        }


        function areas() {
            var grandeArea = $('#grandeAreaConvite').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('area.consulta') }}',
                data: 'id=' + grandeArea,
                headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: (dados) => {

                    if (dados.length > 0) {
                        if ($('#oldArea').val() == null || $('#oldArea').val() == "") {
                            var option = '<option selected disabled>-- Área --</option>';
                        }
                        $.each(dados, function (i, obj) {
                            if ($('#oldArea').val() != null && $('#oldArea').val() == obj.id) {
                                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
                            } else {
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            }
                        })
                    } else {
                        var option = "<option selected disabled>-- Área --</option>";
                    }
                    $('#areaConvite').html(option).show();
                },
                error: (data) => {
                    console.log(data);
                }

            })
        }

        function mostrarDiv(select) {
            if (select.value == "outra") {
                document.getElementById('div-outra').style.display = "block";
                $("#outra").prop('required', true);
            } else if (select.value == "ufape") {
                document.getElementById('div-outra').style.display = "none";
                $("#outra").prop('required', false);
            }
        }
    </script>

    <script>
        //let seletor = document.getElementsByClassName('aval1')
        //console.log(seletor[0].children[0].text)=

        function buscar(input) {
            if(document.getElementById('exampleFormControlSelect2') != null){
                let seletor1 = document.getElementById('exampleFormControlSelect2').children;

                for(let i = 0; i < seletor1.length; i++){
                    let nomeAval1 = seletor1[i].textContent


                    if(nomeAval1.toLowerCase().substr(0).indexOf(input.value.toLowerCase()) >= 0){
                        seletor1[i].style.display = "";
                    }else {
                        seletor1[i].style.display = "none";
                    }
                }
                
            }
            
            let seletor2 = document.getElementById('exampleFormControlSelect3').children;

            for(let j = 0; j < seletor2.length; j++){
                let nomeAval1 = seletor2[j].textContent


                if(nomeAval1.toLowerCase().substr(0).indexOf(input.value.toLowerCase()) >= 0){
                    seletor2[j].style.display = "";
                }else {
                    seletor2[j].style.display = "none";
                }

            }

        }

        function buscarAvalRelatorio(input) {
            let seletorAvalRelatorio = document.querySelectorAll('#avaliacaoSelect');
            
            for(let i = 0; i < seletorAvalRelatorio.length; i++){
                
                for(let j = 0; j < seletorAvalRelatorio[i].children.length; j++){
                    let nomeAval = seletorAvalRelatorio[i].children[j].textContent
                    

                    if(nomeAval.toLowerCase().substr(0).indexOf(input.value.toLowerCase()) >= 0){
                        seletorAvalRelatorio[i].children[j].style.display = "";
                    }else {
                        seletorAvalRelatorio[i].children[j].style.display = "none";
                    }
                }

            }
        }
    </script>
@endsection
