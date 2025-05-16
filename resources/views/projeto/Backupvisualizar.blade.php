@extends('layouts.app')

@section('content')
<div>
  {{-- <form method="POST" id="criarProjetoForm"  action="{{route('trabalho.update', ['id' => $projeto->id])}}" enctype="multipart/form-data">
  @csrf --}}
  <input type="hidden" name="editalId" value="{{$edital->id}}">

  <div class="container" style="margin-top: 3rem">
    <div class="row justify-content-center">
      
      <!-- projeto -->
      {{-- <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">1º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do projeto</h5></div> --}}
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px; margin-bottom:2rem;">
          
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do projeto</h5></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-12" style="margin-top: 10px">
                    <label for="nomeProjeto" class="col-form-label">{{ __('Nome do Projeto') }} <span style="color: red; font-weight:bold">*</span></label>
                    <input id="nomeProjeto" type="text" class="form-control @error('nomeProjeto') is-invalid @enderror" name="nomeProjeto" placeholder="Digite o nome do projeto" value="{{ $projeto->titulo }}" autocomplete="nomeProjeto" autofocus disabled>
                    @error('nomeProjeto')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" onchange="areas()" disabled>
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
                <div class="form-group col-md-4">
                  <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <input type="hidden" id="oldArea" value="{{ old('area') }}">
                    <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" onchange="subareas()" disabled>
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
                <div class="form-group col-md-4">
                  <label for="subArea" class="col-form-label">{{ __('Subárea') }} <span style="color: red; font-weight:bold">*</span></label>
                    <input type="hidden" id="oldSubArea" value="{{ old('subArea') }}">
                    <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea" disabled>
                      <option value="" disabled selected hidden>-- Subárea --</option>
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
          </div>
          </div>
        </div>
      </div>
      <!--X projeto X-->
      <!-- Proponente -->
      {{-- <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">2º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do proponente</h5></div> --}}
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px; margin-bottom:2rem">
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do proponente</h5></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-12" style="margin-top: 15px">
                  <label for="nomeCompletoParticipante1">Proponente</label>
                  <input class="form-control" type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                 
                </div>

                <div class="form-group col-md-4">
                  <label for="linkLattesEstudante">Link do currículo Lattes<span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante" disabled
                  @if(Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null)
                    value="{{ Auth()->user()->proponentes->linkLattes }}"
                  @else
                  value=""
                  @endif required>
                  <small>Ex.: http://lattes.cnpq.br/8363536830656923</small>
                  @error('linkLattesEstudante')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-4">
                  <label for="pontuacaoPlanilha">Valor da planilha de pontuação <span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha"
                  value="{{ $projeto->pontuacaoPlanilha }}" disabled>

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-4">
                  <label for="linkGrupo">Link do grupo de pesquisa</label>
                  <input class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo" disabled
                          value="{{ $projeto->linkGrupoPesquisa }}">

                  <small>Ex.: http://dgp.cnpq.br/dgp/espelhogrupo/228363</small>
                  @error('linkGrupo')
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
      <!--X Proponente X-->
      <!-- Anexos -->
      {{-- <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">3º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Anexos</h5></div> --}}
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px; margin-bottom:2rem">
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Anexos</h5><small>Para alterar os arquivos envie os novos</small></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-6">
                  <label for="anexoProjeto" class="col-form-label">{{ __('Projeto') }} <span style="color: red; font-weight:bold">*</span></label> <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}">Arquivo atual</a>
                  {{-- @if(old('anexoProjetoPreenchido') != null || (isset($rascunho) && $rascunho->anexoProjeto != ""))
                  <a id="anexoProjetoTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoProjeto' ])}}">Arquivo atual</a>
                  @endif --}}
                  {{-- <input type="hidden" id="anexoProjeto" name="anexoProjetoPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoProjeto != "") value="sim" @else value="{{old('anexoProjetoPreenchido')}}" @endif > --}}
                  {{-- <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoProjeto') is-invalid @enderror" id="anexoProjeto" aria-describedby="inputGroupFileAddon01" name="anexoProjeto" onchange="verificarArquivoAnexado_pdf(this)"> 
                      <label class="custom-file-label" id="custom-file-label" for="anexoProjeto">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoProjeto')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror --}}
                </div>

                <div class="form-group col-md-6">
                  <label for="anexoLattesCoordenador" class="col-form-label">{{ __('Currículo Lattes do Proponente') }} <span style="color: red; font-weight:bold">*</span></label><a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                  {{-- @if(old('anexoLattesPreenchido') != null || (isset($rascunho) && $rascunho->anexoLattesCoordenador != ""))
                  <a id="anexoLattesTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoLattesCoordenador' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoLattesPreenchido" name="anexoLattesPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoLattesCoordenador != "") value="sim" @else value="{{old('anexoLattesPreenchido')}}" @endif >

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoLattesCoordenador') is-invalid @enderror" id="anexoLattesCoordenador" aria-describedby="anexoLattesCoordenador" name="anexoLattesCoordenador" onchange="verificarArquivoAnexado_pdf(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoLattesCoordenador">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  <small>Dos últimos 5 anos</small>
                  @error('anexoLattesCoordenador')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror --}}
                </div>
                <div class="form-group col-md-6">
                  <label for="anexoPlanilha" class="col-form-label">{{ __('Planilha de Pontuação') }} <span style="color: red; font-weight:bold">*</span></label> <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                  {{-- @if(old('anexoPlanilhaPreenchido') != null || (isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != ""))
                  <a id="anexoPlanilhaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoPlanilhaPontuacao' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoPlanilhaPreenchido" name="anexoPlanilhaPreenchido" 
                    @if( isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != "") value="sim" @else value="{{old('anexoPlanilhaPreenchido')}}" @endif >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoPlanilha') is-invalid @enderror" id="anexoPlanilha" aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha" onchange="verificarArquivoAnexado_xls_xlsx_ods(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoPlanilha">Formato do arquivo: XLS, XLSX ou ODS de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  @error('anexoPlanilhaPontuacao')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror --}}
                </div>
                <div class="form-group col-md-6">
                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU') }} <span style="color: red; font-weight:bold">*</span></label><a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                  {{-- @if(old('anexoConsuPreenchido') != null || (isset($rascunho) && $rascunho->anexoDecisaoCONSU != "" && $rascunho->anexoDecisaoCONSU != null))
                  <a id="anexoConsuTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoDecisaoCONSU' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoConsuPreenchido" name="anexoConsuPreenchido"
                   @if( isset($rascunho) && $rascunho->anexoDecisaoCONSU != "") value="sim" @else value="{{old('anexoConsuPreenchido')}}" @endif required>
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoCONSU') is-invalid @enderror" id="anexoCONSU" aria-describedby="inputGroupFileAddon01" name="anexoCONSU" onchange="verificarArquivoAnexado_pdf(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoCONSU">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoCONSU')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror --}}
                </div>
                <div class="form-group col-md-6">
                  <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="margin-right: 15px;">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label> <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> Arquivo atual</a><br>
                  {{-- <input type="radio" id="radioSim" onchange="displayAutorizacoesEspeciais('sim')">
                  <label for="radioSim" style="margin-right: 5px">Sim</label>
                  <input type="radio" id="radioNao" onchange="displayAutorizacoesEspeciais('nao')">
                  <label for="radioNao" style="margin-right: 5px">Não</label><br>
                  <span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                    <strong>Selecione a autorização e envie o arquivo!</strong>
                  </span> --}}
                  
                  {{-- <div class="form-group" id="displaySim" style="display: none; margin-top:-1rem">
                    <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf.">{{ __('Sim, declaro que necessito de autorizações especiais') }}</label> 
                      @error('botao')
                        <span id="botao" class="invalid-feedback" role="alert" style="overflow: visible; display:inline">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      <br/>
                      @if(old('anexoComitePreenchido') != null || (isset($rascunho) && $rascunho->anexoAutorizacaoComiteEtica != "" && $rascunho->anexoAutorizacaoComiteEtica != null))
                        <a id="anexoComiteTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                              'nomeAnexo' => 'anexoAutorizacaoComiteEtica' ])}}">Arquivo atual</a>
                      @endif
                      <input type="hidden" id="anexoComitePreenchido" name="anexoComitePreenchido" 
                        @if( isset($rascunho) && $rascunho->anexoAutorizacaoComiteEtica != "") value="sim" @else value="{{old('anexoComitePreenchido')}}" @endif >
    
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input @error('anexoComiteEtica') is-invalid @enderror" id="inputEtica" aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica" onchange="verificarArquivoAnexado_pdf(this)">
                          <label class="custom-file-label" id="custom-file-label" for="inputEtica">O arquivo deve ser no formato PDF de até 2MB.</label>
                        </div>
                      </div>
                      @error('anexoComiteEtica')
                      <span id="comiteErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>

                    <div class="form-group" id="displayNao" style="display: none; margin-top:-1rem">
                      <label for="nomeTrabalho" class="col-form-label">{{ __('Declaração de que não necessito de autorização especiais') }}</label>
                        @if(old('anexoJustificativaPreenchido') != null || (isset($rascunho) && $rascunho->justificativaAutorizacaoEtica != "" && $rascunho->justificativaAutorizacaoEtica != null))
                        <a id="anexoJustificativaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                                'nomeAnexo' => 'justificativaAutorizacaoEtica' ])}}">Arquivo atual</a>
                        @endif
                        <input type="hidden" id="anexoJustificativaPreenchido" name="anexoJustificativaPreenchido"
                          @if( isset($rascunho) && $rascunho->justificativaAutorizacaoEtica != "") value="sim" @else value="{{old('anexoJustificativaPreenchido')}}" @endif >
                        <div class="input-group">
      
      
                          <div class="custom-file">
                            <input type="file" class="custom-file-input @error('justificativaAutorizacaoEtica') is-invalid @enderror" id="inputJustificativa" aria-describedby="inputGroupFileAddon01" name="justificativaAutorizacaoEtica" onchange="verificarArquivoAnexado_pdf(this)" >
                            <label class="custom-file-label" id="custom-file-label" for="inputJustificativa">O arquivo deve ser no formato PDF de até 2MB.</label>
                          </div>
                        </div>
                        @error('justificativaAutorizacaoEtica')
                        <span id="justificativaErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                  </div> --}}
                </div>
                
              </div>
          </div>
          </div>
        </div>
      </div>

      @php
        $resultado_participante_um = array_key_exists(0, $participantes->toArray());
        $resultado_participante_dois = array_key_exists(1, $participantes->toArray());
        $resultado_participante_tres = array_key_exists(2, $participantes->toArray());
      @endphp
      <!--X Anexos X-->
      <!-- Participantes -->
      {{-- <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">4º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Área do(s) participante(s)</h5></div> --}}
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px; padding:15px">
          <div class="card-body" style="margin-bottom: -2rem">
            <div class="d-flex justify-content-between align-items-center">
              <div><h5 style="color: #1492E6; margin-top:0.5rem">Discente(s)</h5></div>
              {{-- <div><div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButtonAlterar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: none">
                  Selecionar
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAlterar">
                  <a type="button" class="dropdown-item" onclick="alterarFormacao(1)">1 Participante</a>
                  <a type="button" class="dropdown-item" onclick="alterarFormacao(2)">2 Participantes</a>
                  <a type="button" class="dropdown-item" onclick="alterarFormacao(3)">3 Participantes</a>
                </div>
              </div></div> --}}
            </div>
            <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
          </div>

          <div class="card-body" id="selecaoParticipantes" style="text-align: center; display:block; margin-top:1rem">
            <div><h5>Selecione o número de participantes do projeto</h5></div>
            <div class="btn-group" style="text-align:center">
              <button type="button" class="btn btn-light" onclick="selecionarParticipantes('1')" style="width: 123px; margin:5px; border-radius:12px">
                <div class="form-row">
                  <div class="col-md-12" style="margin-top: 10px;"><img src="{{asset('/img/icons/icon_1_participantes.png')}}" alt="Logo" style="width: 25px" /></div>
                  <div class="col-md-12" style="margin-top: 10px; margin-bottom:5px"><h6>1 Participante</h6></div>
                </div>
              </button>
              <button type="button" class="btn btn-light" onclick="selecionarParticipantes('2')" style="width: 123px; margin:5px; border-radius:12px">
                <div class="form-row">
                  <div class="col-md-12" style="margin-top: 10px;"><img src="{{asset('/img/icons/icon_2_participantes.png')}}" alt="Logo" style="width: 60px" /></div>
                  <div class="col-md-12" style="margin-top: 10px; margin-bottom:5px"><h6>2 Participantes</h6></div>
                </div>
              </button>
              <button type="button" class="btn btn-light" onclick="selecionarParticipantes('3')" style="width: 123px; margin:5px; border-radius:12px">
                <div class="form-row">
                  <div class="col-md-12" style="margin-top: 10px;"><img src="{{asset('/img/icons/icon_3_participantes.png')}}" alt="Logo" style="width: 90px" /></div>
                  <div class="col-md-12" style="margin-top: 13px; margin-bottom:5px"><h6>3 Participantes</h6></div>
                </div>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div id="participante1" style="display:none; margin-bottom:15px">
                <div class="form-row">
                  <div class="col-md-12"><h5>Clique em um dos participantes para visualizar os dados</h5></div>
                  <div class="col-md-12">
                  
                    <a id="collapseAhParticipante1" class="btn btn-light" data-toggle="collapse" href="#collapseParticipante1" role="button" aria-expanded="false" aria-controls="collapseParticipante1" id="buttonParticipante1" style="width: 100%; text-align:left">
                      <div class="d-flex justify-content-between align-items-center">
                        <h4 id="buttonTitulo1" style="color: #01487E; font-size:17px; margin-top:5px">Participante 1</h4>
                        <input type="hidden" name="participante_id[]" value="@if($resultado_participante_um){{$participantes[0]->id}}@else 0 @endif">
                      </div>
                    </a>
                  </div>
                  <div class="col-md-12">
                    <div class="collapse" id="collapseParticipante1">
                      <div class="container">
                          <div class="form-row mt-3">
                            <div class="col-md-12"><h5>Dados do participante</h5></div>

                            <div class="form-group col-md-6">
                              
                              <label for="nomeCompletoParticipante1">Nome completo <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('nomeCompletoParticipante1') is-invalid @enderror" id="nomeCompletoParticipante1" name="nomeParticipante[]"  placeholder="Digite o nome completo do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->name}}@endif" disabled>
                              @error('nomeCompletoParticipante1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>

                            <div class="form-group col-md-6">
                              <label for="email1">E-mail <span style="color: red; font-weight:bold">*</span></label>
                              <input type="email" class="form-control @error('email1') is-invalid @enderror" id="email1" name="emailParticipante[]" placeholder="Digite o e-mail do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->email}}@endif" disabled>
                              @error('email')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <input type="hidden"  name="funcaoParticipante[]" value="4">
                            <div class="form-group col-md-6">
                              <label for="data1">Data de nascimento <span style="color: red; font-weight:bold">*</span></label>
                              <input type="date" class="form-control @error('data1') is-invalid @enderror" id="data1" name="data_de_nascimento[]" required value="@if($resultado_participante_um){{$participantes[0]->data_de_nascimento}}@endif" disabled>
                              @error('data1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="cpf1">CPF <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cpf1') is-invalid @enderror" id="cpf1" name="cpf[]" placeholder="Digite o CPF do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->cpf}}@endif" disabled> 
                              @error('cpf1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="rg1">RG <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('rg1') is-invalid @enderror" id="rg1" name="rg[]" placeholder="Digite o RG do participante" required value="@if($resultado_participante_um){{$participantes[0]->rg}}@endif" disabled>
                              @error('rg1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="celular1">Celular <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('celular1') is-invalid @enderror" id="celular1" name="celular[]" placeholder="Digite o telefone do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->celular}}@endif" disabled>
                              @error('celular1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-md-12"><h5>Endereço</h5></div>
                            <div class="form-group col-md-6">
                              <label for="cep1">CEP <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cep1') is-invalid @enderror" id="cep1" name="cep[]" placeholder="Digite o CEP do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->endereco->cep}}@endif" disabled>
                              @error('cep1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="estado1">Estado <span style="color: red; font-weight:bold">*</span></label>
                                    <select name="uf[]" id="estado1" class="form-control" style="visibility: visible" disabled>
                                      <option value="" disabled selected>-- Selecione o estado --</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'AC') selected @endif value="AC">Acre</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'AL') selected @endif value="AL">Alagoas</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'AP') selected @endif value="AP">Amapá</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'AM') selected @endif value="AM">Amazonas</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'BA') selected @endif value="BA">Bahia</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'CE') selected @endif value="CE">Ceará</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'GO') selected @endif value="GO">Goiás</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'MA') selected @endif value="MA">Maranhão</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'PA') selected @endif value="PA">Pará</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'PB') selected @endif value="PB">Paraíba</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'PR') selected @endif value="PR">Paraná</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'PI') selected @endif value="PI">Piauí</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'RO') selected @endif value="RO">Rondônia</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'RR') selected @endif value="RR">Roraima</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'SP') selected @endif value="SP">São Paulo</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'SE') selected @endif value="SE">Sergipe</option>
                                      <option @if($resultado_participante_um && $participantes[0]->user->endereco->uf == 'TO') selected @endif value="TO">Tocantins</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="cidade1">Cidade <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cidade1') is-invalid @enderror" id="cidade1" name="cidade[]" placeholder="Digite a cidade do participante" required value="@if($resultado_participante_um){{$participantes[0]->user->endereco->cidade}}@endif" disabled>
                              @error('cidade1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="bairro1">Bairro <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('bairro1') is-invalid @enderror" id="bairro1" name="bairro[]" placeholder="Digite o nome do bairro"required value="@if($resultado_participante_um){{$participantes[0]->user->endereco->bairro}}@endif" disabled>
                              @error('bairro1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="rua1">Rua <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('rua1') is-invalid @enderror" id="rua1" name="rua[]" placeholder="Digite o nome da avenida, rua, travessa..." required value="@if($resultado_participante_um){{$participantes[0]->user->endereco->rua}}@endif" disabled>
                              @error('rua1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="numero1">Número <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('numero1') is-invalid @enderror" id="numero1" name="numero[]" placeholder="Digite o número" required value="@if($resultado_participante_um){{$participantes[0]->user->endereco->numero}}@endif" disabled>
                              @error('numero1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-12">
                              <label for="complemento1">Complemento</label>
                              <textarea type="text" class="form-control @error('complemento1') is-invalid @enderror" id="complemento1" name="complemento[]" required disabled>@if($resultado_participante_um){{$participantes[0]->user->endereco->complemento}}@endif</textarea>
                              @error('complemento1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-md-12"><h5>Dados do curso</h5></div>
                            <div class="form-group col-md-12">
                              <label for="universidade1">Universidade <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('universidade1') is-invalid @enderror" id="universidade1" name="universidade[]" placeholder="Digite o nome da universidade" disabled value="@if($resultado_participante_um){{$participantes[0]->user->instituicao}}@endif">
                              @error('universidade1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-12">
                              <label for="curso1">Curso <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('curso1') is-invalid @enderror" id="curso1" name="curso[]" placeholder="Digite o nome do curso" disabled value="@if($resultado_participante_um){{$participantes[0]->curso}}@endif">
                              @error('curso1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="turno1">Turno <span style="color: red; font-weight:bold">*</span></label>
                              <select id="turno1" class="form-control" name="turno[]"  disabled>
                                <option value="" disabled selected>-- TURNO --</option>
                                @foreach ($enum_turno as $turno)
                                  <option @if($resultado_participante_um && $participantes[0]->turno == $turno) selected @endif value="{{$turno}}">{{$turno}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="totalDePeriodos1">{{ __('Total de períodos do curso') }}  <span style="color: red; font-weight:bold">*</span></label>
                                    <select name="total_periodos[]" id="totalDePeriodos1" class="form-control" onchange="gerarPeriodos1(this)" disabled>
                                      <option value="" disabled selected>-- TOTAL DE PERIODOS --</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "6") selected @endif value="6">6</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "7") selected @endif value="7">7</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "8") selected @endif value="8">8</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "9") selected @endif value="9">9</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "10") selected @endif value="10">10</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "11") selected @endif value="11">11</option>
                                      <option @if($resultado_participante_um && $participantes[0]->total_periodos == "12") selected @endif value="12">12</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="periodoAtual1">{{ __('Período atual') }}  <span style="color: red; font-weight:bold">*</span></label>
                              <select name="periodo_cursado[]" id="periodoAtual1" class="form-control" disabled>
                                <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                @for ($i = 1; $resultado_participante_um && $i <= $participantes[0]->total_periodos; $i++)
                                  <option value="{{$i}}" @if($participantes[0]->periodo_atual == $i) selected @endif>{{$i}}º</option>  
                                @endfor
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="ordemDePrioridade1">{{ __('Ordem de prioridade') }}  <span style="color: red; font-weight:bold">*</span></label>
                              <select name="ordem_prioridade[]" id="ordemDePrioridade1" class="form-control" disabled>
                                <option value="" disabled selected>-- ORDEM --</option>
                                <option @if($resultado_participante_um && $participantes[0]->ordem_prioridade == "1") selected @endif value="1">1</option>
                                <option @if($resultado_participante_um && $participantes[0]->ordem_prioridade == "2") selected @endif value="2">2</option>
                                <option @if($resultado_participante_um && $participantes[0]->ordem_prioridade == "3") selected @endif value="3">3</option>
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="coeficienteDeRendimento1">Coeficiente de rendimento (média geral) <span style="color: red; font-weight:bold">*</span></label>
                              <input type="number" class="form-control" id="coeficienteDeRendimento1" min="0" max="10" step="0.01" name="media_geral_curso[]" disabled value="@if($resultado_participante_um){{$participantes[0]->media_do_curso}}@endif" oninput="validarMedia(this)">
                              @error('coeficienteDeRendimento1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              
                            </div>
                            <div class="col-md-12"><h5>Plano de trabalho</h5> @if($resultado_participante_um)<a href="{{ route('baixar.plano', ['id' => $participantes[0]->planoTrabalho->id]) }}"> {{$participantes[0]->planoTrabalho->titulo}}</a>@endif</div>
                            {{-- <div class="form-group col-md-6">
                              <label for="titulo1">Título <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('titulo1') is-invalid @enderror" id="titulo1" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" disabled>
                              @error('titulo1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <small>Para alterar o trabalho envie um novo com o titulo</small>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="anexoPlanoDeTrabalho1">Anexo <span style="color: red; font-weight:bold">*</span></label>
                              <div class="custom-file">
                                <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoDeTrabalho1" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this)">
                                <label class="custom-file-label" id="anexoPlanoDeTrabalho1" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                              </div>
                              @error('anexoPlanoDeTrabalho1')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div> --}}
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div id="posicaoParticipante2"></div>
            <div id="participante2" style="display:none; margin-bottom:15px">
              <div class="form-row">
                <div class="col-md-12">
                  <a id="collapseAhParticipante2" class="btn btn-light" data-toggle="collapse" href="#collapseParticipante2" role="button" aria-expanded="false" aria-controls="collapseParticipante2" style="width: 100%; text-align:left">
                    <div class="d-flex justify-content-between align-items-center">
                      <h4 style="color: #01487E; font-size:17px; margin-top:5px">Participante 2</h4>
                      <input type="hidden" name="participante_id[]" value="@if($resultado_participante_dois){{$participantes[1]->id}}@else 0 @endif">
                    </div>
                  </a>
                </div>
                <div class="col-md-12">
                  <div class="collapse" id="collapseParticipante2">
                    <div class="container">
                        <div class="form-row mt-3">
                          <div class="col-md-12"><h5>Dados do participante</h5></div>

                          <div class="form-group col-md-6">
                            <label for="nomeCompletoParticipante2">Nome completo <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('nomeCompletoParticipante2') is-invalid @enderror" id="nomeCompletoParticipante2" name="nomeParticipante[]" placeholder="Digite o nome completo do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->name}}@endif">
                            @error('nomeCompletoParticipante2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <input type="hidden"  name="funcaoParticipante[]" value="4">
                          <div class="form-group col-md-6">
                            <label for="email2">E-mail <span style="color: red; font-weight:bold">*</span></label>
                            <input type="email" class="form-control @error('email2') is-invalid @enderror" id="email2" name="emailParticipante[]" placeholder="Digite o e-mail do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->email}}@endif">
                            @error('email2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="data2">Data de nascimento <span style="color: red; font-weight:bold">*</span></label>
                            <input type="date" class="form-control @error('data2') is-invalid @enderror" id="data2" name="data_de_nascimento[]" disabled value="@if($resultado_participante_dois){{$participantes[1]->data_de_nascimento}}@endif">
                            @error('data2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="cpf2">CPF <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cpf2') is-invalid @enderror" id="cpf2" name="cpf[]" placeholder="Digite o CPF do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->cpf}}@endif">
                            @error('cpf2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="rg2">RG <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('rg2') is-invalid @enderror" id="rg2" name="rg[]" placeholder="Digite o RG do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->rg}}@endif">
                            @error('rg2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="celular2">Celular <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('celular2') is-invalid @enderror" id="celular2" name="celular[]" placeholder="Digite o telefone do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->celular}}@endif">
                            @error('celular2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Endereço</h5></div>
                          <div class="form-group col-md-6">
                            <label for="cep2">CEP <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cep2') is-invalid @enderror" id="cep2" name="cep[]" placeholder="Digite o CEP do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->endereco->cep}}@endif">
                            @error('cep2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="estado2">Estado <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="uf[]" id="estado2" class="form-control"   style="visibility: visible" disabled>
                                    <option value="" disabled selected>-- Selecione o estado --</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'AC') selected @endif value="AC">Acre</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'AL') selected @endif value="AL">Alagoas</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'AP') selected @endif value="AP">Amapá</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'AM') selected @endif value="AM">Amazonas</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'BA') selected @endif value="BA">Bahia</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'CE') selected @endif value="CE">Ceará</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'GO') selected @endif value="GO">Goiás</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'MA') selected @endif value="MA">Maranhão</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'PA') selected @endif value="PA">Pará</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'PB') selected @endif value="PB">Paraíba</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'PR') selected @endif value="PR">Paraná</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'PI') selected @endif value="PI">Piauí</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'RO') selected @endif value="RO">Rondônia</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'RR') selected @endif value="RR">Roraima</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'SP') selected @endif value="SP">São Paulo</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'SE') selected @endif value="SE">Sergipe</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->user->endereco->uf == 'TO') selected @endif value="TO">Tocantins</option>
                                  </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="cidade2">Cidade <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cidade2') is-invalid @enderror" id="cidade2" name="cidade[]" placeholder="Digite a cidade do participante" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->endereco->cidade}}@endif">
                            @error('cidade2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="bairro2">Bairro <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('bairro2') is-invalid @enderror" id="bairro2" name="bairro[]" placeholder="Digite o nome do bairro" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->endereco->bairro}}@endif">
                            @error('bairro2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="rua2">Rua <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('rua2') is-invalid @enderror" id="rua2" name="rua[]" placeholder="Digite o nome da avenida, rua, travessa..." disabled value="@if($resultado_participante_dois){{$participantes[1]->user->endereco->rua}}@endif">
                            @error('rua2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="numero2">Número <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('numero2') is-invalid @enderror" id="numero2" name="numero[]" placeholder="Digite o número" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->endereco->numero}}@endif">
                            @error('numero2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-12">
                            <label for="complemento2">Complemento <span style="color: red; font-weight:bold">*</span></label>
                            <textarea type="text" class="form-control @error('complemento2') is-invalid @enderror" id="complemento2" name="complemento[]" disabled>@if($resultado_participante_dois){{$participantes[1]->user->endereco->complemento}}@endif</textarea>
                            @error('complemento2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Dados do curso</h5></div>
                          <div class="form-group col-md-12">
                            <label for="universidade2">Universidade <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('universidade2') is-invalid @enderror" id="universidade2" name="universidade[]" placeholder="Digite o nome da universidade" disabled value="@if($resultado_participante_dois){{$participantes[1]->user->instituicao}}@endif">
                            @error('universidade2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-12">
                            <label for="curso2">Curso <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('curso2') is-invalid @enderror" id="curso2" name="curso[]" placeholder="Digite o nome do curso" disabled value="@if($resultado_participante_dois){{$participantes[1]->curso}}@endif">
                            @error('curso2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="turno2">Turno <span style="color: red; font-weight:bold">*</span></label>
                            <select id="turno2" class="form-control" name="turno[]" disabled>
                              <option value="" disabled selected>-- TURNO --</option>
                                @foreach ($enum_turno as $turno)
                                  <option @if($resultado_participante_dois && $participantes[1]->turno == $turno) selected @endif value="{{$turno}}">{{$turno}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="totalDePeriodos2">{{ __('Total de períodos do curso') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="total_periodos[]" id="totalDePeriodos2" class="form-control" onchange="gerarPeriodos1(this)" disabled>
                                    <option value="" disabled selected>-- TOTAL DE PERIODOS --</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "6") selected @endif value="6">6</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "7") selected @endif value="7">7</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "8") selected @endif value="8">8</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "9") selected @endif value="9">9</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "10") selected @endif value="10">10</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "11") selected @endif value="11">11</option>
                                    <option @if($resultado_participante_dois && $participantes[1]->total_periodos == "12") selected @endif value="12">12</option>
                                  </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="periodoAtual2">{{ __('Período atual') }}  <span style="color: red; font-weight:bold">*</span></label>
                            <select name="periodo_cursado[]" id="periodoAtual2" class="form-control" disabled >
                              <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                              @for ($i = 1; $resultado_participante_dois && $i <= $participantes[0]->total_periodos; $i++)
                                <option value="{{$i}}" @if($participantes[1]->periodo_atual == $i) selected @endif>{{$i}}º</option>  
                              @endfor
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="ordemDePrioridade2">{{ __('Ordem de prioridade') }}  <span style="color: red; font-weight:bold">*</span></label>
                              <select name="ordem_prioridade[]" id="ordemDePrioridade2" class="form-control" disabled>
                                <option value="" disabled selected>-- ORDEM --</option>
                                <option @if($resultado_participante_dois && $participantes[1]->ordem_prioridade == "1") selected @endif value="1">1</option>
                                <option @if($resultado_participante_dois && $participantes[1]->ordem_prioridade == "2") selected @endif value="2">2</option>
                                <option @if($resultado_participante_dois && $participantes[1]->ordem_prioridade == "3") selected @endif value="3">3</option>
                              </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="coeficienteDeRendimento2">Coeficiente de rendimento (média geral) <span style="color: red; font-weight:bold">*</span></label>
                            <input type="number" class="form-control media" id="coeficienteDeRendimento2" min="0" max="10" step="0.01" name="media_geral_curso[]" disabled value="@if($resultado_participante_dois){{$participantes[1]->media_do_curso}}@endif">
                            @error('coeficienteDeRendimento2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Plano de trabalho</h5>@if($resultado_participante_dois)<a href="{{ route('baixar.plano', ['id' => $participantes[1]->planoTrabalho->id]) }}"> {{$participantes[1]->planoTrabalho->titulo}}</a>@endif</div>
                          {{-- <div class="form-group col-md-6">
                            <label for="titulo2">Título <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('titulo2') is-invalid @enderror" id="titulo2" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" disabled>
                            @error('titulo2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="anexoPlanoDeTrabalho2">Anexo <span style="color: red; font-weight:bold">*</span></label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoDeTrabalho2" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this)" required>
                              <label class="custom-file-label" id="anexoPlanoDeTrabalho2" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                            </div>
                            @error('anexoPlanoDeTrabalho2')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div> --}}
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="posicaoParticipante3"></div>
            <div id="participante3" style="display:none;  margin-bottom:15px">
              <div class="form-row">
                <div class="col-md-12">
                  <a id="collapseAhParticipante3" class="btn btn-light" data-toggle="collapse" href="#collapseParticipante3" role="button" aria-expanded="false" aria-controls="collapseParticipante3" style="width: 100%; text-align:left">
                    <div class="d-flex justify-content-between align-items-center">
                      <h4 style="color: #01487E; font-size:17px; margin-top:5px">Participante 3</h4>
                      <input type="hidden" name="participante_id[]" value="@if($resultado_participante_tres){{$participantes[2]->id}}@else 0 @endif">
                    </div>
                  </a>
                </div>
                  <div class="col-md-12">
                    <div class="collapse" id="collapseParticipante3">
                      <div class="container">
                          <div class="form-row mt-3">
                            <div class="col-md-12"><h5>Dados do participante</h5></div>

                            <div class="form-group col-md-6">
                              <label for="nomeCompletoParticipante3">Nome completo <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('nomeCompletoParticipante3') is-invalid @enderror" id="nomeCompletoParticipante3" name="nomeParticipante[]" placeholder="Digite o nome completo do participante"  disabled value="@if($resultado_participante_tres){{$participantes[2]->user->name}}@endif">
                              @error('nomeCompletoParticipante3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <input type="hidden"  name="funcaoParticipante[]" value="4">
                            <div class="form-group col-md-6">
                              <label for="email3">E-mail <span style="color: red; font-weight:bold">*</span></label>
                              <input type="email" class="form-control @error('email3') is-invalid @enderror" id="email3" name="emailParticipante[]" placeholder="Digite o e-mail do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->email}}@endif">
                              @error('email3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="data3">Data de nascimento <span style="color: red; font-weight:bold">*</span></label>
                              <input type="date" class="form-control @error('data3') is-invalid @enderror" id="data3" name="data_de_nascimento[]" disabled value="@if($resultado_participante_tres){{$participantes[2]->data_de_nascimento}}@endif">
                              @error('data3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="cpf3">CPF <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cpf3') is-invalid @enderror" id="cpf3" name="cpf[]" placeholder="Digite o CPF do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->cpf}}@endif">
                              @error('cpf3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="rg3">RG <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('rg3') is-invalid @enderror" id="rg3" name="rg[]" placeholder="Digite o RG do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->rg}}@endif">
                              @error('rg3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="celular3">Celular <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('celular3') is-invalid @enderror" id="celular3" name="celular[]" placeholder="Digite o telefone do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->celular}}@endif">
                              @error('celular3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-md-12"><h5>Endereço</h5></div>
                            <div class="form-group col-md-6">
                              <label for="cep3">CEP <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cep3') is-invalid @enderror" id="cep3" name="cep[]" placeholder="Digite o CEP do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->endereco->cep}}@endif">
                              @error('cep3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="estado3">Estado <span style="color: red; font-weight:bold">*</span></label>
                                    <select name="uf[]" id="estado3" class="form-control" style="visibility: visible" disabled>
                                      <option value="" disabled selected>-- Selecione o estado --</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'AC') selected @endif value="AC">Acre</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'AL') selected @endif value="AL">Alagoas</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'AP') selected @endif value="AP">Amapá</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'AM') selected @endif value="AM">Amazonas</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'BA') selected @endif value="BA">Bahia</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'CE') selected @endif value="CE">Ceará</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'GO') selected @endif value="GO">Goiás</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'MA') selected @endif value="MA">Maranhão</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'PA') selected @endif value="PA">Pará</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'PB') selected @endif value="PB">Paraíba</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'PR') selected @endif value="PR">Paraná</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'PI') selected @endif value="PI">Piauí</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'RO') selected @endif value="RO">Rondônia</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'RR') selected @endif value="RR">Roraima</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'SP') selected @endif value="SP">São Paulo</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'SE') selected @endif value="SE">Sergipe</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->user->endereco->uf == 'TO') selected @endif value="TO">Tocantins</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="cidade3">Cidade <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('cidade3') is-invalid @enderror" id="cidade3" name="cidade[]" placeholder="Digite a cidade do participante" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->endereco->cep}}@endif">
                              @error('cidade3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="bairro3">Bairro <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('bairro3') is-invalid @enderror" id="bairro3" name="bairro[]" placeholder="Digite o nome do bairro" disabled value="@if($resultado_participante_tres){{$participantes[2]->user->endereco->bairro}}@endif">
                              @error('bairro3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="rua3">Rua <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('rua3') is-invalid @enderror" id="rua3" name="rua[]" placeholder="Digite o nome da avenida, rua, travessa..."disabled value="@if($resultado_participante_tres){{$participantes[2]->user->endereco->rua}}@endif">
                              @error('rua3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="numero3">Número <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('numero3') is-invalid @enderror" id="numero3" name="numero[]" placeholder="Digite o número"disabled value="@if($resultado_participante_tres){{$participantes[2]->user->endereco->numero}}@endif">
                              @error('numero3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-12">
                              <label for="complemento3">Complemento <span style="color: red; font-weight:bold">*</span></label>
                              <textarea type="text" class="form-control @error('complemento3') is-invalid @enderror" id="complemento3" name="complemento[]" disabled>@if($resultado_participante_tres){{$participantes[2]->user->endereco->complemento}}@endif</textarea>
                              @error('complemento3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-md-12"><h5>Dados do curso</h5></div>
                            <div class="form-group col-md-12">
                              <label for="universidade3">Universidade <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('universidade3') is-invalid @enderror" id="universidade3" name="universidade[]" placeholder="Universidade" disabled value="@if($resultado_participante_tres){{$participantes[2]->instituicao}}@endif">
                              @error('universidade3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-12">
                              <label for="curso3">Curso <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('curso3') is-invalid @enderror" id="curso3" name="curso[]" placeholder="curso" disabled value="@if($resultado_participante_tres){{$participantes[2]->curso}}@endif">
                              @error('curso3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="turno3">Turno <span style="color: red; font-weight:bold">*</span></label>
                              <select id="turno3" class="form-control" required  name="turno[]" disabled>
                                <option value="" disabled selected>-- TURNO --</option>
                                @foreach ($enum_turno as $turno)
                                  <option @if($resultado_participante_tres && $participantes[2]->turno == $turno) selected @endif value="{{$turno}}">{{$turno}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="totalDePeriodos3">{{ __('Total de períodos do curso') }}  <span style="color: red; font-weight:bold">*</span></label>
                                    <select disabled name="total_periodos[]" id="totalDePeriodos3" class="form-control" onchange="gerarPeriodos1(this)" required>
                                      <option value="" disabled selected>-- TOTAL DE PERIODOS --</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "6") selected @endif value="6">6</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "7") selected @endif value="7">7</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "8") selected @endif value="8">8</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "9") selected @endif value="9">9</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "10") selected @endif value="10">10</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "11") selected @endif value="11">11</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->total_periodos == "12") selected @endif value="12">12</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="periodoAtual3">{{ __('Período atual') }}  <span style="color: red; font-weight:bold">*</span></label>
                              <select name="periodo_cursado[]" id="periodoAtual3" class="form-control" disabled>
                                <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                @for ($i = 1; $resultado_participante_tres && $i <= $participantes[0]->total_periodos; $i++)
                                  <option value="{{$i}}" @if($participantes[2]->periodo_atual == $i) selected @endif>{{$i}}º</option>  
                                @endfor
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="ordemDePrioridade3">{{ __('Ordem de prioridade') }}  <span style="color: red; font-weight:bold">*</span></label>
                                    <select name="ordem_prioridade[]" id="ordemDePrioridade3" class="form-control" disabled>
                                      <option value="" disabled selected>-- ORDEM --</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->ordem_prioridade == "1") selected @endif value="1">1</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->ordem_prioridade == "2") selected @endif value="2">2</option>
                                      <option @if($resultado_participante_tres && $participantes[2]->ordem_prioridade == "3") selected @endif value="3">3</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="coeficienteDeRendimento3">Coeficiente de rendimento (média geral) <span style="color: red; font-weight:bold">*</span></label>
                              <input type="number" class="form-control media" id="coeficienteDeRendimento3" min="0" max="10" step="0.01" name="media_geral_curso[]" disabled value="@if($resultado_participante_tres){{$participantes[2]->media_do_curso}}@endif">
                              @error('coeficienteDeRendimento3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-md-12"><h5>Plano de trabalho</h5>@if($resultado_participante_tres)<a href="{{ route('baixar.plano', ['id' => $participantes[2]->planoTrabalho->id]) }}"> {{$participantes[2]->planoTrabalho->titulo}}</a>@endif</div>
                            {{-- <div class="form-group col-md-6">
                              <label for="titulo3">Título <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" class="form-control @error('titulo3') is-invalid @enderror" id="titulo3" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" disabled>
                              @error('titulo3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="form-group col-md-6">
                              <label for="anexoPlanoDeTrabalho3">Anexo <span style="color: red; font-weight:bold">*</span></label>
                              <div class="custom-file">
                                <input type="file" class="custom-file-input @error('anexoPlanoTrabalho3') is-invalid @enderror" id="anexoPlanoDeTrabalho3" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this)" required>
                                <label class="custom-file-label" id="anexoPlanoDeTrabalho1" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                              </div>
                              @error('anexoPlanoDeTrabalho3')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div> --}}
                          </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <button type="button" class="btn btn-success mt-4" id="exportarPDF">Imprimir proposta</button>
          </div>
        </div>
      </div>
      
      <!--X Participantes X-->
      <!-- Finalizar -->
      {{-- <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">5º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Finalizar</h5></div> --}}
      {{-- <div class="col-md-10">
        <div class="card" style="border-radius: 12px">
        <div class="card-body">
          <div class="container">
            <div class="form-row mt-3">
              <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Finalizar</h5></div>
              <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>
            </div>
            <div class=" d-flex justify-content-between align-items-center" style="margin-top: 15px; margin-bottom:18px">
              <h6 style="font-family:Arial, Helvetica, sans-serif; margin-right:15px"><span style="color: red; font-weight:bold">*</span> Campos obrigatórios</h6>
              
              <button type="submit" id="clickSubmitForm" style="display: none"></button>
              <button type="button" class="btn btn-success" id="idButtonSubmitProjeto" onclick="enviarModalenviarProjeto()" disabled>{{ __('Enviar Projeto') }}</button>
            </div>
          </div>
        </div>
        </div>
      </div> --}}
      <!--X Finalizar X-->
      
    </div>
  </div>
  {{-- </form> --}}
<!-- Modal de Aviso Edit -->
<div class="modal fade" id="exampleModalAnexarDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header" id="idCorCabecalhoModalDocumento">
                <h5 class="modal-title" id="exampleModalLabel2" style="font-size:20px; margin-top:7px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12" style="font-family: 'Roboto', sans-serif;"><label id="idTituloDaMensagemModalDocumento"></label></div>
                <div class="col-12" style="font-family: 'Roboto', sans-serif; margin-top:10px;">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal"style="width:200px;">Fechar</button>
        </div>
    </div>
  </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="modalSubmit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" onclick="fecharModalenviarProjeto()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"  onclick="fecharModalenviarProjeto()">Close</button>
        <button type="button" class="btn btn-primary" onclick="enviarModalenviarProjeto()">Enviar projeto</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('javascript')
{{-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.css"></script> --}}
<script type="text/javascript">
  function myPrint(){
    printJS('myFile.pdf');
  }
  var buttonPDF = document.getElementById('exportarPDF');

  buttonPDF.addEventListener('click', () =>{
    window.print();
    // setTimeout(function(){ 
    //   document.querySelector("body > print-preview-app").shadowRoot.querySelector("#sidebar").shadowRoot.querySelector("print-preview-button-strip").shadowRoot.querySelector("div > cr-button.action-button").click();
    // }, 1000);
    
    // myPrint()
  });

/*
* GLOBAL
*/
var numeroDeParticipantes;
var tempPart1;
var tempPart2;
var tempPart3;

  
tempPart1 = document.getElementById("participante1");
tempPart2 = document.getElementById("participante2");
tempPart3 = document.getElementById("participante3");

  $(document).ready(function () {
    selecionarParticipantes("{{$participantes->count()}}");
    $('#collapseAhParticipante1').click();
    $('#collapseAhParticipante2').click();
    $('#collapseAhParticipante3').click();
  });
/*
* FUNCAO: Mostrar no input o arquivo selecionado
*
*/
    
    $('.custom-file-input').on('change', function() {
      var fieldVal = $(this).val();

      // Change the node's value by removing the fake path (Chrome)
      fieldVal = fieldVal.replace("C:\\fakepath\\", "");

      if (fieldVal != undefined || fieldVal != "") {
        $(this).next(".custom-file-label").attr('data-content', fieldVal);
        $(this).next(".custom-file-label").text(fieldVal);
      }
    })

/*
* FUNCAO: Gerar as areas
*
*/
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
/*
* FUNCAO: Gerar as subareas
*
*/
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
            var option = '<option selected disabled>-- Subárea --</option>';
          }
          $.each(dados, function(i, obj) {
            if($('#oldSubArea').val() != null && $('#oldSubArea').val() == obj.id){
              option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
            }else{
              option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
            }
          })
        } else {
          var option = "<option selected disabled>-- Subárea --</option>";
        }
        $('#subArea').html(option).show();
      },
        error: (dados) => {
            console.log(dados);
        }

    })

  }
/*  
* FUNCAO: funcao responsavel pelo abre e fecha da area "possui autorizacoes especiais?"
*
*/
function displayAutorizacoesEspeciais(valor){
    if(valor == "sim"){
      document.getElementById("radioSim").checked = true;
      document.getElementById("radioNao").checked = false;
      document.getElementById("displaySim").style.display = "block";
      document.getElementById("displayNao").style.display = "none";
      document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
    }else if(valor == "nao"){
      document.getElementById("radioSim").checked = false;
      document.getElementById("radioNao").checked = true;
      document.getElementById("displaySim").style.display = "none";
      document.getElementById("displayNao").style.display = "block";
      document.getElementById("idAvisoAutorizacaoEspecial").style.display = "none";
    }
  }
/*  
* FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (PDF)
*
*/
function verificarArquivoAnexado_pdf(item){
    var anexado = true;
    if(item.files[0].type.split('/')[1] != "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo PDF! ";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
        anexado = false;
    }else if(item.files[0].size > 2000000 && item.files[0].type.split('/')[1] == "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
        anexado = false;
    }

    if (anexado && item.id == "anexoPlanoDeTrabalho1") {
      document.getElementById('titulo1').required = true;
    } else if (anexado && item.id == "anexoPlanoDeTrabalho2") {
      document.getElementById('titulo2').required = true;
    } else if (anexado && item.id == "anexoPlanoDeTrabalho3") {
      document.getElementById('titulo3').required = true;
    }
  }
/* FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (XLS, XLSX, ODS)
*
*/
function verificarArquivoAnexado_xls_xlsx_ods(item){
    if(item.files[0].name.split('.')[1] == "xls" || item.files[0].name.split('.')[1] == "ods" || item.files[0].name.split('.')[1] == "xlsx"){
        if(item.files[0].size > 2000000){
          document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
          document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
          document.getElementById(item.id).value = "";
          $("#exampleModalAnexarDocumento").modal({show: true});
        }
    }else{
      document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
      document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo XLS, XLSX ou ODS! ";
      document.getElementById(item.id).value = "";
      $("#exampleModalAnexarDocumento").modal({show: true});
    }
    
}

/*
* FUNCAO: Gerar periodos
*
*/
function gerarPeriodos1(select) {
    var div = select.parentElement.parentElement;
    var selectPeriodos = div.children[21].children[1];
    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(select.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }

    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);
  }
/*
* FUNCAO: Selecionar participantes do projeto
*
*/

function selecionarParticipantes(quantidade){
  if(quantidade == "1"){
    numeroDeParticipantes = 1;
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante2").remove();
    document.getElementById("participante3").remove();
    document.getElementById("selecaoParticipantes").style.display ="none";
  }else if(quantidade == 2){
    numeroDeParticipantes = 2;
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante2").style.display ="block";
    document.getElementById("participante3").remove();
    document.getElementById("selecaoParticipantes").style.display ="none";
  }else if(quantidade == 3){
    numeroDeParticipantes = 3;
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante2").style.display ="block";
    document.getElementById("participante3").style.display ="block";
    document.getElementById("selecaoParticipantes").style.display ="none";
  }
  //mostrar botao alterar
  document.getElementById("dropdownMenuButtonAlterar").style.display = "block";
  // habilitar botao submeter projeto
  document.getElementById("idButtonSubmitProjeto").disabled  = false;
}
/*
* FUNCAO: abrir modal para enviar o trabalho
*/
function abrirModalenviarProjeto(){
  if(validarForm() == true){
    //fecharModalenviarProjeto();
  }else{
    document.getElementById("modalSubmit").classList.add("show");
    document.getElementById("modalSubmit").style.display="block";
    document.getElementById("modalSubmit").style.backgroundColor="rgba(0, 0, 0, 0.5)";

    document.getElementById("collapseParticipante1").classList.add("show");
    document.getElementById("collapseParticipante2").classList.add("show");
    document.getElementById("collapseParticipante3").classList.add("show");
  }
}
/*
* FUNCAO: fechar modal para enviar o trabalho
*/
function fecharModalenviarProjeto(){
  document.getElementById("modalSubmit").classList.remove("show");
  document.getElementById("modalSubmit").style.display="none";
  document.getElementById("modalSubmit").style.backgroundColor="rgba(0, 0, 0, 0.5)";

  //document.getElementById("collapseParticipante1").classList.remove("show");
  //document.getElementById("collapseParticipante2").classList.remove("show");
  //document.getElementById("collapseParticipante3").classList.remove("show");
}
/*
* FUNCAO: enviar modal
*
*/
function enviarModalenviarProjeto(){
  if(numeroDeParticipantes == 1){
    document.getElementById("collapseParticipante1").classList.add("show");
    document.getElementById("clickSubmitForm").click();
  }else if(numeroDeParticipantes == 2){
    document.getElementById("collapseParticipante1").classList.add("show");
    document.getElementById("collapseParticipante2").classList.add("show");
    document.getElementById("clickSubmitForm").click();
  }else if(numeroDeParticipantes == 3){
    document.getElementById("collapseParticipante1").classList.add("show");
    document.getElementById("collapseParticipante2").classList.add("show");
    document.getElementById("collapseParticipante3").classList.add("show");
    document.getElementById("clickSubmitForm").click();
  }
}
/*
* FUNCAO: Formacao dos participantes
*
*/
function alterarFormacao(quero){
  //console.log(numeroDeParticipantes);
  if(numeroDeParticipantes == 1 && quero == 2){
    var container = document.getElementById("posicaoParticipante2");
    container.append(tempPart2);
    document.getElementById("participante2").style.display ="block";
    numeroDeParticipantes = quero;
  }else if(numeroDeParticipantes == 1 && quero == 3){

    var container2 = document.getElementById("posicaoParticipante2");
    container2.append(tempPart2);

    var container3 = document.getElementById("posicaoParticipante3");
    container3.append(tempPart3);

    document.getElementById("participante2").style.display ="block";
    document.getElementById("participante3").style.display ="block";

    numeroDeParticipantes = quero;
  }else if(numeroDeParticipantes == 2 && quero == 1){
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante2").remove();
    numeroDeParticipantes = quero;
  }else if(numeroDeParticipantes == 2 && quero == 3){
    var container3 = document.getElementById("posicaoParticipante3");
    container3.append(tempPart3);
    document.getElementById("participante3").style.display ="block";
    numeroDeParticipantes = quero;
  }else if(numeroDeParticipantes == 3 && quero == 1){
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante2").remove();
    document.getElementById("participante3").remove();
    numeroDeParticipantes = quero;
  }else if(numeroDeParticipantes == 3 && quero == 2){
    document.getElementById("participante1").style.display ="block";
    document.getElementById("participante3").remove();
    numeroDeParticipantes = quero;
  }
}


/* FUNCAO: validar campos
*
*/
$(document).ready(aplicarMascaras());

function aplicarMascaras() {

  $('#cpf1').mask('000.000.000-00');
  $('#cpf2').mask('000.000.000-00');
  $('#cpf3').mask('000.000.000-00');

  $('#rg1').mask('00000000');
  $('#rg2').mask('00000000');
  $('#rg3').mask('00000000');

  $('#celular1').mask('(00) 00000-0000');
  $('#celular2').mask('(00) 00000-0000');
  $('#celular3').mask('(00) 00000-0000');

  $('#cep1').mask('00000-000');
  $('#cep2').mask('00000-000');
  $('#cep3').mask('00000-000');
}
function validarForm(){
  
  /*var buttonRadioSim = document.getElementById("radioSim");
  var buttonRadioNao = document.getElementById("radioNao");
  
  //button radio
  if(buttonRadioSim.checked == false && buttonRadioNao.checked == false){
    document.getElementById("idAvisoAutorizacaoEspecial").style.display = "block";
    document.getElementById("idAvisoAutorizacaoEspecial").autofocus;
  }
  //participantes
  var part1 = document.getElementById("participante1").style.visibility;
  var part2 = document.getElementById("participante1").style.visibility;
  var part3 = document.getElementById("participante1").style.visibility;
  */
  


  
  
  /*

  document.getElementById("modalSubmit").classList.add("show");
  document.getElementById("modalSubmit").style.display="block";
  document.getElementById("modalSubmit").style.backgroundColor="black";

  document.getElementById("collapseParticipante1").classList.add("show");
  document.getElementById("collapseParticipante2").classList.add("show");
  document.getElementById("collapseParticipante3").classList.add("show");
  //document.getElementById("collapseParticipante1").classList.remove = "collapsed";
  */
}
function validarPart1(){
  //participante 1
  var nome1 = document.getElementById("nomeCompletoParticipante1");
  var email1 = document.getElementById("email1");
  var data1 = document.getElementById("data1");
  var cpf1 = document.getElementById("cpf1");
  var rg1 = document.getElementById("rg1");
  var celular1 = document.getElementById("celular1");
  var cep1 = document.getElementById("cep1");
  var estado1 = document.getElementById("estado1");
  var cidade1 = document.getElementById("cidade1");
  var bairro1 = document.getElementById("bairro1");
  var rua1 = document.getElementById("rua1");
  var numero1 = document.getElementById("numero1");
  var complemento1 = document.getElementById("complemento1");
  var universidade1 = document.getElementById("universidade1");
  var curso1 = document.getElementById("curso1");
  var turno1 = document.getElementById("turno1");
  var totalDePeriodos1 = document.getElementById("totalDePeriodos1");
  var periodoAtual1 = document.getElementById("periodoAtual1");
  var ordemDePrioridade1 = document.getElementById("ordemDePrioridade1");
  var coeficineteDeRendimento1 = document.getElementById("coeficienteDeRendimento1");
  var tituloPlanoDeTrabalho1 = document.getElementById("titulo1");
  var anexoPlanoDeTrabalho1 = document.getElementById("anexoPlanoDeTrabalho1");
  
//validacao dos campos - participante 1
if(nome1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    nome1.focus();
    return true;
  }else if(email1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    email1.focus();
    return true;
  }else if(data1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    data1.focus();
    return true;
  }else if(cpf1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    cpf1.focus();
    return true;
  }else if(rg1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    rg1.focus();
    return true;
  }else if(celular1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    celular1.focus();
    return true;
  }else if(cep1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    cep1.focus();
    return true;
  }else if(estado1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    estado1.focus();
    return true;
  }else if(cidade1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    cidade1.focus();
    return true;
  }else if(bairro1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    bairro1.focus();
    return true;
  }else if(rua1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    rua1.focus();
    return true;
  }else if(numero1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    numero1.focus();
    return true;
  }else if(complemento1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    complemento1.focus();
    return true;
  }else if(complemento1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    complemento1.focus();
    return true;
  }else if(universidade1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    universidade1.focus();
    return true;
  }else if(curso1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    curso1.focus();
    return true;
  }else if(turno1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    turno1.focus();
    return true;
  }else if(totalDePeriodos1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    totalDePeriodos1.focus();
    return true;
  }else if(periodoAtual1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    periodoAtual1.focus();
    return true;
  }else if(ordemDePrioridade1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    ordemDePrioridade1.focus();
    return true;
  }else if(coeficineteDeRendimento1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    coeficineteDeRendimento1.focus();
    return true;
  }else if(tituloPlanoDeTrabalho1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    tituloPlanoDeTrabalho1.focus();
    return true;
  }else if(anexoPlanoDeTrabalho1.value == ""){
    document.getElementById("collapseParticipante1").classList.add("show");
    //alert("Nome não informado");
    anexoPlanoDeTrabalho1.focus();
    return true;
  }
}
function validarPart2(){
  //participante 2
  var nome2 = document.getElementById("nomeCompletoParticipante2");
  var email2 = document.getElementById("email2");
  var data2 = document.getElementById("data2");
  var cpf2 = document.getElementById("cpf2");
  var rg2 = document.getElementById("rg2");
  var celular2 = document.getElementById("celular2");
  var cep2 = document.getElementById("cep2");
  var estado2 = document.getElementById("estado2");
  var cidade2 = document.getElementById("cidade2");
  var bairro2 = document.getElementById("bairro2");
  var rua2 = document.getElementById("rua2");
  var numero2 = document.getElementById("numero2");
  var complemento2 = document.getElementById("complemento2");
  var universidade2 = document.getElementById("universidade2");
  var curso2 = document.getElementById("curso2");
  var turno2 = document.getElementById("turno2");
  var totalDePeriodos2 = document.getElementById("totalDePeriodos2");
  var periodoAtual2 = document.getElementById("periodoAtual2");
  var ordemDePrioridade2 = document.getElementById("ordemDePrioridade2");
  var coeficineteDeRendimento2 = document.getElementById("coeficienteDeRendimento2");
  var tituloPlanoDeTrabalho2 = document.getElementById("titulo2");
  var anexoPlanoDeTrabalho2 = document.getElementById("anexoPlanoDeTrabalho2");

  //validacao dos campos - participante 2
  if(nome2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    nome2.focus();
    return true;
  } else if(email2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    email2.focus();
    return true;
  }else if(data2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    data2.focus();
    return true;
  }else if(cpf2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    cpf2.focus();
    return true;
  }else if(rg2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    rg2.focus();
    return true;
  }else if(celular2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    celular2.focus();
    return true;
  }else if(cep2.value == ""){
    document.getElementById("colapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    cep2.focus();
    return true;
  }else if(estado2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    estado2.focus();
    return true;
  }else if(cidade2.value == ""){
    console.log(cidade2.value)
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    cidade2.focus();
    return true;
  }else if(bairro2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    bairro2.focus();
    return true;
  }else if(rua2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    rua2.focus();
    return true;
  }else if(numero2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    numero2.focus();
    return true;
  }else if(complemento2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    complemento2.focus();
    return true;
  }else if(complemento2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    complemento2.focus();
    return true;
  }else if(universidade2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    universidade2.focus();
    return true;
  }else if(curso2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    curso2.focus();
    return true;
  }else if(turno2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    turno2.focus();
    return true;
  }else if(totalDePeriodos2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    totalDePeriodos2.focus();
    return true;
  }else if(periodoAtual2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    periodoAtual2.focus();
    return true;
  }else if(ordemDePrioridade2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    ordemDePrioridade2.focus();
    return true;
  }else if(coeficineteDeRendimento2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    coeficineteDeRendimento2.focus();
    return true;
  }else if(tituloPlanoDeTrabalho2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    tituloPlanoDeTrabalho2.focus();
    return true;
  }else if(anexoPlanoDeTrabalho2.value == ""){
    document.getElementById("collapseParticipante2").classList.add("show");
    //alert("Nome não informado");
    anexoPlanoDeTrabalho2.focus();
    return true;
  }

  
}
function validarPart3(){
  //participante 3
  var nome3 = document.getElementById("nomeCompletoParticipante3");
  var email3 = document.getElementById("email3");
  var data3 = document.getElementById("data3");
  var cpf3 = document.getElementById("cpf3");
  var rg3 = document.getElementById("rg3");
  var celular3 = document.getElementById("celular3");
  var cep3 = document.getElementById("cep3");
  var estado3 = document.getElementById("estado3");
  var cidade3 = document.getElementById("cidade3");
  var bairro3 = document.getElementById("bairro3");
  var rua3 = document.getElementById("rua3");
  var numero3 = document.getElementById("numero3");
  var complemento3 = document.getElementById("complemento3");
  var universidade3 = document.getElementById("universidade3");
  var curso3 = document.getElementById("curso3");
  var turno3 = document.getElementById("turno3");
  var totalDePeriodos3 = document.getElementById("totalDePeriodos3");
  var periodoAtual3 = document.getElementById("periodoAtual3");
  var ordemDePrioridade3 = document.getElementById("ordemDePrioridade3");
  var coeficineteDeRendimento3 = document.getElementById("coeficienteDeRendimento3");
  var tituloPlanoDeTrabalho3 = document.getElementById("titulo3");
  var anexoPlanoDeTrabalho3 = document.getElementById("anexoPlanoDeTrabalho3");

  //validacao dos campos - participante 3
  if(nome3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    nome3.focus();
    return true;
  }else if(email3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    email3.focus();
    return true;
  }else if(data3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    data3.focus();
    return true;
  }else if(cpf3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    cpf3.focus();
    return true;
  }else if(rg3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    rg3.focus();
    return true;
  }else if(celular3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    celular3.focus();
    return true;
  }else if(cep3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    cep3.focus();
    return true;
  }else if(estado3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    estado3.focus();
    return true;
  }else if(cidade3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    cidade3.focus();
    return true;
  }else if(bairro3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    bairro3.focus();
    return true;
  }else if(rua3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    rua3.focus();
    return true;
  }else if(numero3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    numero3.focus();
    return true;
  }else if(complemento3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    complemento3.focus();
    return true;
  }else if(complemento3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    complemento3.focus();
    return true;
  }else if(universidade3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    universidade3.focus();
    return true;
  }else if(curso3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    curso3.focus();
    return true;
  }else if(turno3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    turno3.focus();
    return true;
  }else if(totalDePeriodos3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    totalDePeriodos3.focus();
    return true;
  }else if(periodoAtual3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    periodoAtual3.focus();
    return true;
  }else if(ordemDePrioridade3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    ordemDePrioridade3.focus();
    return true;
  }else if(coeficineteDeRendimento3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    coeficineteDeRendimento3.focus();
    return true;
  }else if(tituloPlanoDeTrabalho3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    tituloPlanoDeTrabalho3.focus();
    return true;
  }else if(anexoPlanoDeTrabalho3.value == ""){
    document.getElementById("collapseParticipante3").classList.add("show");
    //alert("Nome não informado");
    anexoPlanoDeTrabalho3.focus();
    return true;
  }
}

function validarMedia(input) {
        let valor = parseFloat(input.value);
        if (valor > 10) {
            input.value = 10;
        } else if (valor < 0) {
            input.value = 0;
        }
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  // $("#button").click(function(e){
  //   e.preventDefault();

  //   $.ajax({
  //     headers: {
  //       'X-CSRF-Token': $('input[name="_token"]').val()
  //     },
  //     url: "{{route('trabalho.store')}}",
  //     type: 'post',
  //     enctype: 'multipart/form-data',
  //     success: function(result){
  //       console.log("success")
  //       console.log(result)
  //     },
  //     erro: (xhr,status,error) => {
  //       console.log("erro")
  //     }
  //   });
  // });
</script>
@endsection
