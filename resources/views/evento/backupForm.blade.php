@extends('layouts.app')

@section('content')

<div>
  <form method="POST" id="criarProjetoForm"  action="{{route('trabalho.store')}}" enctype="multipart/form-data" onsubmit="return validarForm(this)">
  @csrf
  <input type="hidden" name="editalId" value="{{$edital->id}}">

  <div class="container">
    <div class="row justify-content-center">
      
      <!-- projeto -->
      <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">1º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do projeto</h5></div>
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px">
          
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do projeto</h5></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-12" style="margin-top: 10px">
                    <label for="nomeProjeto" class="col-form-label">{{ __('Nome do Projeto') }} <span style="color: red; font-weight:bold">*</span></label>
                    <input id="nomeProjeto" type="text" class="form-control @error('nomeProjeto') is-invalid @enderror" name="nomeProjeto" placeholder="Digite o nome do projeto" value="{{ old('nomeProjeto') !== null ? old('nomeProjeto') : (isset($rascunho) ? $rascunho->titulo : '')}}" autocomplete="nomeProjeto" >
                    @error('nomeProjeto')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" onchange="areas()" >
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
                <div class="form-group col-md-4">
                  <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
                    <input type="hidden" id="oldArea" value="{{ old('area') }}">
                    <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" onchange="subareas()" >
                      <option value="" disabled selected hidden>-- Área --</option>
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
                    <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea" >
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
          </div>
          </div>
        </div>
      </div>
      <!--X projeto X-->
      <!-- Proponente -->
      <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">2º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do proponente</h5></div>
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px">
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do proponente</h5></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-12" style="margin-top: 15px">
                  <label for="nomeCompletoProponente1">Proponente</label>
                  <input class="form-control" type="text" id="nomeCompletoProponente1" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                 
                </div>

                <div class="form-group col-md-4">
                  <label for="linkLattesEstudante">Link do currículo Lattes<span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante" 
                  @if(Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null)
                    value="{{ Auth()->user()->proponentes->linkLattes }}"
                  @else
                  value=""
                  @endif >
                  <small>Ex.: http://lattes.cnpq.br/8363536830656923</small>
                  @error('linkLattesEstudante')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-4">
                  <label for="pontuacaoPlanilha">Pontuação da planilha de pontuação <span style="color: red; font-weight:bold">*</span></label>
                  <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha"
                          value="{{old('pontuacaoPlanilha') !== null ? old('pontuacaoPlanilha') : (isset($rascunho) ? $rascunho->pontuacaoPlanilha : '')}}" >

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-4">
                  <label for="linkGrupo">Link do grupo de pesquisa</label>
                  <input class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo"
                          value="{{old('linkGrupo') !== null ? old('linkGrupo') : (isset($rascunho) ? $rascunho->linkGrupoPesquisa : '')}}">

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
      <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">3º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Anexos</h5></div>
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px">
          <div class="card-body">
            <div class="container">
              <div class="form-row mt-3">
                <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Anexos</h5></div>
                <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

                <div class="form-group col-md-6" style="margin-top: 10px">
                  <label for="anexoProjeto" class="col-form-label">{{ __('Anexo do projeto') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoProjetoPreenchido') != null || (isset($rascunho) && $rascunho->anexoProjeto != ""))
                  <a id="anexoProjetoTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoProjeto' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" name="anexoProjetoPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoProjeto != "") value="sim" @else value="{{old('anexoProjetoPreenchido')}}" @endif >
                    
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" id="anexoProjeto"  class="custom-file-input @error('anexoProjeto') is-invalid @enderror" id="anexoProjeto" aria-describedby="anexoProjeto" name="anexoProjeto" onchange="verificarArquivoAnexado_pdf(this, 'anexoProjetoLegenda')" >
                      <label class="custom-file-label" id="anexoProjetoLegenda" for="anexoProjeto">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoProjeto')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group col-md-6" style="margin-top: 10px">
                  <label for="anexoLattesCoordenador" class="col-form-label">{{ __('Anexo do currículo Lattes do Coordenador') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoLattesPreenchido') != null || (isset($rascunho) && $rascunho->anexoLattesCoordenador != ""))
                  <a id="anexoLattesTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoLattesCoordenador' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoLattesPreenchido" name="anexoLattesPreenchido"
                    @if( isset($rascunho) && $rascunho->anexoLattesCoordenador != "") value="sim" @else value="{{old('anexoLattesPreenchido')}}" @endif >

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoLattesCoordenador') is-invalid @enderror" id="anexoLattesCoordenador" aria-describedby="anexoLattesCoordenador" name="anexoLattesCoordenador" onchange="verificarArquivoAnexado_pdf(this, 'anexoLattesCoordenadorLegenda')" >
                      <label class="custom-file-label" id="anexoLattesCoordenadorLegenda" for="anexoLattesCoordenador">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  <small>Dos últimos 5 anos</small>
                  @error('anexoLattesCoordenador')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo da Planilha de Pontuação') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoPlanilhaPreenchido') != null || (isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != ""))
                  <a id="anexoPlanilhaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoPlanilhaPontuacao' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoPlanilhaPreenchido" name="anexoPlanilhaPreenchido" 
                    @if( isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != "") value="sim" @else value="{{old('anexoPlanilhaPreenchido')}}" @endif >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoPlanilha') is-invalid @enderror" id="anexoPlanilha" aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha" onchange="verificarArquivoAnexado_xls_xlsx_ods(this, 'anexoPlanilhaLegenda')" >
                      <label class="custom-file-label" id="anexoPlanilhaLegenda" for="anexoPlanilha">Formato do arquivo: XLS, XLSX ou ODS de até 2MB.</label>
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
                <div class="form-group col-md-6">
                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU') }} <span style="color: red; font-weight:bold">*</span></label>
                  @if(old('anexoConsuPreenchido') != null || (isset($rascunho) && $rascunho->anexoDecisaoCONSU != "" && $rascunho->anexoDecisaoCONSU != null))
                  <a id="anexoConsuTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoDecisaoCONSU' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoConsuPreenchido" name="anexoConsuPreenchido"
                   @if( isset($rascunho) && $rascunho->anexoDecisaoCONSU != "") value="sim" @else value="{{old('anexoConsuPreenchido')}}" @endif >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoCONSU') is-invalid @enderror" id="anexoCONSU" aria-describedby="inputGroupFileAddon01" name="anexoCONSU" onchange="verificarArquivoAnexado_pdf(this, 'anexoCONSULegenda')" >
                      <label class="custom-file-label" id="anexoCONSULegenda" for="anexoCONSU">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('anexoCONSU')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-6">
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
                          <input type="file" class="custom-file-input @error('anexoComiteEtica') is-invalid @enderror" id="inputEtica" aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica" onchange="verificarArquivoAnexado_pdf(this, 'anexoComiteEticaLegenda')">
                          <label class="custom-file-label" id="anexoComiteEticaLegenda" for="inputEtica">O arquivo deve ser no formato PDF de até 2MB.</label>
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
                            <input type="file" class="custom-file-input @error('justificativaAutorizacaoEtica') is-invalid @enderror" id="inputJustificativa" aria-describedby="inputGroupFileAddon01" name="justificativaAutorizacaoEtica" onchange="verificarArquivoAnexado_pdf(this, 'justificativaAutorizacaoEticaLegenda')" >
                            <label class="custom-file-label" id="justificativaAutorizacaoEticaLegenda" for="inputJustificativa">O arquivo deve ser no formato PDF de até 2MB.</label>
                          </div>
                        </div>
                        @error('justificativaAutorizacaoEtica')
                        <span id="justificativaErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                  </div>
                </div>
                
              </div>
          </div>
          </div>
        </div>
      </div>
      <!--X Anexos X-->
      <!-- Participantes -->
      <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">4º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Área do(s) discente(s)</h5></div>
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px; padding:15px">
          <div class="card-body" style="margin-bottom: -2rem">
            <div class="d-flex justify-content-between align-items-center">
              <div><h5 style="color: #1492E6; margin-top:0.5rem">Discente(s)</h5></div>
              <div>

                
                <button type="button" class="btn btn-light" onclick="novoParticipante()">Adicionar discente</button>

              </div>
            </div>
            <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
          </div>

          <div class="card-body" id="selecaoParticipantes" style="text-align: center; display:none; margin-top:1rem">
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

          <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
            <li>

            </li>

          </ol>

        </div>
      </div>
      <!--X Participantes X-->

      <!-- Finalizar -->
      <div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">5º Passo</h4></div>
      <div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Finalizar</h5></div>
      <div class="col-md-10">
        <div class="card" style="border-radius: 12px">
        <div class="card-body">
          <div class="container">
            <div class="form-row mt-3">
              <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Finalizar</h5></div>
              <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>
            </div>
            <div class=" d-flex justify-content-between align-items-center" style="margin-top: 15px; margin-bottom:18px">
              <h6 style="font-family:Arial, Helvetica, sans-serif; margin-right:15px"><span style="color: red; font-weight:bold">*</span> Campos obrigatórios</h6>
              
              <button type="submit" class="btn btn-success" id="idButtonSubmitProjeto" >{{ __('Enviar Projeto') }}</button>
            </div>
          </div>
        </div>
        </div>
      </div>
      <!--X Finalizar X-->
    </div>
  </div>
  </form>
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

</div>


@endsection

@section('javascript')
<script type="text/javascript">



/*
* ARRAY
* 
*/
let arrayElementos = ['3','2','1']

/*
* FUNCAO: Funcao novo participante
* 
*/
function novoParticipante(){

  if(arrayElementos.length > 0){
    $("ol").append(blocoDeCodigo(arrayElementos.pop()));
  }else{
    alert("Você atingiu o limite máximo de participantes")
  }
}
/*
* FUNCAO: Funcao remove o participante
* ENTRADA: <li>, (int)valor
*/
function removerParticipante(valor, id){
  let participante = document.getElementById(valor);
  //console.log(valor, id, participante)
  arrayElementos.push(id);
  participante.remove();
}

/*
* FUNCAO: Bloco de codigo contendo os campos do participante
*/
function blocoDeCodigo(valor){
  //return "<li id='item"+valor+"'>Appended item "+valor+"  <button type='button' onclick='removerParticipante(item"+valor+","+valor+")'>remover</button> <input id='idNomeTeste'"+valor+" type='text' name='nome[]'></li>"
  return `
  <li id="item${valor}">
    
    <div style="margin-bottom:15px">
              <div class="form-row">
                <div class="col-md-12">
                  <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante${valor}" href="#collapseParticipante${valor}" role="button" aria-expanded="false" aria-controls="collapseParticipante${valor}" style="width: 100%; text-align:left">
                    <div class="d-flex justify-content-between align-items-center">
                      <h4 id="tituloParticipante${valor}" style="color: #01487E; font-size:17px; margin-top:5px">Participante </h4>
                    </div>
                  </a>
                </div>
                <div class="col-md-12">
                  <div class="collapse" id="collapseParticipante${valor}">
                    <div class="container">
                        <div class="form-row mt-3">
                          <button type='button' onclick='removerParticipante("item${valor}","${valor}")'>remover</button>
                          <div class="col-md-12"><h5>Dados do participante</h5></div>

                          <div class="form-group col-md-6">
                            <label for="nomeCompletoParticipante${valor}">Nome completo <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control js-input-name @error('nomeCompletoParticipante${valor}') is-invalid @enderror" id="nomeCompletoParticipante${valor}"  name="nomeParticipante[]" placeholder="Digite o nome completo do participante" >
                            @error('nomeCompletoParticipante${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <input type="hidden"  name="funcaoParticipante[]" value="4">
                          <div class="form-group col-md-6">
                            <label for="email${valor}">E-mail <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('email${valor}') is-invalid @enderror" id="email${valor}" name="emailParticipante[]" placeholder="Digite o e-mail do participante" >
                            @error('email${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="data${valor}">Data de nascimento <span style="color: red; font-weight:bold">*</span></label>
                            <input type="date" class="form-control @error('data${valor}') is-invalid @enderror" id="data${valor}" name="data_de_nascimento[]" >
                            @error('data${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="cpf${valor}">CPF <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cpf${valor}') is-invalid @enderror" id="cpf${valor}" name="cpf[]" placeholder="Digite o CPF do participante" >
                            @error('cpf${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="rg${valor}">RG <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('rg${valor}') is-invalid @enderror" id="rg${valor}" name="rg[]" placeholder="Digite o RG do participante" >
                            @error('rg${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="celular${valor}">Celular <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('celular${valor}') is-invalid @enderror" id="celular${valor}" name="celular[]" placeholder="Digite o telefone do participante" >
                            @error('celular${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Endereço</h5></div>
                          <div class="form-group col-md-6">
                            <label for="cep${valor}">CEP <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cep${valor}') is-invalid @enderror" id="cep${valor}" name="cep[]" placeholder="Digite o CEP do participante" >
                            @error('cep${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="estado${valor}">Estado <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="uf[]" id="estado${valor}" class="form-control"   style="visibility: visible" >
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
                          <div class="form-group col-md-6">
                            <label for="cidade${valor}">Cidade <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('cidade${valor}') is-invalid @enderror" id="cidade${valor}" name="cidade[]" placeholder="Email" >
                            @error('cidade${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="bairro${valor}">Bairro <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('bairro${valor}') is-invalid @enderror" id="bairro${valor}" name="bairro[]" placeholder="Digite o nome do bairro" >
                            @error('bairro${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="rua${valor}">Rua <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('rua${valor}') is-invalid @enderror" id="rua${valor}" name="rua[]" placeholder="Digite o nome da avenida, rua, travessa..." >
                            @error('rua${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="numero${valor}">Número <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('numero${valor}') is-invalid @enderror" id="numero${valor}" name="numero[]" placeholder="Digite o número" >
                            @error('numero${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-12">
                            <label for="complemento${valor}">Complemento <span style="color: red; font-weight:bold">*</span></label>
                            <textarea type="text" class="form-control @error('complemento${valor}') is-invalid @enderror" id="complemento${valor}" name="complemento[]" placeholder="Apartamento, casa, sítio..." ></textarea>
                            @error('complemento${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Dados do curso</h5></div>
                          <div class="form-group col-md-12">
                            <label for="universidade${valor}">Universidade <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('universidade${valor}') is-invalid @enderror" id="universidade${valor}" name="universidade[]" placeholder="Digite o nome da universidade" >
                            @error('universidade${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-12">
                            <label for="curso${valor}">Curso <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('curso${valor}') is-invalid @enderror" id="curso${valor}" name="curso[]" placeholder="Digite o nome do curso" >
                            @error('curso${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="turno${valor}">Turno <span style="color: red; font-weight:bold">*</span></label>
                            <select id="turno${valor}" class="form-control" name="turno[]" >
                              <option value="" disabled selected>-- TURNO --</option>
                              @foreach ($enum_turno as $turno)
                                <option value="{{$turno}}">{{$turno}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="totalDePeriodos${valor}">{{ __('Total de períodos do curso') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="total_periodos[]" id="totalDePeriodos${valor}" class="form-control" onchange="gerarPeriodos${valor}(this)" >
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
                          <div class="form-group col-md-6">
                            <label for="periodoAtual${valor}">{{ __('Período atual') }}  <span style="color: red; font-weight:bold">*</span></label>
                            <select name="periodo_cursado[]" id="periodoAtual${valor}" class="form-control"  >
                              <option value="" disabled selected>-- PERÍODO ATUAL --</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="ordemDePrioridade${valor}">{{ __('Ordem de prioridade') }}  <span style="color: red; font-weight:bold">*</span></label>
                                  <select name="ordem_prioridade[]" id="ordemDePrioridade${valor}" class="form-control" >
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    <option value="1">1º</option>
                                    <option value="2">2º</option>
                                    <option value="3">3º</option>
                                  </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="coeficienteDeRendimento${valor}">Coeficiente de rendimento <span style="color: red; font-weight:bold">*</span></label>
                            <input type="number" class="form-control media" id="coeficienteDeRendimento${valor}" min="0" max="10" step="0.01" value="00.00" name="media_geral_curso[]" >
                            @error('coeficienteDeRendimento${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-md-12"><h5>Plano de trabalho</h5></div>
                          <div class="form-group col-md-6">
                            <label for="titulo${valor}">Título <span style="color: red; font-weight:bold">*</span></label>
                            <input type="text" class="form-control @error('titulo${valor}') is-invalid @enderror" id="titulo${valor}" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" >
                            @error('titulo${valor}')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="form-group col-md-6">
                            <label for="anexoPlanoDeTrabalho${valor}">Anexo <span style="color: red; font-weight:bold">*</span></label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoDeTrabalho${valor}" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]" onchange="verificarArquivoAnexado_pdf(this, 'anexoPlanoTrabalho${valor}')" >
                              <label class="custom-file-label" id="anexoPlanoTrabalho${valor}" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2MB.</label>
                            </div>
                            @error('anexoPlanoDeTrabalho${valor}')
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
            </div>        
    
  </li>`;
}

/*
*  FUNCAO: Alterar o nome na aba 
*
*/
$(document).on('keyup', "#nomeCompletoParticipante1",function () {
  if($(this).val().length>0){
    document.getElementById('tituloParticipante1').innerHTML = "Participante - "+$(this).val();
  }else{
    document.getElementById('tituloParticipante1').innerHTML = "Participante";
  }
});
$(document).on('keyup', "#nomeCompletoParticipante2",function () {
  if($(this).val().length>0){
    document.getElementById('tituloParticipante2').innerHTML = "Participante - "+$(this).val();
  }else{
    document.getElementById('tituloParticipante2').innerHTML = "Participante";
  }
});
$(document).on('keyup', "#nomeCompletoParticipante3",function () {
  if($(this).val().length>0){
    document.getElementById('tituloParticipante3').innerHTML = "Participante - "+$(this).val();
  }else{
    document.getElementById('tituloParticipante3').innerHTML = "Participante";
  }
});

/*
*  FUNCAOS: validar input
*/
function validarForm(form){

  //regex
  const regexNumero = /[0-9]/;
  const regexLetra = /[A-Za-z]/;
  var regexEmail = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;


  //informacoes do projeto
  let nomeDoProjeto = form.nomeProjeto.value;
  let grandeArea = form.grandeArea.value;
  let area = form.area.value;

  //informacoes do proponente
  let linkLattesEstudante = form.linkLattesEstudante.value;
  let pontuacaoPlanilha = form.pontuacaoPlanilha.value;
  let linkGrupo = form.linkGrupo.value;

  //anexos
  let anexoProjeto = form.anexoProjeto.value;
  let anexoLattesCoordenador = form.anexoLattesCoordenador.value;
  let anexoPlanilha = form.anexoPlanilha.value;
  let anexoCONSU = form.anexoCONSU.value;
  let anexoComiteEtica = form.anexoComiteEtica.value;
  let justificativaAutorizacaoEtica = form.justificativaAutorizacaoEtica.value;
  let radioSim = document.getElementById("radioSim").checked;
  let radioNao = document.getElementById("radioNao").checked;

  //participantes
  //let nomeCompletoParticipante = form.elements['nomeParticipante[]'];
  //let emailParticipante = form.elements['emailParticipante[]'];
  //console.log(nomeCompletoParticipante1)

  /*var myCollection = document.getElementsByTagName("input");
  console.log(myCollection.length, myCollection[24]);
  console.log(myCollection.length, myCollection[25]);
  console.log(myCollection.length, myCollection[26]);
  console.log(myCollection.length);

  if(toString(myCollection[24]) != 'undefined'){
    if(myCollection[24] == ""){
      alert('Digite seu nome completo');
      return false;
    }
  }
  */

  //participantes

    //participante1 - data
    if(arrayElementos.length == 3){
      alert("É necesário cadastrar pelo menos um participante!");
          return false;
    }else{
      for(i = 1; i<=3; i++){
        if(arrayElementos.includes(i.toString()) == false){
          //console.log("temos", i);
          
          //nome participante
          var elementNome =  document.getElementById('nomeCompletoParticipante'+i);
          if (typeof(elementNome) != 'undefined' && elementNome != null){
            if(elementNome.value == ""){
              alert("nome vazio");
              return false;
            }else if(regexNumero.test(elementNome.value) == true){
              alert("Você colocou número no nome do participante. Verifique o campo e tente novamente!");
              return false;
            }
          }
          //email participante
          var elementEmail =  document.getElementById('email'+i);
          if (typeof(elementEmail) != 'undefined' && elementEmail != null){
            if(elementEmail.value == ""){
              alert("email vazio");
              return false;
            }else if(regexEmail.test(elementEmail.value) == false){
              alert("Verifique o e-mail do participante e tente novamente!");
              return false;
            }
          }
          //data participante
          var elementData =  document.getElementById('data'+i);
          if (typeof(elementData) != 'undefined' && elementData != null){
            if(elementData.value == ""){
              alert("Verifique a data de nascimento do participante e tente novamente!");
              return false;
            }
          }
          //cpf participante
          var elementCpf =  document.getElementById('cpf'+i);
          if (typeof(elementCpf) != 'undefined' && elementCpf != null){
            if(elementCpf.value == ""){
              alert("cpf vazio");
              return false;
            }else if(regexLetra.test(elementCpf.value)==true){
              alert("Verifique o cpf do participante e tente novamente!");
              return false;
            }else if(validarCPF(elementCpf.value)==false){
              alert("Verifique o cpf do participante e tente novamente!");
              return false;
            }
          }
          //rg participante
          var elementRg =  document.getElementById("rg"+i);
          if (typeof(elementRg) != 'undefined' && elementRg != null){
            if(elementRg.value == ""){
              alert("rg vazio");
              return false;
            }
          }
          //celular participante
          var elementCelular =  document.getElementById('celular'+i);
          if (typeof(elementCelular) != 'undefined' && elementCelular != null){
            if(elementCelular.value == ""){
              alert("celular vazio");
              return false;
            }
          }
          //cep participante
          var elementCep =  document.getElementById('cep'+i);
          if (typeof(elementCep) != 'undefined' && elementCep != null){
            if(elementCep.value == ""){
              alert("cep vazio");
              return false;
            }
          }
          //estado participante
          var elementEstado =  document.getElementById('estado'+i);
          if (typeof(elementEstado) != 'undefined' && elementEstado != null){
            if(elementEstado.value == ""){
              alert("estado vazio");
              return false;
            }
          }
          //cidade participante
          var elementCidade =  document.getElementById('cidade'+i);
          if (typeof(elementCidade) != 'undefined' && elementCidade != null){
            if(elementCidade.value == ""){
              alert("cidade vazio");
              return false;
            }
          }
          //bairro participante
          var elementBairro =  document.getElementById('bairro'+i);
          if (typeof(elementBairro) != 'undefined' && elementBairro != null){
            if(elementBairro.value == ""){
              alert("bairro vazio");
              return false;
            }
          }
          //rua participante
          var elementRua =  document.getElementById('rua'+i);
          if (typeof(elementRua) != 'undefined' && elementRua != null){
            if(elementRua.value == ""){
              alert("rua vazio");
              return false;
            }
          }
          //numero participante
          var elementNumero =  document.getElementById('numero'+i);
          if (typeof(elementNumero) != 'undefined' && elementNumero != null){
            if(elementNumero.value == ""){
              alert("numero vazio");
              return false;
            }
          }
          //complemento participante
          var elementComplemento =  document.getElementById('complemento'+i);
          if (typeof(elementComplemento) != 'undefined' && elementComplemento != null){
            if(elementComplemento.value == ""){
              alert("complemento vazio");
              return false;
            }
          }
          //universidade participante
          var elementUniversidade =  document.getElementById('universidade'+i);
          if (typeof(elementUniversidade) != 'undefined' && elementUniversidade != null){
            if(elementUniversidade.value == ""){
              alert("Universidade vazio");
              return false;
            }
          }
          //curso participante
          var elementCurso =  document.getElementById('curso'+i);
          if (typeof(elementCurso) != 'undefined' && elementCurso != null){
            if(elementCurso.value == ""){
              alert("Curso vazio");
              return false;
            }
          }
          //turno participante
          var elementTurno =  document.getElementById('turno'+i);
          if (typeof(elementTurno) != 'undefined' && elementTurno != null){
            if(elementTurno.value == ""){
              alert("Turno vazio");
              return false;
            }
          }
          
          //totalDePeriodos participante
          var elementTotalDePeriodos =  document.getElementById('totalDePeriodos'+i);
          if (typeof(elementTotalDePeriodos) != 'undefined' && elementTotalDePeriodos != null){
            if(elementTotalDePeriodos.value == ""){
              alert("totalDePeriodos1 vazio");
              return false;
            }
          }
          //totalDePeriodos participante
          var elementPeriodoAtual =  document.getElementById('periodoAtual'+i);
          if (typeof(elementPeriodoAtual) != 'undefined' && elementPeriodoAtual != null){
            if(elementPeriodoAtual.value == ""){
              alert("periodoAtual1 vazio");
              return false;
            }
          }
          //ordemDePrioridade1 participante
          var elementOrdemDePrioridade =  document.getElementById('ordemDePrioridade'+i);
          if (typeof(elementOrdemDePrioridade) != 'undefined' && elementOrdemDePrioridade != null){
            if(elementOrdemDePrioridade.value == ""){
              alert("elementOrdemDePrioridade vazio");
              return false;
            }
          }
          //coeficienteDeRendimento1 participante
          var elementCoeficienteDeRendimento =  document.getElementById('coeficienteDeRendimento'+i);
          if (typeof(elementCoeficienteDeRendimento) != 'undefined' && elementCoeficienteDeRendimento != null){
            if(elementCoeficienteDeRendimento.value == ""){
              alert("elementCoeficienteDeRendimento vazio");
              return false;
            }
          }
          //titulo1 participante
          var elemenTtitulo =  document.getElementById('titulo'+i);
          if (typeof(elemenTtitulo) != 'undefined' && elemenTtitulo != null){
            if(elemenTtitulo.value == ""){
              alert("elemenTtitulo vazio");
              return false;
            }
          }
          //anexoPlanoDeTrabalho1 participante
          var elemenAnexoPlanoDeTrabalho =  document.getElementById('anexoPlanoDeTrabalho'+i);
          if (typeof(elemenAnexoPlanoDeTrabalho) != 'undefined' && elemenAnexoPlanoDeTrabalho != null){
            if(elemenAnexoPlanoDeTrabalho.value == ""){
              alert("elemenAnexoPlanoDeTrabalho vazio");
              return false;
            }
          }



        }
      }
      alert("ok");
      return false;
      
      //nome participante
     /* var elementNome =  document.getElementById('nomeCompletoParticipante1');
      if (typeof(elementNome) != 'undefined' && elementNome != null){
        if(elementNome.value == ""){
          alert("nome vazio");
          return false;
        }
      }
      //email participante
      var elementEmail =  document.getElementById('email1');
      if (typeof(elementEmail) != 'undefined' && elementEmail != null){
        if(elementEmail.value == ""){
          alert("email vazio");
          return false;
        }
      }
      //data participante
      var elementData =  document.getElementById('data1');
      if (typeof(elementData) != 'undefined' && elementData != null){
        if(elementData.value == ""){
          alert("Data vazio");
          return false;
        }
      }
      //cpf participante
      var elementCpf =  document.getElementById('cpf1');
      if (typeof(elementCpf) != 'undefined' && elementCpf != null){
        if(elementCpf.value == ""){
          alert("cpf vazio");
          return false;
        }
      }
      //rg participante
      var elementRg =  document.getElementById('rg1');
      if (typeof(elementRg) != 'undefined' && elementRg != null){
        if(elementRg.value == ""){
          alert("rg vazio");
          return false;
        }
      }
      //celular participante
      var elementCelular =  document.getElementById('celular1');
      if (typeof(elementCelular) != 'undefined' && elementCelular != null){
        if(elementCelular.value == ""){
          alert("celular vazio");
          return false;
        }
      }
      //cep participante
      var elementCep =  document.getElementById('cep1');
      if (typeof(elementCep) != 'undefined' && elementCep != null){
        if(elementCep.value == ""){
          alert("cep vazio");
          return false;
        }
      }
      //estado participante
      var elementEstado =  document.getElementById('estado1');
      if (typeof(elementEstado) != 'undefined' && elementEstado != null){
        if(elementEstado.value == ""){
          alert("estado vazio");
          return false;
        }
      }
      //cidade participante
      var elementCidade =  document.getElementById('cidade1');
      if (typeof(elementCidade) != 'undefined' && elementCidade != null){
        if(elementCidade.value == ""){
          alert("cidade vazio");
          return false;
        }
      }
      //bairro participante
      var elementBairro =  document.getElementById('bairro1');
      if (typeof(elementBairro) != 'undefined' && elementBairro != null){
        if(elementBairro.value == ""){
          alert("bairro vazio");
          return false;
        }
      }
      //rua participante
      var elementRua =  document.getElementById('rua1');
      if (typeof(elementRua) != 'undefined' && elementRua != null){
        if(elementRua.value == ""){
          alert("rua vazio");
          return false;
        }
      }
      //numero participante
      var elementNumero =  document.getElementById('numero1');
      if (typeof(elementNumero) != 'undefined' && elementNumero != null){
        if(elementNumero.value == ""){
          alert("numero vazio");
          return false;
        }
      }
      //complemento participante
      var elementComplemento =  document.getElementById('complemento1');
      if (typeof(elementComplemento) != 'undefined' && elementComplemento != null){
        if(elementComplemento.value == ""){
          alert("complemento vazio");
          return false;
        }
      }
      //universidade participante
      var elementUniversidade =  document.getElementById('universidade1');
      if (typeof(elementUniversidade) != 'undefined' && elementUniversidade != null){
        if(elementUniversidade.value == ""){
          alert("Universidade vazio");
          return false;
        }
      }
      //curso participante
      var elementCurso =  document.getElementById('curso1');
      if (typeof(elementCurso) != 'undefined' && elementCurso != null){
        if(elementCurso.value == ""){
          alert("Curso vazio");
          return false;
        }
      }
      //turno participante
      var elementTurno =  document.getElementById('turno1');
      if (typeof(elementTurno) != 'undefined' && elementTurno != null){
        if(elementTurno.value == ""){
          alert("Turno vazio");
          return false;
        }
      }
      
      //totalDePeriodos participante
      var elementTotalDePeriodos =  document.getElementById('totalDePeriodos1');
      if (typeof(elementTotalDePeriodos) != 'undefined' && elementTotalDePeriodos != null){
        if(elementTotalDePeriodos.value == ""){
          alert("totalDePeriodos1 vazio");
          return false;
        }
      }
      //totalDePeriodos participante
      var elementPeriodoAtual =  document.getElementById('periodoAtual1');
      if (typeof(elementPeriodoAtual) != 'undefined' && elementPeriodoAtual != null){
        if(elementPeriodoAtual.value == ""){
          alert("periodoAtual1 vazio");
          return false;
        }
      }
      //ordemDePrioridade1 participante
      var elementOrdemDePrioridade =  document.getElementById('ordemDePrioridade1');
      if (typeof(elementOrdemDePrioridade) != 'undefined' && elementOrdemDePrioridade != null){
        if(elementOrdemDePrioridade.value == ""){
          alert("elementOrdemDePrioridade vazio");
          return false;
        }
      }
      //coeficienteDeRendimento1 participante
      var elementCoeficienteDeRendimento =  document.getElementById('coeficienteDeRendimento1');
      if (typeof(elementCoeficienteDeRendimento) != 'undefined' && elementCoeficienteDeRendimento != null){
        if(elementCoeficienteDeRendimento.value == ""){
          alert("elementCoeficienteDeRendimento vazio");
          return false;
        }
      }
      //titulo1 participante
      var elemenTtitulo =  document.getElementById('titulo1');
      if (typeof(elemenTtitulo) != 'undefined' && elemenTtitulo != null){
        if(elemenTtitulo.value == ""){
          alert("elemenTtitulo vazio");
          return false;
        }
      }
      //anexoPlanoDeTrabalho1 participante
      var elemenAnexoPlanoDeTrabalho =  document.getElementById('anexoPlanoDeTrabalho1');
      if (typeof(elemenAnexoPlanoDeTrabalho) != 'undefined' && elemenAnexoPlanoDeTrabalho != null){
        if(elemenAnexoPlanoDeTrabalho.value == ""){
          alert("elemenAnexoPlanoDeTrabalho vazio");
          return false;
        }
      }

      */



    }
    
    
    alert("CHEGOUUU!");
    return false;

  
}
function validarCPF(valor){
    var soma = 0;
    var resto;
    var inputCPF = valor.match(/\d/g).join('');

    if(inputCPF == '00000000000') return false;

    if(inputCPF.length >11) return false;

    for(i=1; i<=9; i++) soma = soma + parseInt(inputCPF.substring(i-1, i)) * (11 - i);
    resto = (soma * 10) % 11;

    if((resto == 10) || (resto == 11)) resto = 0;
    if(resto != parseInt(inputCPF.substring(9, 10))) return false;

    soma = 0;
    for(i = 1; i <= 10; i++) soma = soma + parseInt(inputCPF.substring(i-1, i))*(12-i);
    resto = (soma * 10) % 11;

    if((resto == 10) || (resto == 11)) resto = 0;
    if(resto != parseInt(inputCPF.substring(10, 11))) return false;
    return true;
}

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
function verificarArquivoAnexado_pdf(item, legenda){
    
    if(item.files[0].type.split('/')[1] != "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo PDF! ";
        document.getElementById(legenda).innerHTML = "O arquivo deve ser no formato PDF de até 2MB.";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
    }else if(item.files[0].size > 2000000 && item.files[0].type.split('/')[1] == "pdf"){
        document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
        document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
        document.getElementById(legenda).innerHTML = "O arquivo deve ser no formato PDF de até 2MB.";
        document.getElementById(item.id).value = "";
        $("#exampleModalAnexarDocumento").modal({show: true});
    }else{
      document.getElementById(legenda).innerHTML = item.value.split('\\')[2];
    }
  }
/* FUNCAO: funcao responsavel pela verificacao dos arquivos anexados (XLS, XLSX, ODS)
*
*/
function verificarArquivoAnexado_xls_xlsx_ods(item, legenda){
    if(item.files[0].name.split('.')[1] == "xls" || item.files[0].name.split('.')[1] == "ods" || item.files[0].name.split('.')[1] == "xlsx"){
        if(item.files[0].size > 2000000){
          document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
          document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado é maior que 2MB!";
          document.getElementById(legenda).innerHTML = "Formato do arquivo: XLS, XLSX ou ODS de até 2MB.";
          document.getElementById(item.id).value = "";
          $("#exampleModalAnexarDocumento").modal({show: true});
        }else{
          document.getElementById(legenda).innerHTML = item.value.split('\\')[2];
        }
    }else{
      document.getElementById("idCorCabecalhoModalDocumento").style.backgroundColor = "red";
      document.getElementById("idTituloDaMensagemModalDocumento").innerHTML = "O arquivo selecionado não é do tipo XLS, XLSX ou ODS! ";
      document.getElementById(legenda).innerHTML = "Formato do arquivo: XLS, XLSX ou ODS de até 2MB.";
      document.getElementById(item.id).value = "";
      $("#exampleModalAnexarDocumento").modal({show: true});
    }
    
}
/*
* FUNCAO: Gerar periodos 1
*
*/
function gerarPeriodos1(select) {
    var div = select.parentElement.parentElement;
    var selectPeriodos = div.children[22].children[1];
    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(select.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }
    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);
  }
/*
* FUNCAO: Gerar periodos 2
*
*/
function gerarPeriodos2(select) {
    var div = select.parentElement.parentElement;
    var selectPeriodos = div.children[22].children[1];
    var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
    for(var i = 0; i < parseInt(select.value); i++) {
      html += `<option value="${i+1}">${i+1}º</option>`;
    }
    $(selectPeriodos).html('');
    $(selectPeriodos).append(html);
  }
/*
* FUNCAO: Gerar periodos 3
*
*/
function gerarPeriodos3(select) {
    var div = select.parentElement.parentElement;
    var selectPeriodos = div.children[22].children[1];
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
</script>
@endsection
