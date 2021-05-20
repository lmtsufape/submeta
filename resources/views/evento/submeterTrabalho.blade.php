@extends('layouts.app')

@section('content')
<div class="container content">
  <div class="row justify-content-center">
    <div class="col-sm-10">
      <div class="card" style="margin-top:50px; border-radius:12px">
        <div class="card-header" style="background-color: #fff; border-top-left-radius:12px; border-top-right-radius:12px; border-bottom-radius:0px; margin-bottom:-2.5rem; border: none;">
          <h4 style="margin-top: 10px; margin-bottom:-5px; color: #01487E; font-weight:bold; font-family:Arial, Helvetica, sans-serif">CRIAR PROJETO</h4>
          <hr style="border-bottom: 1px solid #01487E">
        </div>
        <div class="card-body" style="margin-top:0rem">
          <h5 class="card-title" style="color: #1492E6; margin-top:1rem; margin-bottom:-1rem">Informações do projeto</h5>
          <p class="card-text">
            <form method="POST" name="formTrabalho" action="{{route('trabalho.store')}}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="editalId" value="{{$edital->id}}">

              {{-- Nome do Projeto  --}}
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <label for="nomeProjeto" class="col-form-label">{{ __('Nome do Projeto') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input id="nomeProjeto" type="text" class="form-control @error('nomeProjeto') is-invalid @enderror" name="nomeProjeto" placeholder="Digite o nome do projeto" value="{{ old('nomeProjeto') !== null ? old('nomeProjeto') : (isset($rascunho) ? $rascunho->titulo : '')}}" autocomplete="nomeProjeto" autofocus required>

                  @error('nomeProjeto')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              {{-- Grande Area --}}
              <div class="row justify-content-center">
                <div class="col-sm-4">
                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
                  <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" onchange="areas()" required>
                    <option value="" disabled selected hidden>-- Grande Área --</option>
                    @foreach($grandeAreas as $grandeArea)
                    <option @if(old('grandeArea') !== null ? old('grandeArea') : (isset($rascunho) ? $rascunho->grande_area_id : '')
                            == $grandeArea->id ) selected @endif value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                    @endforeach
                  </select>

                  @error('grandeArea')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input type="hidden" id="oldArea" value="{{ old('area') }}">
                  <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" onchange="subareas()" required>
                    <option value="" disabled selected hidden>-- Área --</option>
                    {{-- @foreach($areas as $area)
                      <option @if(old('area') !== null ? old('area') : (isset($rascunho) ? $rascunho->area_id : '')
                              ==$area->id ) selected @endif value="{{$area->id}}">{{$area->nome}}</option>
                    @endforeach --}}
                  </select>

                  @error('area')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="subArea" class="col-form-label">{{ __('Subárea') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input type="hidden" id="oldSubArea" value="{{ old('subArea') }}">
                  <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea" required>
                    <option value="" disabled selected hidden>-- Subárea --</option>
                    {{-- @foreach($subAreas as $subArea)
                      <option @if(old('subArea') !== null ? old('subArea') : (isset($rascunho) ? $rascunho->sub_area_id : '')
                              ==$subArea->id ) selected @endif value="{{$subArea->id}}">{{$subArea->nome}}</option>
                    @endforeach --}}
                  </select>

                  @error('subArea')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <h5 class="card-title" style="color: #1492E6; margin-top:1rem; margin-bottom:-0.1rem">Proponente</h5>

              {{-- Coordenador  --}}
              <div class="row justify-content-center">

                <div class="col-sm-6">
                  <label for="nomeCoordenador" class="col-form-label">{{ __('Proponente') }}</label>
                  <input class="form-control" type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                </div>
                <div class="col-sm-6">
                  <label for="linkLattesEstudante" class="col-form-label">Link Lattes do Proponente <span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante"
                  @if(Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null)
                    value="{{ Auth()->user()->proponentes->linkLattes }}"
                  @else
                  value=""
                  @endif required>
                  <small>Exemplo: http://lattes.cnpq.br/8363536830656923</small>

                  @error('linkLattesEstudante')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6 mt-1">
                  <label for="pontuacaoPlanilha" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha"
                          value="{{old('pontuacaoPlanilha') !== null ? old('pontuacaoPlanilha') : (isset($rascunho) ? $rascunho->pontuacaoPlanilha : '')}}" required>

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="linkGrupo" class="col-form-label">{{ __('Link do grupo de pesquisa') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo"
                          value="{{old('linkGrupo') !== null ? old('linkGrupo') : (isset($rascunho) ? $rascunho->linkGrupoPesquisa : '')}}" required>

                  <small>Exemplo: http://dgp.cnpq.br/dgp/espelhogrupo/228363</small>
                  @error('linkGrupo')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

              </div>

              <h5 class="card-title" style="color: #1492E6; margin-top:15px; margin-bottom:-0.1rem">Anexos</h5>

              {{-- Anexo do Projeto --}}
              <div class="row justify-content-center">
                {{-- Arquivo  --}}
                <div class="col-sm-6">
                  <label for="anexoProjeto" class="col-form-label">{{ __('Anexo do projeto') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoProjetoPreenchido') != null || (isset($rascunho) && $rascunho->anexoProjeto != ""))
                  <a id="anexoProjetoTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoProjeto' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoProjetoPreenchido" name="anexoProjetoPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoProjeto != "") value="sim" @else value="{{old('anexoProjetoPreenchido')}}" @endif required>
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoProjeto') is-invalid @enderror" id="anexoProjeto" aria-describedby="inputGroupFileAddon01" name="anexoProjeto" onchange="verificarArquivoAnexado_pdf(this)" required>
                      <label class="custom-file-label" id="custom-file-label" for="anexoProjeto">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoProjeto')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6">
                  <label for="anexoLattesCoordenador" class="col-form-label">{{ __('Anexo do currículo Lattes do Coordenador') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoLattesPreenchido') != null || (isset($rascunho) && $rascunho->anexoLattesCoordenador != ""))
                  <a id="anexoLattesTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoLattesCoordenador' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoLattesPreenchido" name="anexoLattesPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoLattesCoordenador != "") value="sim" @else value="{{old('anexoLattesPreenchido')}}" @endif >

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoLattesCoordenador') is-invalid @enderror" id="anexoLattesCoordenador" aria-describedby="anexoLattesCoordenador" name="anexoLattesCoordenador" onchange="verificarArquivoAnexado_pdf(this)" required>
                      <label class="custom-file-label" id="custom-file-label" for="anexoLattesCoordenador">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  <small>Dos últimos 5 anos</small>
                  @error('anexoLattesCoordenador')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6 mt-3">
                  <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo da Planilha de Pontuação') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoPlanilhaPreenchido') != null || (isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != ""))
                  <a id="anexoPlanilhaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoPlanilhaPontuacao' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoPlanilhaPreenchido" name="anexoPlanilhaPreenchido" 
                    @if( isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != "") value="sim" @else value="{{old('anexoPlanilhaPreenchido')}}" @endif >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoPlanilha') is-invalid @enderror" id="anexoPlanilha" aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha" onchange="verificarArquivoAnexado_xls_xlsx_ods(this)" required>
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
                  @enderror
                </div>
                {{-- Decisão do CONSU --}}
                <div class="col-sm-6" style="margin-top: 15px">
                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoConsuPreenchido') != null || (isset($rascunho) && $rascunho->anexoDecisaoCONSU != "" && $rascunho->anexoDecisaoCONSU != null))
                  <a id="anexoConsuTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoDecisaoCONSU' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoConsuPreenchido" name="anexoConsuPreenchido"
                   @if( isset($rascunho) && $rascunho->anexoDecisaoCONSU != "") value="sim" @else value="{{old('anexoConsuPreenchido')}}" @endif required>
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoCONSU') is-invalid @enderror" id="anexoCONSU" aria-describedby="inputGroupFileAddon01" name="anexoCONSU" onchange="verificarArquivoAnexado_pdf(this)" required>
                      <label class="custom-file-label" id="custom-file-label" for="anexoCONSU">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoCONSU')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6" style="margin-top: 15px">
                
                  <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="margin-right: 15px;">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label>
                  <input type="radio" id="radioSim" onchange="displayAutorizacoesEspeciais('sim')">
                  <label for="radioSim" style="margin-right: 5px">Sim</label>
                  <input type="radio" id="radioNao" onchange="displayAutorizacoesEspeciais('nao')">
                  <label for="radioNao" style="margin-right: 5px">Não</label><br>
                  <span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                    <strong>Selecione a autorização e envie o arquivo!</strong>
                  </span>
                  
                  <div class="form-group" id="displaySim" style="display: none; margin-top:-1rem">
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
                  </div>
                  
                </div>


                <div class="form-group col-md-6 mt-3" style="margin-bottom:-0.5rem;">
                  

                @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                
                @endif

              </div>
            </div>

              <div class="d-flex justify-content-between align-items-center" style="margin-top:2.5rem; margin-bottom:-0.2rem">
                <h4 style="margin-top: 10px; margin-bottom:-5px; color: #01487E; font-weight:bold; font-family:Arial, Helvetica, sans-serif; margin-right:15px">PARTICIPANTE</h4>
                <button class="btn btn-primary" id="addCoautor" style="">Adicionar participante</button>
              </div>
              <hr style="border-bottom: 1px solid #01487E">
              {{-- Participantes  --}}
              <div class="row" style="margin-top:20px">
                <div class="col-sm-12">
                  <div id="participantes">

                    @php $countParticipante = 1; @endphp
                    @if(old('countParticipante') != null)
                      @php $countParticipante = old('countParticipante') @endphp
                    @endif

                    @if ($countParticipante != null && $countParticipante > 0)
                      @for ($i = 0; $i < $countParticipante; $i++)
                      {{-- inicio do card --}}
                      {{-- <div class="card" >
                        <div class="card-body"> --}}

                        <div id="novoParticipante" style="display: block; margin-top:-1rem;">
                          
                          <div style="background-color: #9FCAEB; margin-left:-20px; margin-right:-20px">
                            <div class="d-flex justify-content-between align-items-center" style="margin-top: 5px; margin-bottom:4px; margin-left:1px; margin-right:20px">
                              <div class="container" style="margin-left: 5px; height:40px;">
                                <h5 style="padding-top:10px; padding-bottom:15px; color:#01487E">Participante</label>
                              </div>
                              <div>
                                <button class="btn btn-danger mt-2 mb-2 delete" style='width:100%;margin-top:10px' disabled>Limite minimo de participantes</button>
                              </div>
                            </div>
                          </div>
                          <h5 class="card-title" style="color: #1492E6; margin-top:1.3rem; margin-bottom:0.7rem">Dados do participante</h5>
                          <div class="row">
                            <div class="col-sm-6">
                              <label>Nome Completo <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Digite o nome do participante" value="{{old('nomeParticipante.'.$i)}}" required>
                              @error('nomeParticipante.'.$i)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-6">
                              <label>E-mail <span style="color: red; font-weight:bold">*</span></label>
                              <input type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="Digite o e-mail do participante" value="{{old('emailParticipante.'.$i)}}" required>
                              @error('emailParticipante.'.$i)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-3">
                              <input type="hidden" name="funcaoParticipante[]" value="4">
                              
                            </div>
                          </div>
                          <div id="dados_complemento_1">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('Data de nascimento ') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="date" class="form-control" name="data_de_nascimento[]" required>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('CPF') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control cpf" placeholder="000.000.000-00" name="cpf[]" required>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('RG') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control rg" placeholder="00.000.000-0" name="rg[]" required>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('Celular') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control celular" placeholder="(00) 00000-0000" name="celular[]" required>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h5 style="color: #1492E6; margin-top:0.5rem; margin-bottom:-0.2rem">Endereço do participante</h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('CEP') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o CEP do participante" name="cep[]" required>
                                </div>
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Estado') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="uf[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- Selecione o estado --</option>
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
                                <div class="col-sm-6" style="">
                                  <label for="">{{ __('Cidade') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control " placeholder="Digite o nome da cidade" name="cidade[]" required>
                                  
                                </div>
                                <div class="col-sm-6" >
                                  <label for="">{{ __('Bairro') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome do bairro" name="bairro[]" required>
                                </div>
                                
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Rua') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da rua" name="rua[]" required>
                                </div>

                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Número') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da rua" name="numero[]" required>
                                </div>

                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                
                                <div class="col-sm-12">
                                  <label for="">{{ __('Complemento') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <textarea type="text" class="form-control" placeholder="Apartamento, casa, sítio..." name="complemento[]" required></textarea>
                                </div>
                                
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h5 style="color: #1492E6; margin-top:0.5rem; margin-bottom:0.7rem">Dados do curso do participante</h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12">
                                  <label for="">{{ __('Universidade') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da universidade" name="universidade[]" required>
                                </div>
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Curso') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome do curso" name="curso[]" required>
                                </div>
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Turno') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <select id="" class="form-control" name="turno[]" required>
                                    <option value="" disabled selected>-- TURNO --</option>
                                    @foreach ($enum_turno as $turno)
                                      <option value="{{$turno}}">{{$turno}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 2rem">
                              <div class="row">
                                
                                <div class="col-sm-3" style="margin-top: 15px">
                                  <label for="">{{ __('Total de períodos do curso') }} <span style="color: red; font-weight:bold">*</span></label>
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
                                <div class="col-sm-3" style="margin-top: 15px">
                                  <label for="">{{ __('Período atual') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="periodo_cursado[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                  </select>
                                </div>
                                <div class="col-sm-3" style="margin-top: 15px">
                                  <label for="">{{ __('Ordem de prioridade') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="ordem_prioridade[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    <option value="1">1º</option>
                                    <option value="2">2º</option>
                                    <option value="3">3º</option>
                                    <option value="4">4º</option>
                                  </select>
                                </div>
                                <div class="col-sm-3" style="margin-top: 15px">
                                  <label for="">{{ __('Coeficiente de rendimento') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="number" class="form-control media" min="0" max="10" step="0.01" value="00.00" name="media_geral_curso[]" required>
                                </div>
                                <div class="col-sm-12">
                                  <div class="row">
                                    <div class="container">
                                      <h5 style="color: #1492E6; margin-top:1.5rem; margin-bottom:0.7rem">Plano de trabalho</h5>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <label>Titulo <span style="color: red; font-weight:bold">*</span> </label>
                                    <input type="text" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" value="{{old('nomePlanoTrabalho.'.$i)}}" required>
                                    @error('nomePlanoTrabalho')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                  <div class="custom-file">
                                    <label for="nomeTrabalho">Anexo <span style="color: red; font-weight:bold">*</span></label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoTrabalho" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this)" required>
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

                      {{--  </div>
                      </div> --}}
                      {{-- inicio do card --}}
                      @endfor
                    @endif
                  </div>
                  <input type="hidden" name="countParticipante" id="countParticipante" value="{{ old('countParticipante') != null ? old('countParticipante') : 1}}">

                </div>
              </div>
              <hr>
              </p>
              <div class="row justify-content-center">
                {{-- <div class="col-md-6">
                  <button type="submit" formaction="{{route('trabalho.storeParcial')}}" class="btn btn-primary" style="width:100%;margin-bottom:10px">
                    {{ __('Salvar como Rascunho') }}
                  </button>
                </div> --}}
                <div class="col-md-12 d-flex justify-content-between align-items-center" style="margin-top:0.5rem; margin-bottom:-1rem">
                  <h6 style="font-family:Arial, Helvetica, sans-serif; margin-right:15px"><span style="color: red; font-weight:bold">*</span> Campos obrigatórios</h6>
                  <button type="submit" class="btn btn-success" style="" onclick="validarForm()">{{ __('Enviar Projeto') }}</button>
                </div>
                
              </div>
              <br>
              <!--<div class="row justify-content-center">
                <div class="col-sm-12">
                  @if (Auth()->user()->administradors != null)
                    <a href="{{ route('admin.editais') }}" class="btn btn-secondary" style="width:100%">Cancelar</a>
                  @else
                    <a href="{{ route('proponente.projetosEdital', ['id' => $edital->id]) }}" class="btn btn-secondary" style="width:100%">Cancelar</a>
                  @endif
                </div>
              </div>-->
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
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
        linha = montarLinhaInput(parseInt(countParticipante.value) + 1);
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

    $('#addPlanoTrabalho').click(function(e) {
      e.preventDefault();
      if (qtdLinhas < 4) {
        linha = montarLinhaInputPlanoTrabalho();
        //$('#planoTrabalho').append(linha);
        qtdLinhas++;
      }
    });
    // // Exibir modalidade de acordo com a área
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
    $('.custom-file-input').on('change', function() {
      var fieldVal = $(this).val();

      // Change the node's value by removing the fake path (Chrome)
      fieldVal = fieldVal.replace("C:\\fakepath\\", "");

      if (fieldVal != undefined || fieldVal != "") {
        $(this).next(".custom-file-label").attr('data-content', fieldVal);
        $(this).next(".custom-file-label").text(fieldVal);
      }
    })
    // F
    $('#buttonSim').on('click', function(e) {
      e.preventDefault();
      $('#inputEtica').prop('disabled', false);
      $('#inputJustificativa').prop('disabled', true);
      exibirErro('comite');
     // $('#anexoJustificativaPreenchido').val("");
    });
    $('#buttonNao').on('click', function(e) {
      e.preventDefault();
      $('#inputEtica').prop('disabled', true);
      $('#inputJustificativa').prop('disabled', false);
      exibirErro('justificativa');
      //$('#anexoComitePreenchido').val("");
    });
    // document.getElementsByClassName('.simPlano .naoPlano').addEventListener("click", function(event){
    //   event.preventDefault()
    // });

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

  });

  function exibirErro(campo) {
    var botao = document.getElementById('botao');
    botao.value = "sim";
    var comiteErro = document.getElementById('comiteErro');
    var justificativaErro = document.getElementById('justificativaErro');

    if(comiteErro != null || justificativaErro != null){
      if (campo === 'comite') {
        comiteErro.style.display = "block";
        justificativaErro.style.display = "none";
      } else if (campo === 'justificativa') {
        comiteErro.style.display = "none";
        justificativaErro.style.display = "block";
      }
    }
  }

  function habilitarBotao(){
    var anexoComitePreenchido = document.getElementById('anexoComitePreenchido');
    var anexoJustificativaPreenchido = document.getElementById('anexoJustificativaPreenchido');

    if(anexoComitePreenchido.value == "sim"){
      $('#inputEtica').prop('disabled', false);
      $('#inputJustificativa').prop('disabled', true);
      exibirErro('comite');
    } else if(anexoJustificativaPreenchido.value == "sim"){
      $('#inputEtica').prop('disabled', true);
      $('#inputJustificativa').prop('disabled', false);
      exibirErro('justificativa');
    }
  }
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

  function montarLinhaInput(valor) {

    return `<div id="novoParticipante" style="display: block; margin-top:-1rem">
                          
                          <div style="background-color: #9FCAEB; margin-left:-20px; margin-right:-20px">
                            <div class="d-flex justify-content-between align-items-center" style="margin-top: 5px; margin-bottom:4px; margin-left:1px; margin-right:20px">
                              <div class="container" style="margin-left: 5px; height:40px;">
                                <h5 style="padding-top:10px; padding-bottom:15px; color:#01487E">Participante</label>
                              </div>
                              <div>
                                <button class="btn btn-danger mt-2 mb-2 delete" style='width:100%;margin-top:10px' disabled>Limite minimo de participantes</button>
                              </div>
                            </div>
                          </div>
                          <h5 class="card-title" style="color: #1492E6; margin-top:1.3rem; margin-bottom:0.7rem">Dados do participante</h5>
                          <div class="row">
                            <div class="col-sm-6">
                              <label>Nome Completo  <span style="color: red; font-weight:bold">*</span></label>
                              <input type="text" id="nomeParticipante${valor}" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Digite o nome do participante" value="{{old('nomeParticipante.'.$i)}}" required>
                              @error('nomeParticipante.'.$i)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-6">
                              <label>E-mail  <span style="color: red; font-weight:bold">*</span></label>
                              <input type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="Digite o e-mail do participante" value="{{old('emailParticipante.'.$i)}}" required>
                              @error('emailParticipante.'.$i)
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                            <div class="col-sm-3">
                              <input type="hidden" name="funcaoParticipante[]" value="4">
                              
                            </div>
                          </div>
                          <div id="dados_complemento_1">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('Data de nascimento') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="date" class="form-control" name="data_de_nascimento[]" required>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('CPF') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control cpf${valor}" id="cpf${valor}" minlength="14" maxlength="14" onkeyup="verificaCampos(this, 'cpf')"  placeholder="000.000.000-00" name="cpf[]" required>
                                  <span id="idAvisoCpfParticipantecpf${valor}" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                                    <strong>Preencha o campo neste formato 000.000.000-00</strong>
                                  </span>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('RG') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control rg${valor}" id="rg${valor}" onkeyup="verificaCampos(this, 'rg')" placeholder="00.000.000-0" name="rg[]" required>
                                  <span id="idAvisoRgParticipanterg${valor}" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                                  <strong>Preencha o campo com números</strong>
                                </span>
                                </div>
                                <div class="col-sm-3" style="margin-top: 5px">
                                  <label for="">{{ __('Celular') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control celular${valor}" id="celular${valor}" onkeyup="verificaCampos(this, 'celular')" placeholder="(00) 00000-0000" name="celular[]" required>
                                  <span id="idAvisoCelularParticipantecelular${valor}" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h5 style="color: #1492E6; margin-top:0.5rem; margin-bottom:-0.2rem">Endereço do participante</h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('CEP') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o CEP do participante" name="cep[]" required>
                                </div>
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Estado') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="uf[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- Selecione o estado --</option>
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
                                <div class="col-sm-6" style="">
                                  <label for="">{{ __('Cidade') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control " placeholder="Digite o nome da cidade" name="cidade[]" required>
                                  
                                </div>
                                <div class="col-sm-6" style="">
                                  <label for="">{{ __('Bairro') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome do bairro" name="bairro[]" required>
                                </div>
                                
                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Rua') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da rua" name="rua[]" required>
                                </div>

                                <div class="col-sm-6" style="margin-top: 15px">
                                  <label for="">{{ __('Número') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da rua" name="numero[]" required>
                                </div>

                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                
                                <div class="col-sm-12">
                                  <label for="">{{ __('Complemento') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <textarea type="text" class="form-control" placeholder="Apartamento, casa, sítio..." name="complemento[]" required></textarea>
                                </div>
                                
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="container">
                                  <h5 style="color: #1492E6; margin-top:0.5rem; margin-bottom:0.7rem">Dados do curso do participante</h5>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-12">
                                  <label for="">{{ __('Universidade') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome da universidade" name="universidade[]" required>
                                </div>
                                <div class="col-sm-6">
                                  <label for="">{{ __('Curso') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="text" class="form-control" placeholder="Digite o nome do curso" name="curso[]" required>
                                </div>
                                <div class="col-sm-6">
                                  <label for="">{{ __('Turno') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select id="" class="form-control" name="turno[]" required>
                                    <option value="" disabled selected>-- TURNO --</option>
                                    @foreach ($enum_turno as $turno)
                                      <option value="{{$turno}}">{{$turno}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-group"  style="margin-bottom: 2rem">
                              <div class="row">
                                
                                <div class="col-sm-3">
                                  <label for="">{{ __('Total de períodos do curso') }}  <span style="color: red; font-weight:bold">*</span></label>
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
                                <div class="col-sm-3">
                                  <label for="">{{ __('Período atual') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="periodo_cursado[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Ordem de prioridade') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="ordem_prioridade[]" id="" class="form-control" required>
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    <option value="1">1º</option>
                                    <option value="2">2º</option>
                                    <option value="3">3º</option>
                                    <option value="4">4º</option>
                                  </select>
                                </div>
                                <div class="col-sm-3">
                                  <label for="">{{ __('Coeficiente de rendimento') }} <span style="color: red; font-weight:bold">*</span></label>
                                  <input type="number" class="form-control media" min="0" max="10" step="0.01" value="00.00" name="media_geral_curso[]" required>
                                </div>
                                <div class="col-sm-12">
                                  <div class="row">
                                    <div class="container">
                                      <h5 style="color: #1492E6; margin-top:1.5rem; margin-bottom:0.7rem">Plano de trabalho</h5>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <label>Titulo  <span style="color: red; font-weight:bold">*</span></label>
                                    <input type="text" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" value="{{old('nomePlanoTrabalho.'.$i)}}" required>
                                    @error('nomePlanoTrabalho')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                  <div class="custom-file">
                                    <label for="nomeTrabalho">Anexo <span style="color: red; font-weight:bold">*</span></label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoTrabalho" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this)" required>
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
                        </div>`;
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

  function exibirAnexoTemp(file){
    if(file.id === "anexoProjeto"){
      var anexoProjetoPreenchido = document.getElementById('anexoProjetoPreenchido');
      anexoProjetoPreenchido.value = "sim";
    }
    if(file.id === "anexoLattesCoordenador"){
      var anexoLattesPreenchido = document.getElementById('anexoLattesPreenchido');
      anexoLattesPreenchido.value = "sim";
    }
    if(file.id === "inputEtica"){
      var anexoComitePreenchido = document.getElementById('anexoComitePreenchido');
      var anexoJustificativaPreenchido = document.getElementById('anexoJustificativaPreenchido');
      anexoComitePreenchido.value = "sim";
      anexoJustificativaPreenchido.value = "";
    }
    if(file.id === "inputJustificativa"){
      var anexoComitePreenchido = document.getElementById('anexoComitePreenchido');
      var anexoJustificativaPreenchido = document.getElementById('anexoJustificativaPreenchido');
      anexoJustificativaPreenchido.value = "sim";
      anexoComitePreenchido.value = "";
    }
    if(file.id === "anexoCONSU"){
      var anexoConsuPreenchido = document.getElementById('anexoConsuPreenchido');
      anexoConsuPreenchido.value = "sim";
    }
    if(file.id === "anexoPlanilha"){
      var anexoPlanilhaPreenchido = document.getElementById('anexoPlanilhaPreenchido');
      anexoPlanilhaPreenchido.value = "sim";
    }
  }

  function removerPlanilha(){
    console.log('a');
    $('#anexoPlanilhaPreenchido').val("");
  }
  window.onload = areas();
  window.onload = habilitarBotao();

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
    var selectPeriodos = div.children[1].children[1];

    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(select.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }

    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);
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
    
    if(item.files[0].type.split('/')[1] != "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo PDF! ";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
    }else if(item.files[0].size > 2000000 && item.files[0].type.split('/')[1] == "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
    }
  }
  /*  
* FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (XLS, XLSX, ODS)
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
/* FUNCAO: validar formulario
*
*/
function validarForm(){
  var buttonRadioSim = document.getElementById("radioSim");
  var buttonRadioNao = document.getElementById("radioNao");
  
  //button radio
  if(buttonRadioSim.checked == false && buttonRadioNao.checked == false){
    document.getElementById("idAvisoAutorizacaoEspecial").style.display = "block";
  }  
}
var novoRG = "";
function verificaCampos(input, tipo){
  if(tipo == "cpf"){
  var regExp = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/g;
    if(regExp.test(input.value) == false){
      document.getElementById(input.id).style.borderColor = "red";
      document.getElementById("idAvisoCpfParticipante"+input.id).style.display="block";
    }else{
      document.getElementById(input.id).style.borderColor = "#c6c8ca";
      document.getElementById("idAvisoCpfParticipante"+input.id).style.display="none";
    }
  }else if(tipo == "rg"){
    var regExp = /[0-9]$/g;
    if(regExp.test(input.value) == false){
      document.getElementById(input.id).style.borderColor = "red";
      document.getElementById("idAvisoRgParticipante"+input.id).style.display="block";
    }else{
      document.getElementById(input.id).style.borderColor = "#c6c8ca";
      document.getElementById("idAvisoRgParticipante"+input.id).style.display="none";
    }
  }
}


function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}




</script>
@endsection
