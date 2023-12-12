@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('sucesso'))
            <div class="alert alert-success" role="alert">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('erro'))
            <div class="alert alert-danger" role="alert">
                {{ session('erro') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card" style="margin-top:50px">
                    <div class="card-header">
                        <h4 class="card-title" style= "color:#1492E6">
                            Substituir Participante
                        </h4>
                        <h5 style= "color:grey; font-size:medium">{{$edital->nome}}: {{$projeto->titulo}}</h5>
                    </div>
                    <div class="card-body">
                        <h4>Formação Atual</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title" style= "color:#1492E6">
                                    Nome/Período
                                </h5>
                            </div>
                            <div class="card-body">
                            @foreach($participantes as $i => $participante)
                                    <div class="row"style="margin-bottom: 20px;">
                                        <div class="col-10">
                                            <h4 style="font-size:20px">{{$participante->user->name}}</h4>
                                            <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($participante->data_entrada))}} - Atualmente</h5>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <div class="row justify-content-around">
                                                
                                                <a title="Substituição" href="" data-toggle="modal" data-target="#modalTestSubParticipante{{$participante->id}}" class="button"
                                                  @if((count($substituicoesProjeto->where('participanteSubstituido_id',$participante->id)->where('status', 'Em Aguardo')) > 0) 
                                                  || (count($desligamentosProjeto->where('participante_id', $participante->id)->where('status', 1)) > 0)) 
                                                  style="pointer-events: none; cursor: default; color:gray;" 
                                                  @endif >
                                                    <i class="fas fa-exchange-alt fa-2x"></i>
                                                </a>
                                                @if((count($substituicoesProjeto->where('participanteSubstituido_id',$participante->id)->where('status', 'Em Aguardo')) > 0) 
                                                || (count($desligamentosProjeto->where('participante_id', $participante->id)->where('status', 1)) > 0))
                                                <a title="Desligamento" href="" data-toggle="modal" data-target="#modalSolicitarDesligamentoParticipante{{$participante->id}}" 
                                                    class="button" style="pointer-events: none; cursor: default;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:30px;">
                                                        <path fill="#808080" d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/>
                                                    </svg>
                                                 </a>
                                                @else
                                                <a title="Desligamento" href="" data-toggle="modal" data-target="#modalSolicitarDesligamentoParticipante{{$participante->id}}" class="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:30px;">
                                                        <path fill="#3490dc" d="M352 128c0 70.7-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0s128 57.3 128 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/>
                                                    </svg>
                                                 </a>
                                                @endif
                                               
                                    

                                                <a title="Visualizar" href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button"><i class="far fa-eye fa-2x"></i></a>
        
                            
                                            </div>
                                        </div>

                                                                                
                                    </div>

                                    <div class="modal fade" id="exampleModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:auto;">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Dados do Integrante {{$i+1}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal TESTE substituir participante -->
                                    <div class="modal fade" id="modalTestSubParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Tipo de substituição</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <!-- <div class="col-4">
                                                            <button  style="float: right; width:220px;" type="button" id="btnSubmitDiscente" class="btn btn-info" onclick="subsDiscenteDados({{$participante->id}})">
                                                                Substituir Participante
                                                            </button>
                                                        </div> -->
                                                        <div class="col-4" style="text-align: center; margin-left: 45px;">
                                                            <button style=" width:220px;" type="button" id="btnSubmitManter" class="btn btn-info" onclick="subsDiscentePlano({{$participante->id}})">
                                                                Substituir Plano de Trabalho
                                                            </button>
                                                        </div>
                                                        <div class="col-4" style="margin:auto">
                                                            <button style="float: left; width:220px;" type="button" id="btnSubmitCompleto" class="btn btn-info" onclick="subsDiscenteCompleto({{$participante->id}})">
                                                                Substituir Ambos
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelar">
                                                        Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- MODAL PARA PREENCHIMENTO DOS DADOS DO DISCENTE -->
                                    <div class="modal fade" id="exampleModal{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:auto;">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">Dados do Integrante
                                                </h5>
                                                <button type="button"
                                                    class="close"
                                                    data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                            <form method="POST" id="SubParticForm" action="{{route('trabalho.infoTrocaParticipante')}}" enctype="multipart/form-data">
                                            @csrf
                                                <div class="col-md-12">
                                                    <div class="container">
                                                        <div class="row">
                                                            <input type="hidden"
                                                                name="funcaoParticipante[]"
                                                                value="4">
                                                            <input type="hidden"
                                                                name="participante_id[]"
                                                                value="{{ $participante->id ?? '' }}">
                                                            
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Nome completo'])
                                                                    <input type="text"
                                                                        disabled
                                                                        class="form-control "
                                                                        value=""
                                                                        name="name"
                                                                        placeholder="Nome Completo"
                                                                        maxlength="150"
                                                                        id="nome{{$participante->id}}" />
                                                                    <span style="color: red; font-size: 12px"
                                                                        id="caracsRestantesnome{{ $i }}">
                                                                    </span>
                                                                    @error('name.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'E-mail'])
                                                                    <input type="email"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="email"
                                                                        placeholder="E-mail"
                                                                        maxlength="150"
                                                                        id="email{{$participante->id}}" />
                                                                    <span style="color: red; font-size: 12px"
                                                                        id="caracsRestantesemail{{ $i }}">
                                                                    </span>
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Data de nascimento'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="data_de_nascimento"
                                                                        placeholder="E-mail"
                                                                        maxlength="150"
                                                                        id="data_de_nascimento{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'CPF'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="cpf"
                                                                        maxlength="150"
                                                                        id="cpf{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'RG'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="rg"
                                                                        maxlength="150"
                                                                        id="rg{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Celular'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="celular"
                                                                        maxlength="150"
                                                                        id="celular{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-md-12"><h5>Endereço</h5></div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'CEP'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="cep"
                                                                        maxlength="150"
                                                                        id="cep{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'UF'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="uf"
                                                                        maxlength="150"
                                                                        id="uf{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Cidade'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="cidade"
                                                                        maxlength="150"
                                                                        id="cidade{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Bairro'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="bairro"
                                                                        maxlength="150"
                                                                        id="bairro{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Rua'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="rua"
                                                                        maxlength="150"
                                                                        id="rua{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Numero'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="numero"
                                                                        maxlength="150"
                                                                        id="numero{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-12">
                                                                @component('componentes.input', ['label' => 'Complemento'])
                                                                    <input type="input"
                                                                        disabled
                                                                        class="form-control"
                                                                        value=""
                                                                        name="complemento"
                                                                        maxlength="150"
                                                                        id="complemento{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-md-12"><h5>Dados do curso</h5></div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Instituição de Ensino'])
                                                                    <input type="input"
                                                                        readonly
                                                                        class="form-control"
                                                                        value=""
                                                                        name="instituicao"
                                                                        maxlength="150"
                                                                        id="instituicao{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Curso'])
                                                                    <input type="input"
                                                                        readonly
                                                                        class="form-control"
                                                                        value=""
                                                                        name="curso"
                                                                        maxlength="150"
                                                                        id="curso{{$participante->id}}" />
                                                                    @error('email.' . $i)
                                                                        <span class="invalid-feedback"
                                                                            role="alert"
                                                                            style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                @endcomponent
                                                            </div>

                                                            <div class="col-6">
                                                                @component('componentes.select', ['label' => 'Turno'])
                                                                <select name="turno" class="form-control" id="turno{{$participante->id}}" required>
                                                                    <option value="" selected>-- Selecione uma opção --</option>
                                                                    @foreach ($enum_turno as $key => $value)
                                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('turno')
                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                                @endcomponent
                                                            </div>
                                                            @php
                                                                $options = array('3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12);
                                                            @endphp
                                                            <div class="col-6">
                                                                @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
                                                                <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" id="periodosTotal{{$participante->id}}" required>
                                                                    <option value="" selected>-- Selecione uma opção --</option>
                                                                    @foreach ($options as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('total_periodos')
                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                                @endcomponent
                                                            </div>

                                                            <div class="col-6">
                                                                @component('componentes.select', ['label' => 'Período/Ano atual'])
                                                                <select name="periodo_atual" class="form-control" id="periodo{{$participante->id}}" required>
                                                                    <option value="" selected>-- Selecione uma opção --</option>

                                                                </select>
                                                                @error('periodo_atual')
                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                                @endcomponent
                                                            </div>

                                                            <div class="col-6">
                                                                @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                                                <select name="ordem_prioridade" class="form-control" id="ordem{{$participante->id}}" required>
                                                                    <option value="" selected>-- ORDEM --</option>
                                                                    @for($j = 1; $j <= $edital->numParticipantes; $j++) <option value="{{ $j }}">{{ $j }}</option>
                                                                        @endfor

                                                                </select>
                                                                @error('ordem_prioridade')
                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6">
                                                                @component('componentes.input', ['label' => 'Coeficiente de rendimento (média geral)'])
                                                                <input type="number" class="form-control media" value="" name="media_do_curso" min="0" max="10" step="0.01" id="media{{$participante->id}}" required>
                                                                @error('media_do_curso')
                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                                @endcomponent
                                                            </div>
                                                            <div class="col-6"></div>


                                                                <div class="col-12">
                                                                    @component('componentes.input', ['label' => 'Data de Entrada'])
                                                                        <input type="date" class="form-control" value="" name="data_entrada" placeholder="Data de Entrada" id="dt_entradaManter{{$participante->id}}"  />
                                                                        @error('data_entrada')
                                                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                        <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    @endcomponent
                                                                </div>
                                                                <div style="display: block">
                                                                                                            
                                                                    <div class="col-md-12" id="plano-titulo{{$participante->id}}">
                                                                        <h5>Plano de trabalho</h5>
                                                                    </div>
                                                                    <div class="col-12" id="plano-nome{{$participante->id}}">
                                                                        @component('componentes.input', ['label' => 'Título'])
                                                                        <input type="text" class="form-control" value="" name="nomePlanoTrabalho" placeholder="Digite o título do plano de trabalho" maxlength="255" id="nomePlanoTrabalho{{$participante->id}}">
                                                                        @error('nomePlanoTrabalho')
                                                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-12" id="plano-anexo{{$participante->id}}">
                                                                        @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                                                                        <input type="file" class="input-group-text" value="" name="anexoPlanoTrabalho" accept=".pdf" placeholder="Anexo do Plano de Trabalho" />
                                                                        @error('anexoPlanoTrabalho')
                                                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                
                                                                </div>
                                                                <div class="col-md-12">
                                                                    
                                                                        <input type="hidden" name="editalId" value="{{$edital->id}}">
                                                                        <input type="hidden" name="participanteId" value="{{$participante->id}}">
                                                                        <input type="hidden" name="projetoId" value="{{$projeto->id}}">
                                                                        <input type="hidden" id="novoParticianteId{{$participante->id}}" name="novoParticianteId" value="">
                                                                        <button type="submit" class="btn btn-success">Salvar</button>
                                                                </div>
                                                            

                                                            
                                                        </div>
                                                        

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>


                                    <!-- Modal substituir participante Completo -->
                                    <div class="modal fade" id="modalSubParticipanteCompleto{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Integrante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                <div class="container">
                                                    <div class="row justify-content-center" style="padding-left:35px; padding-right:45px">

                                                        <div class="form-controll"
                                                            style="margin-left:10px; margin-top:10px; margin-bottom:15px; font-weight:bold;">

                                                            <div class="form-row d-flex">
                                                                <label for="cpf_consulta{{$participante->id}}">CPF:</label>
                                                                <input type="text" id="cpf_consulta{{$participante->id}}" name="cpf_consulta" class="form-control">
                                                            </div>

                                                            <div class="form-row d-flex" style="margin-top:10px">
                                                                <label for="funcao_participante">Função do Integrante:</label>
                                                                <select name="" id="funcao_participante{{$participante->id}}" class="form-control">
                                                                    @foreach($funcaoParticipantes as $funcao)
                                                                        <!-- EXTENSÃO -->
                                                                        @if($edital->natureza_id == 3 && $edital->tipo == "CONTINUO") 
                                                                            @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador")
                                                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                                                            @endif
                                                                        @elseif($edital->natureza_id == 3 && $edital->tipo == "PIBEX")
                                                                            @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador" || $funcao->nome == "Bolsista")
                                                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                                                            @endif
                                                                        <!-- PESQUISA -->
                                                                        @else
                                                                            @if($funcao->nome == "Bolsista" || $funcao->nome == "Voluntário")
                                                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-row justify-content-center" style="margin-top:20px;">
                                                                <button type="button" class="btn btn-primary" onclick="preencherUsuarioExistente({{$participante->id}})">
                                                                    Adicionar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal substituir participante Dados -->
                                    <div class="modal fade" id="modalSubParticipanteDado{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipanteDadoDiscenteForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal substituir participante Plano -->
                                    <div class="modal fade" id="modalSubParticipantePlano{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Plano</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipantePlanoForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal visualizar informações participante -->
                                    <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                    @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1, 'trabalho' => $projeto])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal solicitar desligamento participante -->
                                    <div class="modal fade" id="modalSolicitarDesligamentoParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" style="overflow-x:auto;">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Desligar Participante</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="solicitar-desligamento{{$participante->id}}" method="POST" action="{{route('proponente.solicitar.desligamento', ['edital_id' => $projeto->evento->id, 'projeto_id' => $projeto->id, 'participante_id' => $participante->id]) }}">
                                                        @csrf
                                                        <input type="hidden" id="participante{{$participante->id}}" name="participante" value="{{$participante->id}}">
                                                        <input type="hidden" id="trabalho" name="trabalho" value="{{$projeto->id}}">
                                                        <h6>Tem certeza que deseja solicitar o desligamento do participante <span style="font-weight: bold">{{$participante->user->name}}</span>?</h6>
                                                        <div class="form-row">
                                                            <div class="col-md-12 form-group">
                                                                <label for="justificativa">{{ __('Justificativa') }}<span style="color: red; font-weight: bold;"> *</span></label>
                                                                <textarea class="form-control @error('justificativa') is-invalid @enderror" type="text" name="justificativa" id="justificativa" cols="30" rows="5" placeholder="Digite a justificativa para o desligamento do participante" required>{{old('justificativa')}}</textarea>
                                                                @error('justificativa')
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    @if($participante->desligamentos->first() == null || ($participante->desligamentos->first() != null && $participante->desligamentos->first()->status != \App\Desligamento::STATUS_ENUM['solicitado']))
                                                        <button type="submit" class="btn btn-success" form="solicitar-desligamento{{$participante->id}}">Confirmar</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h4 style="margin-top: 50px">Substituições</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <div class="row">
                                        <div class="col-3">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituído
                                            </h5>
                                        </div>
                                        <div class="col-3">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituto
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Tipo
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Status
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Justificativa
                                            </h5>
                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($substituicoesProjeto as $subs)
                                    <div class="row"style="margin-bottom: 20px;">
                                            <div class="col-3">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituido()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_saida))}} @endif</h5>
                                            </div>
                                            <div class="col-3">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituto()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_saida))}} @endif</h5>
                                            </div>
                                            <div class="col-2">
                                                @if($subs->tipo == 'ManterPlano')
                                                    <h5>Manter Plano</h5>
                                                @elseif($subs->tipo == 'TrocarPlano')
                                                    <h5>Alterar Plano</h5>
                                                @elseif($subs->tipo == 'Completa')
                                                    <h5>Completa</h5>
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                @if($subs->status == 'Finalizada')
                                                    <h5>Concluída</h5>
                                                @elseif($subs->status == 'Negada')
                                                    <h5>Negada</h5>
                                                @elseif($subs->status == 'Em Aguardo')
                                                    <h5>Pendente</h5>
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                @if($subs->status == 'Em Aguardo')
                                                    <h5>Pendente</h5>
                                                @else
                                                    <a href="" data-toggle="modal" data-target="#modalVizuJustificativa{{$subs->id}}" class="button"><h4 style="font-size:18px">Visualizar</h4></a>
                                                @endif
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar justificativa -->
                                    <div class="modal fade" id="modalVizuJustificativa{{$subs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Justificativa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 style="font-size:18px">{{$subs->justificativa}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituido -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                        @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituto -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                                        @include('administrador.vizualizarParticipante')
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h4 style="margin-top: 50px">Desligamentos</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-4">
                                        <h5 class="card-title" style= "color:#1492E6">
                                            Participante
                                        </h5>
                                    </div>
                                    <div class="col-2" style="text-align: center">
                                        <h5 class="card-title" style= "color:#1492E6">
                                            Status
                                        </h5>
                                    </div>
                                    <div class="col-6" style="text-align: center">
                                        <h5 class="card-title" style= "color:#1492E6">
                                            Justificativa
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($projeto->desligamentos as $desligamento)
                                    <div class="row"style="margin-bottom: 20px;">
                                        <div class="col-4">
                                            <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$desligamento->participante()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$desligamento->participante()->withTrashed()->first()->user->name}}</h4></a>
                                            <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($desligamento->created_at))}}</h5>
                                        </div>
                                        <div class="col-2" style="text-align: center">
                                            <h5>{{$desligamento->getStatus()}}</h5>
                                        </div>
                                        <div class="col-6" style="text-align: center">
                                            <h5>{{$desligamento->justificativa}}</h5>
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

<!-- MODAL DE ERRO -->
<div class="modal fade" id="aviso-modal-usuario-nao-existe" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" >
                <span id="texto-erro">CPF não consta no sistema!</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE PARTICIPANTE COM PERFIL INCOMPLETO -->
<div class="modal fade" id="aviso-modal-perfil-participante-incompleto" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" >
                <span id="texto-erro">Esse Discente não atualizou seu perfil no sistema!</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        $('input.cep:text').mask('00000-000');
        $('input.cpf:text').mask('000.000.000-00');
        $('input.celular').mask('(00) 00000-0000');
        $('input.rg:text').mask('00.000.000-0');

        $('input').on("input", function(){
            var maxlength = $(this).attr("maxlength");
            var currentLength = $(this).val().length;
            var idInput = $(this).attr("id");
            if( currentLength >= maxlength ){
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }else if(currentLength == 0){
                $("#caracsRestantes"+idInput).html("");
            }else{
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }
        });

        $("input.pdf").on("change", function () {
            if(this.files[0].type.split('/')[1] == "pdf") {
                if(this.files[0].size > 20000000){
                    alert("O arquivo possui o tamanho superior a 2MB!");
                    $(this).val('');
                }
            }else{
                alert("O arquivo não é de tipo PDF!");
                $(this).val('');
            }
        });

        $("input[name='anexoComprovanteBancario']").on("change", function () {
            if(this.files[0].type.split('/')[1] == "pdf"
            || this.files[0].type.split('/')[1] == "jpeg"
            || this.files[0].type.split('/')[1] == "jpg"
            || this.files[0].type.split('/')[1] == "png") {
                if(this.files[0].size > 20000000){
                    alert("O arquivo possui o tamanho superior a 2MB!");
                    $(this).val('');
                }
            }else{
                alert("O arquivo não é do tipo Correto!");
                $(this).val('');
            }
        });
    });

    function manterPlano(checkBox){
        var checkboxInput = checkBox;
        var idParticipante = checkboxInput.id;
        var tituloPlano = document.getElementById('nomePlanoTrabalho'+idParticipante);
        var anexoPlano = document.getElementById('anexoPlanoTrabalho'+idParticipante);
        var planoAtual =<?php echo json_encode($participantes->first()->planoTrabalho); ?>;
        var arquivo = document.getElementById('arquivo'+idParticipante);

        if(checkboxInput.checked){
            tituloPlano.setAttribute('value', planoAtual.titulo);
            tituloPlano.setAttribute('disabled', 'disabled');
            tituloPlano.removeAttribute('required');

            anexoPlano.setAttribute('disabled', 'disabled');
            anexoPlano.removeAttribute('required');

            document.getElementById("arqParticipantes").hidden=true;
            document.getElementById("arqAtual").hidden=false;

            arquivo.href = "/baixar/plano-de-trabalho/"+planoAtual.id;
        }else if(!checkboxInput.checked){
            tituloPlano.setAttribute('value','');
            tituloPlano.removeAttribute('disabled');
            tituloPlano.setAttribute('required', 'required');

            anexoPlano.removeAttribute('disabled');
            anexoPlano.setAttribute('required', 'required');

            document.getElementById("arqParticipantes").hidden=false;
            document.getElementById("arqAtual").hidden=true;
        }
    }

    function substituirApenasPlano(checkBox){
        var checkboxInput = checkBox;
        var checkBoxId = checkboxInput.id;
        var idParticipante = checkBoxId.slice(11);
        var inputsForm = [];

        inputsForm.push(document.getElementById('nome'+idParticipante));
        inputsForm.push(document.getElementById('email'+idParticipante));
        inputsForm.push(document.getElementById('nascimento'+idParticipante));
        inputsForm.push(document.getElementById('dt_entrada'+idParticipante));
        inputsForm.push(document.getElementById('cpf'+idParticipante));
        inputsForm.push(document.getElementById('rg'+idParticipante));
        inputsForm.push(document.getElementById('cep'+idParticipante));
        inputsForm.push(document.getElementById('celular'+idParticipante));
        inputsForm.push(document.getElementById('linkLattes'+idParticipante));
        inputsForm.push(document.getElementById('estado'+idParticipante));
        inputsForm.push(document.getElementById('cidade'+idParticipante));
        inputsForm.push(document.getElementById('bairro'+idParticipante));
        inputsForm.push(document.getElementById('rua'+idParticipante));
        inputsForm.push(document.getElementById('numero'+idParticipante));

        var complementoInput = document.getElementById('complemento'+idParticipante);
        inputsForm.push(complementoInput);

        inputsForm.push(document.getElementById('instituicao['+idParticipante+']'));

        var outraInstituicaoInput = document.getElementById('outrainstituicao['+idParticipante+']');
        inputsForm.push(outraInstituicaoInput);

        inputsForm.push(document.getElementById('curso['+idParticipante+']'));

        var outroCursoInput = document.getElementById('outrocurso['+idParticipante+']');
        inputsForm.push(outroCursoInput);

        inputsForm.push(document.getElementById('turno'+idParticipante));
        inputsForm.push(document.getElementById('periodosTotal'+idParticipante));
        inputsForm.push(document.getElementById('periodo'+idParticipante));
        inputsForm.push(document.getElementById('ordem'+idParticipante));
        inputsForm.push(document.getElementById('media'+idParticipante));

        inputsForm.push(document.getElementById('anexoTermoCompromisso'+idParticipante));
        inputsForm.push(document.getElementById('anexoComprovanteMatricula'+idParticipante));
        inputsForm.push(document.getElementById('anexoCurriculoLattes'+idParticipante));
        inputsForm.push(document.getElementById('anexoAutorizacaoPais'+idParticipante));
        inputsForm.push(document.getElementById('anexoComprovanteBancario'+idParticipante));

        if(checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.setAttribute('disabled', 'disabled');
                item.removeAttribute('required');
            });
        }else if(!checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.removeAttribute('disabled');
                item.setAttribute('required', 'required');
            });

            complementoInput.removeAttribute('required');
            outraInstituicaoInput.removeAttribute('required');
            outroCursoInput.removeAttribute('required');
        }
    }

    function showCurso(curso){
        var cursoSelect = curso;
        var idSelect = cursoSelect.id;
        var curso = document.getElementById('outro'+idSelect);
        var displayCurso = document.getElementById('display'+idSelect);

        if(cursoSelect.value === "Outro"){
            displayCurso.style.display = "block";
            curso.parentElement.style.display = '';
            curso.value="";
        }else{
            displayCurso.style.display = "none";
        }
    }

    function showCurso2(curso){
        var cursoSelect = curso;
        var idSelect = cursoSelect.id;
        var curso = document.getElementById('oto'+idSelect);
        var displayCurso = document.getElementById('disprei'+idSelect);

        if(cursoSelect.value === "Outro"){
            displayCurso.style.display = "block";
            curso.parentElement.style.display = '';
            curso.value="";
        }else{
            displayCurso.style.display = "none";
        }
    }

    function gerarPeriodo(e){
        var select = e.parentElement.parentElement.nextElementSibling;
        selectPeriodos = select.children[0].children[1];
        var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
        for(var i = 0; i < parseInt(e.value); i++) {
        html += `<option value="${i+1}">${i+1}º</option>`;
        }
        $(selectPeriodos).html('');
        $(selectPeriodos).append(html);

    }

    function subsDiscenteCompleto(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipanteCompleto"+discenteId).modal(); }, 500);
    }
    function subsDiscenteDados(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipanteDado"+discenteId).modal(); }, 500);
    }
    function subsDiscentePlano(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipantePlano"+discenteId).modal(); }, 500);
    }


    function preencherUsuarioExistente(integranteAntigoId) {
        if (!document.getElementById(`exampleModal${integranteAntigoId}`)) {
            exibirModalNumeroMaximoDeIntegrantes();
            return;
        }

        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route('trabalho.buscarUsuario') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                'cpf_consulta': $(`#cpf_consulta${integranteAntigoId}`).val(),
                'funcao': $(`#funcao_participante${integranteAntigoId}`).val()
            },

            success: function (data) {
                if (data == 'inexistente' || $(`#cpf_consulta${integranteAntigoId}`).val() == "") {
                    exibirModalUsuarioInexistente();
                } else {
                    if ($(`#funcao_participante${integranteAntigoId}`).val() != 4 || data[0].tipo == 'participante') {
                        exibirUsuarioAdicionado(data, integranteAntigoId);
                    }
                }
            }
        });

    }

    function exibirModalUsuarioInexistente() {
        $('#aviso-modal-usuario-nao-existe').modal('show');
    }

    function exibirModalPerfilParticipanteIncompleto() {
        $('#aviso-modal-perfil-participante-incompleto').modal('show');
    }

    $(document).ready(function () {
        $("#cpf_consulta").mask("999.999.999-99");
    });

    function exibirUsuarioAdicionado(data, integranteAntigoId) {
        console.log(data)
        $('#modalIntegrante').modal('hide');
        $(`#modalSubParticipanteCompleto${integranteAntigoId}`).modal('hide');
        document.getElementById(`nome${integranteAntigoId}`).value = data[0]['name'];
        document.getElementById(`nome${integranteAntigoId}`).setAttribute("readonly", "");

        document.getElementById(`email${integranteAntigoId}`).value = data[0]['email'];
        document.getElementById(`email${integranteAntigoId}`).setAttribute("readonly", "");

        if (data[0]['tipo'] == "participante") {
            
            if(data[2] == null) {
                exibirModalPerfilParticipanteIncompleto()
            }

            let [y, m, d] = data[2]['data_de_nascimento'].split('-');
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).value = (new Date(y, m - 1, d)).toLocaleDateString();
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).setAttribute("readonly", "");
        } else {

            document.getElementById(`data_de_nascimento${integranteAntigoId}`).value = null;
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).setAttribute("readonly", "");
        }

        document.getElementById(`cpf${integranteAntigoId}`).value = data[0]['cpf'];
        document.getElementById(`cpf${integranteAntigoId}`).setAttribute("readonly", "");

        if (data?.[2]?.rg) {
            document.getElementById(`rg${integranteAntigoId}`).value = data[2]['rg'];
            document.getElementById(`rg${integranteAntigoId}`).setAttribute("readonly", "");
        }

        if (data?.[0]?.celular) {
            document.getElementById(`celular${integranteAntigoId}`).value = data[0]['celular'];
            document.getElementById(`celular${integranteAntigoId}`).setAttribute("readonly", "");
        }

        if (data[3] != null) {
            document.getElementById(`cep${integranteAntigoId}`).value = data[3].cep;
            document.getElementById(`cep${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`uf${integranteAntigoId}`).value = data[3].uf;
            document.getElementById(`uf${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`cidade${integranteAntigoId}`).value = data[3].cidade;
            document.getElementById(`cidade${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`bairro${integranteAntigoId}`).value = data[3].bairro;
            document.getElementById(`bairro${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`rua${integranteAntigoId}`).value = data[3].rua;
            document.getElementById(`rua${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`numero${integranteAntigoId}`).value = data[3].numero;
            document.getElementById(`numero${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`complemento${integranteAntigoId}`).value = data[3].complemento;
            document.getElementById(`complemento${integranteAntigoId}`).setAttribute("readonly", "");    
        }

        document.getElementById(`instituicao${integranteAntigoId}`).value = data[0].instituicao;
        document.getElementById(`instituicao${integranteAntigoId}`).setAttribute("readonly", "");

        document.getElementById(`curso${integranteAntigoId}`).value = data[2].curso;
        document.getElementById(`curso${integranteAntigoId}`).setAttribute("readonly", "");


        //document.getElementById(`funcaoParticipante${modal_id}`).value = data[1]['nome'];

        if (data[1].nome != "Bolsista" && data[1].nome != "Voluntário") {
            document.getElementById(`plano-titulo${integranteAntigoId}`).setAttribute('hidden', "");
            document.getElementById(`plano-nome${integranteAntigoId}`).setAttribute('hidden', "");
            document.getElementById(`plano-anexo${integranteAntigoId}`).setAttribute('hidden', "");
        } else {
            document.getElementById(`plano-titulo${integranteAntigoId}`).removeAttribute('hidden');
            document.getElementById(`plano-nome${integranteAntigoId}`).removeAttribute('hidden');
            document.getElementById(`plano-anexo${integranteAntigoId}`).removeAttribute('hidden');
        }
        
        document.getElementById(`novoParticianteId${integranteAntigoId}`).value = data[0].id;

        $(`#exampleModal${integranteAntigoId}`).modal('show');
    }

</script>
@endsection