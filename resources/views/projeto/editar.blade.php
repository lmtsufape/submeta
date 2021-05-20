@extends('layouts.app')

@section('content')
<div class="container content">

  <div class="row justify-content-center">
    <div class="col-sm-12">
      <div class="card" style="margin-top:50px">
        <div class="card-body">
          <h5 class="card-title">Editar Projeto</h5>
          <p class="card-text">
            <form method="POST" action="{{ route('trabalho.update', ['id' => $projeto->id]) }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="editalId" value="{{ $edital->id }}">

              {{-- Nome do Projeto  --}}
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Nome do Projeto:') }}</label>
                  <input id="nomeTrabalho" value="{{ $projeto->titulo }}" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeProjeto" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus>

                  @error('nomeTrabalho')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              {{-- Grande Area --}}
              <div class="row justify-content-center">
                <div class="col-sm-4">
                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área:') }}</label>
                  <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" onchange="areas()">
                    <option value="" disabled selected hidden>-- Grande Área --</option>
                    @foreach($grandeAreas as $grandeArea)
                      @if($grandeArea->id === $projeto->grande_area_id)
                        <option value="{{$grandeArea->id}}" selected>{{$grandeArea->nome}}</option>
                      @else
                        <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                      @endif
                    @endforeach
                  </select>

                  @error('grandeArea')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                  <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" onchange="subareas()">
                    <option value="" disabled selected hidden>-- Área --</option>
                    @foreach($areas as $area)
                      @if($area->id === $projeto->area_id)
                        <option value="{{$area->id}}" selected>{{$area->nome}}</option>
                      @else
                        <option value="{{$area->id}}">{{$area->nome}}</option>
                      @endif
                    @endforeach
                  </select>

                  @error('area')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                  <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea">
                    <option value="" disabled selected hidden>-- Sub Área --</option>
                    @foreach($subAreas as $subArea)
                      @if($subArea->id === $projeto->sub_area_id)
                        <option value="{{$subArea->id}}" selected>{{$subArea->nome}}</option>
                      @else
                        <option value="{{$subArea->id}}">{{$subArea->nome}}</option>
                      @endif
                    @endforeach
                  </select>

                  @error('subArea')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>









              <hr>
              <h3>Coordenador</h3>

              {{-- Coordenador  --}}
              <div class="row justify-content-center">

                <div class="col-sm-6">
                  <label for="nomeCoordenador" class="col-form-label">{{ __('Coordenador:') }}</label>
                  <input class="form-control" value="{{ auth()->user()->name }}" type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante"
                  @if(Auth()->user()->proponentes->linkLattes != null)
                    value="{{ Auth()->user()->proponentes->linkLattes }}"
                  @else
                    value=""
                  @endif >

                  @error('linkLattesEstudante')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                  <input value="{{ $projeto->pontuacaoPlanilha }}" class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha">

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                  <input value="{{ $projeto->linkGrupoPesquisa }}" class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo">

                  @error('linkGrupo')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

              </div>

              <hr>
              <h3>Anexos</h3>

              {{-- Anexo do Projeto --}}
              <div class="row justify-content-center">
                {{-- Arquivo  --}}
                <div class="col-sm-6">
                  <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto: ') }}</label> <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}">Arquivo atual</a>

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoProjeto') is-invalid @enderror" id="anexoProjeto" aria-describedby="inputGroupFileAddon01" name="anexoProjeto">
                      <label class="custom-file-label" id="custom-file-label" for="anexoProjeto">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoProjeto')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6">
                  <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador: ') }}</label><a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoLatterCoordenador') is-invalid @enderror" id="inputGroupFile01" aria-describedby="anexoLatterCoordenador" name="anexoLatterCoordenador">
                      <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoLatterCoordenador')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>





                <div class="col-sm-6">
                <label for="nomeTrabalho" class="col-form-label">{{ __('Possui autorização do Comitê de Ética: ') }}</label><a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                  <br>
                  <button id="buttonSim" class="btn btn-primary mt-2 mb-2">Sim</button>
                  <button id="buttonNao" class="btn btn-primary mt-2 mb-2">Não</button>
                  <div class="input-group">


                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoComiteEtica') is-invalid @enderror" id="inputEtica" aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica">
                      <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoComiteEtica')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6 mt-3">
                  <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação: ') }}</label><a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoPlanilha') is-invalid @enderror" id="anexoPlanilha" aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha">
                      <label class="custom-file-label" id="custom-file-label" for="anexoPlanilha">O arquivo deve ser no formato PDF, XLS ou XLSX de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>

                  <div class="input-group">


                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('justificativaAutorizacaoEtica') is-invalid @enderror" id="inputJustificativa" aria-describedby="inputGroupFileAddon01" disabled="disabled" name="justificativaAutorizacaoEtica">
                      <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('justificativaAutorizacaoEtica')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                {{-- Decisão do CONSU --}}
                <div class="col-sm-6">
                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label><a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoCONSU') is-invalid @enderror" id="anexoCONSU" aria-describedby="inputGroupFileAddon01" name="anexoCONSU">
                      <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoCONSU')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                @endif
              </div>

              <hr>
              <h3>Participantes</h3>
              <input type="hidden" value="{{sizeof($participantes)}}" id="countParticipante">

              {{-- Participantes  --}}
              <div class="row" style="margin-top:20px">
                <div class="col-sm-12">
                  <div id="participantes">
                    @foreach($participantes as $participante)
                        <div id="novoParticipante" style="display: block;">
                          <br>
                          <h4>Dados do participante</h4>
                          <h6>Dados pessoais</h6>
                          <input type="hidden" name="participante_id[]" value="{{$participante->id}}">
                          <div class="row">
                            <div class="col-sm-5">
                              <label>Nome Completo*</label>
                              <input type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" value="{{$participante->user->name}}" required>
                              @error('nomeParticipante.'.$projeto->id)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-4">
                              <label>E-mail*</label>
                              <input type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" value="{{$participante->user->email}}" required>
                              @error('emailParticipante.'.$projeto->id)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-3">
                              <label>Função*:</label>
                              <select class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante" required>
                                <option value="" disabled selected hidden>-- Função --</option>
                                @foreach($funcaoParticipantes as $funcaoParticipante)
                                  <option @if($participante->funcao_participante_id==$funcaoParticipante->id ) selected @endif value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                @endforeach
                              </select>
                              @error('funcaoParticipante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div id="dados_complemento_1">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('CPF*') }}</label>
                                  <input type="text" class="form-control cpf" name="cpf[]" required value="{{$participante->user->cpf}}">
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('RG*') }}</label>
                                  <input type="text" class="form-control rg" name="rg[]" required value="{{$participante->rg}}">
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Celular*') }}</label>
                                  <input type="text" class="form-control celular" name="celular[]" required value="{{$participante->user->celular}}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('Data de nascimento*') }}</label>
                                  <input type="date" class="form-control" name="data_de_nascimento[]" required value="{{$participante->data_de_nascimento}}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h6>Endereço do participante</h6>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-3">
                                  <label for="">{{ __('CEP*') }}</label>
                                  <input type="text" class="form-control" name="cep[]" required value="{{$participante->user->endereco->cep}}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-6">
                                  <label for="">{{ __('Rua*') }}</label>
                                  <input type="text" class="form-control" name="rua[]" required value="{{$participante->user->endereco->rua}}">
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Número*') }}</label>
                                  <input type="text" class="form-control" name="numero[]" required value="{{$participante->user->endereco->numero}}">
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Bairro*') }}</label>
                                  <input type="text" class="form-control" name="bairro[]" required value="{{$participante->user->endereco->bairro}}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('Cidade*') }}</label>
                                  <input type="text" class="form-control " name="cidade[]" required value="{{$participante->user->endereco->cidade}}">
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Complemento*') }}</label>
                                  <input type="text" class="form-control" name="complemento[]" required value="{{$participante->user->endereco->complemento}}">
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Estado*') }}</label>
                                  <select name="uf[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- UF --</option>
                                    <option @if($participante->user->endereco->uf == 'AC') selected @endif value="AC">Acre</option>
                                    <option @if($participante->user->endereco->uf == 'AL') selected @endif value="AL">Alagoas</option>
                                    <option @if($participante->user->endereco->uf == 'AP') selected @endif value="AP">Amapá</option>
                                    <option @if($participante->user->endereco->uf == 'AM') selected @endif value="AM">Amazonas</option>
                                    <option @if($participante->user->endereco->uf == 'BA') selected @endif value="BA">Bahia</option>
                                    <option @if($participante->user->endereco->uf == 'CE') selected @endif value="CE">Ceará</option>
                                    <option @if($participante->user->endereco->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                                    <option @if($participante->user->endereco->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                                    <option @if($participante->user->endereco->uf == 'GO') selected @endif value="GO">Goiás</option>
                                    <option @if($participante->user->endereco->uf == 'MA') selected @endif value="MA">Maranhão</option>
                                    <option @if($participante->user->endereco->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                                    <option @if($participante->user->endereco->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                    <option @if($participante->user->endereco->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                                    <option @if($participante->user->endereco->uf == 'PA') selected @endif value="PA">Pará</option>
                                    <option @if($participante->user->endereco->uf == 'PB') selected @endif value="PB">Paraíba</option>
                                    <option @if($participante->user->endereco->uf == 'PR') selected @endif value="PR">Paraná</option>
                                    <option @if($participante->user->endereco->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                                    <option @if($participante->user->endereco->uf == 'PI') selected @endif value="PI">Piauí</option>
                                    <option @if($participante->user->endereco->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                    <option @if($participante->user->endereco->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                    <option @if($participante->user->endereco->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                    <option @if($participante->user->endereco->uf == 'RO') selected @endif value="RO">Rondônia</option>
                                    <option @if($participante->user->endereco->uf == 'RR') selected @endif value="RR">Roraima</option>
                                    <option @if($participante->user->endereco->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                                    <option @if($participante->user->endereco->uf == 'SP') selected @endif value="SP">São Paulo</option>
                                    <option @if($participante->user->endereco->uf == 'SE') selected @endif value="SE">Sergipe</option>
                                    <option @if($participante->user->endereco->uf == 'TO') selected @endif value="TO">Tocantins</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h6>Dados do curso do participante</h6>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label for="">{{ __('Universidade*') }}</label>
                                  <input type="text" class="form-control" name="universidade[]" required value="{{$participante->user->instituicao}}">
                                </div>
                                <div class="col-sm-6">
                                  <label for="">{{ __('Curso*') }}</label>
                                  <input type="text" class="form-control" name="curso[]" required value="{{$participante->curso}}">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-2">
                                  <label for="">{{ __('Turno*') }}</label>
                                  <select id="" class="form-control" name="turno[]" required>
                                    <option value="" disabled selected>-- TURNO --</option>
                                    @foreach ($enum_turno as $turno)
                                      <option @if($participante->turno == $turno) selected @endif value="{{$turno}}">{{$turno}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Total de periodos do curso*') }}</label>
                                  <select name="total_periodos[]" id="" class="form-control" onchange="gerarPeriodos(this)" required>
                                    <option value="" disabled selected>-- TOTAL DE PERIODOS --</option>
                                    <option @if($participante->total_periodos == "6") selected @endif value="6">6</option>
                                    <option @if($participante->total_periodos == "7") selected @endif value="7">7</option>
                                    <option @if($participante->total_periodos == "8") selected @endif value="8">8</option>
                                    <option @if($participante->total_periodos == "9") selected @endif value="9">9</option>
                                    <option @if($participante->total_periodos == "10") selected @endif value="10">10</option>
                                    <option @if($participante->total_periodos == "11") selected @endif value="11">11</option>
                                    <option @if($participante->total_periodos == "12") selected @endif value="12">12</option>
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  <label for="">{{ __('Periodo atual*') }}</label>
                                  <select name="periodo_cursado[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                    @for($i = 1; $i <= $participante->total_periodos; $i++) 
                                      <option @if($participante->periodo_atual == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  <label for="">{{ __('Ordem de prioridade*') }}</label>
                                  <select name="ordem_prioridade[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    <option @if($participante->ordem_prioridade == "1") selected @endif value="1">1º</option>
                                    <option @if($participante->ordem_prioridade == "2") selected @endif value="2">2º</option>
                                    <option @if($participante->ordem_prioridade == "3") selected @endif value="3">3º</option>
                                    <option @if($participante->ordem_prioridade == "4") selected @endif value="4">4º</option>
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Média geral do curso*') }}</label>
                                  <input type="number" class="form-control media" min="0" max="10" step="0.01" value="{{$participante->media_do_curso}}" name="media_geral_curso[]" required>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <h6 class="mb-1">Possui plano de trabalho?</h6>
                          {{dd($participantes[1]->user->email)}}
                          <button  class="btn btn-primary mt-2 mb-2 simPlano">Sim</button>
                          <button  class="btn btn-primary mt-2 mb-2 naoPlano">Não</button>
                          
                          <div id="planoHabilitado" style="display:@if($participante->planoTrabalho != null) block; @else none; @endif">
                          <h5>Dados do plano de trabalho</h5>
                          <div class="row">
                            <div class="col-sm-12">
                              <div id="planoTrabalho">
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Titulo* </label>
                                    
                                    <input type="text" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Nome" value="{{$participante->planoTrabalho->titulo}}">

                                    @error('nomePlanoTrabalho')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                  </div>
                                  {{-- Arquivo  --}}
                                  <div class="col-sm-7">
                                    <label for="nomeTrabalho">Anexo*</label> <a href="{{ route('baixar.plano', ['id' => $participante->planoTrabalho->id]) }}">plano de trabalho atual</a>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="anexoPlanoTrabalho">Selecione um arquivo:</span>
                                      </div>
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoTrabalho" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]">
                                        <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                                      </div>
                                    </div>
                                    @error('anexoPlanoTrabalho')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          </div>
                          <button class="btn btn-danger mt-2 mb-2 delete" style='width:100%;margin-top:10px' @if(sizeof($participantes) == 1) disabled @endif>@if(sizeof($participantes) == 1)Limite minimo de participantes @else Remover @endif</button>
                          
                        </div>
                    @endforeach
                  </div>
                  <button  class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Participantes +</button>
                </div>
              </div>

          </p>
          <div class="row justify-content-center">
            <div class="col-md-6">
              @if (Auth()->user()->administradors != null)
                <a href="{{ route('admin.editais') }}" class="btn btn-secondary" style="width:100%">Cancelar</a>
              @else
                <a href="{{ route('projetos.edital', ['id' => $edital->id]) }}" class="btn btn-secondary" style="width:100%">Cancelar</a>
              @endif
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary" style="width:100%">
                {{ __('Enviar') }}
              </button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('javascript')
<script type="text/javascript">
  $(function() {
    var qtdLinhas = 1;
    const limiteMaxParticipantes = 3;
    const limiteMinParticipantes = 1;
    // Coautores
    $('#addCoautor').click(function(e) {
      var countParticipante = document.getElementById('countParticipante');
      if (countParticipante.value < limiteMaxParticipantes) {
        e.preventDefault();
        linha = montarLinhaInput();
        $('#participantes').append(linha);
        setParticipanteDiv(parseInt(countParticipante.value) + 1);

        var btnsDeletar = document.getElementsByClassName("delete");
        for(var i = 0; i < btnsDeletar.length; i++) {
          btnsDeletar[i].disabled = "";
          $(btnsDeletar[i]).text("Remover participantes");
        }

        if (countParticipante.value >= limiteMaxParticipantes) {
          var btn = document.getElementById('addCoautor');
          btn.disabled = "true";
          $('#addCoautor').text("Limite de participantes atingido");
        }

        // aplicarMascaras();
      }
    });

    function setParticipanteDiv(qtdParticipante) {
      var countParticipante = document.getElementById('countParticipante');
      countParticipante.value = qtdParticipante;
    }

    // $('#addPlanoTrabalho').click(function(e) {
    //   e.preventDefault();
    //   if (qtdLinhas < 4) {
    //     linha = montarLinhaInputPlanoTrabalho();
    //     $('#planoTrabalho').append(linha);
    //     qtdLinhas++;
    //   }

    // });
    // Exibir modalidade de acordo com a área
    // $("#area").change(function() {
    //   console.log($(this).val());
    //   addModalidade($(this).val());
    // });

    $(document).on('click', '.delete', function() {
      var countParticipante = document.getElementById('countParticipante');
      if (countParticipante.value >= limiteMinParticipantes) {
        setParticipanteDiv(parseInt(countParticipante.value) - 1);
        $(this).closest('#novoParticipante').remove();
        document.getElementById("addCoautor").disabled = "";
        $('#addCoautor').text("Adicionar participante");
        if (countParticipante.value == limiteMinParticipantes) {
          var btnsDeletar = document.getElementsByClassName("delete");
          for(var i = 0; i < btnsDeletar.length; i++) {
            btnsDeletar[i].disabled = true;
            $(btnsDeletar).text("Limite minimo de participantes");
          }
        }
        return false;
      } 
    });
    $(document).on('click', '.deletePlano', function() {
      if (qtdLinhas > 1) {
        qtdLinhas--;
        $("#planoTrabalho div.row:last").remove();
        return false;
      }
    });
    $('#anexoProjeto').on('change', function() {
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('#custom-file-label').html(fileName);
    })

    $('#buttonSim').on('click', function(e) {
      e.preventDefault();
      $('#inputEtica').prop('disabled', false);
      $('#inputJustificativa').prop('disabled', true);
    });
    $('#buttonNao').on('click', function(e) {
      e.preventDefault();
      $('#inputEtica').prop('disabled', true);
      $('#inputJustificativa').prop('disabled', false);
    });

    // Habilitando / desabilitando plano de trabalho
    $(document).on('click', '.simPlano', function(e) {
        e.preventDefault();
        var plano = $(this).next().next()[0];
        plano.style.display = 'block';
    });
    $(document).on('click', '.naoPlano', function(e) {
      e.preventDefault();
        var plano = $(this).next()[0];
        plano.style.display = 'none';
    });

    //se há plano de trabalho, esconder a imagem de deletar
    $(function() {
      var simPlano = document.getElementsByClassName('simPlano');
      for(var i=0; i< simPlano.length;i++){
        var planoHabilitado = simPlano[i].parentElement.parentElement.nextElementSibling;
        if(planoHabilitado.firstElementChild != null && planoHabilitado.firstElementChild.className == 'exibirPlano'){
          simPlano[i].parentElement.nextElementSibling.style.display = "none";
        }
      }
    });
  });
  // Remover Coautor

  // function addModalidade(areaId) {
  //   console.log(modalidades)
  //   $("#modalidade").empty();
  //   for (let i = 0; i < modalidades.length; i++) {
  //     if (modalidades[i].areaId == areaId) {
  //       console.log(modalidades[i]);
  //       $("#modalidade").append("<option value=" + modalidades[i].modalidadeId + ">" + modalidades[i].modalidadeNome + "</option>")
  //     }
  //   }
  // }

  function montarLinhaInput() {

    return `<div id="novoParticipante" style="display: block;">
                          <br>
                          <h4>Dados do participante</h4>
                          <h6>Dados pessoais</h6>
                          <input type="hidden" name="participante_id[]" value="0">
                          <div class="row">
                            <div class="col-sm-5">
                              <label>Nome Completo*</label>
                              <input type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" value="" required>
                            </div>
                            <div class="col-sm-4">
                              <label>E-mail*</label>
                              <input type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" value="" required>
                            </div>
                            <div class="col-sm-3">
                              <label>Função*:</label>
                              <select class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante" required>
                                <option value="" disabled selected hidden>-- Função --</option>
                                @foreach($funcaoParticipantes as $funcaoParticipante)
                                  <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div id="dados_complemento_1">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('CPF*') }}</label>
                                  <input type="text" class="form-control cpf" name="cpf[]" required>
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('RG*') }}</label>
                                  <input type="text" class="form-control rg" name="rg[]" required>
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Celular*') }}</label>
                                  <input type="text" class="form-control celular" name="celular[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('Data de nascimento*') }}</label>
                                  <input type="date" class="form-control" name="data_de_nascimento[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h6>Endereço do participante</h6>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-3">
                                  <label for="">{{ __('CEP*') }}</label>
                                  <input type="text" class="form-control" name="cep[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-6">
                                  <label for="">{{ __('Rua*') }}</label>
                                  <input type="text" class="form-control" name="rua[]" required>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Número*') }}</label>
                                  <input type="text" class="form-control" name="numero[]" required>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Bairro*') }}</label>
                                  <input type="text" class="form-control" name="bairro[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-4">
                                  <label for="">{{ __('Cidade*') }}</label>
                                  <input type="text" class="form-control " name="cidade[]" required>
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Complemento*') }}</label>
                                  <input type="text" class="form-control" name="complemento[]" required>
                                </div>
                                <div class="col-sm-4">
                                  <label for="">{{ __('Estado*') }}</label>
                                  <select name="uf[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- UF --</option>
                                    <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                                    <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                                    <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                                    <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                                    <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                                    <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                                    <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal</option>
                                    <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo</option>
                                    <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                                    <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                                    <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso</option>
                                    <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                    <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais</option>
                                    <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                                    <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                                    <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                                    <option @if(old('uf') == 'PE') selected @endif value="PE">Pernambuco</option>
                                    <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                                    <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                    <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                    <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                    <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                                    <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                                    <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina</option>
                                    <option @if(old('uf') == 'SP') selected @endif value="SP">São Paulo</option>
                                    <option @if(old('uf') == 'SE') selected @endif value="SE">Sergipe</option>
                                    <option @if(old('uf') == 'TO') selected @endif value="TO">Tocantins</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h6>Dados do curso do participante</h6>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label for="">{{ __('Universidade*') }}</label>
                                  <input type="text" class="form-control" name="universidade[]" required>
                                </div>
                                <div class="col-sm-6">
                                  <label for="">{{ __('Curso*') }}</label>
                                  <input type="text" class="form-control" name="curso[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-2">
                                  <label for="">{{ __('Turno*') }}</label>
                                  <select id="" class="form-control" name="turno[]" required>
                                    <option value="" disabled selected>-- TURNO --</option>
                                    @foreach ($enum_turno as $turno)
                                      <option value="{{$turno}}">{{$turno}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Total de periodos do curso*') }}</label>
                                  <select name="total_periodos[]" id="" class="form-control" onchange="gerarPeriodos(this)" required>
                                    <option value="" disabled selected>-- TOTAL DE PERIODOS --</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  <label for="">{{ __('Periodo atual*') }}</label>
                                  <select name="periodo_cursado[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  <label for="">{{ __('Ordem de prioridade*') }}</label>
                                  <select name="ordem_prioridade[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    <option value="1">1º</option>
                                    <option value="2">2º</option>
                                    <option value="3">3º</option>
                                    <option value="4">4º</option>
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Média geral do curso*') }}</label>
                                  <input type="number" class="form-control media" min="0" max="10" step="0.01" value="00.00" name="media_geral_curso[]" required>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <h6 class="mb-1">Possui plano de trabalho?</h6>
                          <button  class="btn btn-primary mt-2 mb-2 simPlano">Sim</button>
                          <button  class="btn btn-primary mt-2 mb-2 naoPlano">Não</button>

                          <div id="planoHabilitado" style="display:none;">
                          <h5>Dados do plano de trabalho</h5>
                          <div class="row">
                            <div class="col-sm-12">
                              <div id="planoTrabalho">
                                <div class="row">
                                  <div class="col-sm-4">
                                    <label>Titulo* </label>
                                    <input type="text" style="margin-bottom:10px" class="form-control" name="nomePlanoTrabalho[]" placeholder="Nome" value="">      
                                  </div>
                                  {{-- Arquivo  --}}
                                  <div class="col-sm-7">
                                    <label for="nomeTrabalho">Anexo*</label>
                                    <div class="input-group">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="anexoPlanoTrabalho">Selecione um arquivo:</span>
                                      </div>
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="anexoPlanoTrabalho" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]">
                                        <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          </div>
                          <button class="btn btn-danger mt-2 mb-2 delete" style='width:100%;margin-top:10px' disabled>Limite minimo de participantes</button>
                          
                        </div>`;
  }
  // function montarLinhaInputPlanoTrabalho(){

  //   return  "<div class="+"row"+">"+
  //               "<div class="+"col-sm-4"+">"+
  //                   "<label>Nome Completo</label>"+
  //                   "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'nomePlanoTrabalho[]'+" placeholder="+"Nome"+" required>"+
  //               "</div>"+
  //               "<div class="+"col-sm-7" +">"+
  //                 "<label for="+"nomeTrabalho"+">Anexo </label>"+

  //                 "<div class="+"input-group"+">"+
  //                   "<div class='input-group-prepend'>"+
  //                     "<span class='input-group-text' id='inputGroupFileAddon01'>Selecione um arquivo:</span>"+
  //                   "</div>"+
  //                   "<div class='custom-file'>"+
  //                     "<input type='file' class='custom-file-input' id='inputGroupFile01'"+
  //                       "aria-describedby='inputGroupFileAddon01' name='anexoPlanoTrabalho[]'>"+
  //                     "<label class='custom-file-label' id='custom-file-label' for='inputGroupFile01'>O arquivo deve ser no formato PDF de até 2mb.</label>"+
  //                   "</div>"+
  //                 "</div>"+
  //                 "@error('arquivo')"+
  //                 "<span class='invalid-feedback' role='alert' style='overflow: visible; display:block'>"+
  //                   "<strong>{{ $message }}</strong>"+
  //                 "</span>"+
  //                 "@enderror"+
  //                 "</div>"+
  //                 "<div class="+"col-sm-1"+">"+
  //                     "<a class="+"deletePlano"+">"+
  //                       "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
  //                     "</a>"+
  //                 "</div>"+
  //           "</div>";
  // }

  function linhaPlanoTrabalho(){
    return "<input"+" type="+"hidden"+" class="+"exibirPlano"+">"+
           "<h5>Dados do plano de trabalho</h5>" +
            "<div class="+"row"+">"+
                "<div class="+"col-sm-4"+">"+
                    "<label>Titulo*</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+"form-control @error('nomePlanoTrabalho') is-invalid @enderror"+" name="+'nomePlanoTrabalho[]'+" placeholder="+"Nome"+">"+
                    "@error('nomePlanoTrabalho')" +
                      "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                        "<strong>{{ $message }}</strong>" +
                      "</span>" +
                    "@enderror" +
                "</div>"+
                "<div class="+"col-sm-7" +">"+
                  "<label for="+"nomeTrabalho"+">Anexo* </label>"+

                  "<div class="+"input-group"+">"+
                    "<div class='input-group-prepend'>"+
                      "<span class='input-group-text' id='inputGroupFileAddon01'>Selecione um arquivo:</span>"+
                    "</div>"+
                    "<div class='custom-file'>"+
                      "<input type='file' class='custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" + "id='inputGroupFile01'"+
                        "aria-describedby='inputGroupFileAddon01' name='anexoPlanoTrabalho[]'>"+
                      "<label class='custom-file-label' id='custom-file-label' for='inputGroupFile01'>O arquivo deve ser no formato PDF de até 2mb.</label>"+
                  "</div>"+
                  "</div>"+
                  "@error('anexoPlanoTrabalho')"+
                  "<span class='invalid-feedback' role='alert' style='overflow: visible; display:block'>"+
                    "<strong>{{ $message }}</strong>"+
                  "</span>"+
                  "@enderror"+
                "</div>"+
                "<div class="+"col-sm-1"+">"+
                    "<a  class="+"delete"+">"+
                      "<img src="+"{{ asset('/img/icons/user-times-solid.svg') }}"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
              "</div>";
  }

  function areas() {
    var grandeArea = $('#grandeArea').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('area.consulta') }}',
        data: 'id='+grandeArea ,
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (dados) => {

        if (dados.length > 0) {
          if($('#oldArea').val() == null || $('#oldArea').val() == ""){
            var option = '<option selected disabled>-- Área --</option>';
          }
          $.each(dados, function(i, obj) {
            if($('#oldArea').val() != null && $('#oldArea').val() == obj.id){
              option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
            }else{
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

  function subareas() {
    var area = $('#area').val();
    $.ajax({
        type: 'POST',
        url: '{{ route('subarea.consulta') }}',
        data: 'id='+area ,
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (dados)=> {
        if (dados.length > 0) {
          if($('#oldSubArea').val() == null || $('#oldSubArea').val() == ""){
            var option = '<option selected disabled>-- Sub Área --</option>';
          }
          $.each(dados, function(i, obj) {
            if($('#oldSubArea').val() != null && $('#oldSubArea').val() == obj.id){
              option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
            }else{
              option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
            }
          })
        } else {
          var option = "<option selected disabled>-- Sub Área --</option>";
        }
        $('#subArea').html(option).show();
      },
        error: (dados) => {
            console.log(dados);
        }

    })

  }

  $(document).ready(aplicarMascaras());

  function aplicarMascaras() {
    $('.cpf').mask('000.000.000-00');
    var SPMaskBehavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };
    $('.celular').mask(SPMaskBehavior, spOptions);
    $('.rg').mask('99.999.999-9');
    $('.media').mask('00.00');
  }

  function gerarPeriodos(select) {
    var div = select.parentElement.parentElement;
    var selectPeriodos = div.children[2].children[1];

    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(select.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }

    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);
  }
</script>
@endsection
