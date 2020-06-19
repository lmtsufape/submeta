@extends('layouts.app')

@section('content')
<div class="container content">
  <div class="row justify-content-center">
    <div class="col-sm-12">
      <div class="card" style="margin-top:50px">
        <div class="card-body">
          <h5 class="card-title">Enviar Projeto</h5>
          <p class="card-text">
            <form method="POST" action="{{route('trabalho.store')}}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="editalId" value="{{$edital->id}}">

              {{-- Nome do Projeto  --}}
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <label for="nomeProjeto" class="col-form-label">{{ __('Nome do Projeto*:') }}</label>
                  <input id="nomeProjeto" type="text" class="form-control @error('nomeProjeto') is-invalid @enderror" name="nomeProjeto" value="{{ old('nomeProjeto') !== null ? old('nomeProjeto') : (isset($rascunho) ? $rascunho->titulo : '')}}" autocomplete="nomeProjeto" autofocus>

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
                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área*:') }}</label>
                  <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" onchange="areas()">
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
                  <label for="area" class="col-form-label">{{ __('Área*:') }}</label>
                  <input type="hidden" id="oldArea" value="{{ old('area') }}"></input>
                  <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" onchange="subareas()">                    
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
                  <label for="subArea" class="col-form-label">{{ __('Sub Área*:') }}</label>
                  <input type="hidden" id="oldSubArea" value="{{ old('subArea') }}"></input>
                  <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea">                    
                    <option value="" disabled selected hidden>-- Sub Área --</option>
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

              <hr>
              <h3>Coordenador</h3>

              {{-- Coordenador  --}}
              <div class="row justify-content-center">

                <div class="col-sm-6">
                  <label for="nomeCoordenador" class="col-form-label">{{ __('Coordenador:') }}</label>
                  <input class="form-control" type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                </div>
                <div class="col-sm-6">
                  <label for="linkLattesEstudante" class="col-form-label">Link Lattes do Proponente*</label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante"
                  @if(Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null)
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
                  <label for="pontuacaoPlanilha" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação*:') }}</label>
                  <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha" 
                          value="{{old('pontuacaoPlanilha') !== null ? old('pontuacaoPlanilha') : (isset($rascunho) ? $rascunho->pontuacaoPlanilha : '')}}">

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="linkGrupo" class="col-form-label">{{ __('Link do grupo de pesquisa*:') }}</label>
                  <input class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo" 
                          value="{{old('linkGrupo') !== null ? old('linkGrupo') : (isset($rascunho) ? $rascunho->linkGrupoPesquisa : '')}}">

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
                  <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto*:') }}</label>
                  @if(old('anexoProjetoPreenchido') != null || (isset($rascunho) && $rascunho->anexoProjeto != ""))
                  <a id="anexoProjetoTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoProjeto' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoProjetoPreenchido" name="anexoProjetoPreenchido" value="{{ old('anexoProjetoPreenchido') }}" >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoProjeto') is-invalid @enderror" id="anexoProjeto" aria-describedby="inputGroupFileAddon01" name="anexoProjeto" onchange="exibirAnexoTemp(this)">                      
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
                  <label for="anexoLattesCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador*:') }}</label>
                  @if(old('anexoLattesPreenchido') != null || (isset($rascunho) && $rascunho->anexoLattesCoordenador != ""))
                  <a id="anexoLattesTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoLattesCoordenador' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoLattesPreenchido" name="anexoLattesPreenchido" value="{{ old('anexoLattesPreenchido') }}" >

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoLattesCoordenador') is-invalid @enderror" id="anexoLattesCoordenador" aria-describedby="anexoLattesCoordenador" name="anexoLattesCoordenador" onchange="exibirAnexoTemp(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoLattesCoordenador">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoLattesCoordenador')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6">
                  <label for="botao" class="col-form-label @error('botao') is-invalid @enderror">{{ __('Possui autorização do Comitê de Ética*:') }}</label>
                  <button id="buttonSim" class="btn btn-primary mt-2 mb-2">Sim</button>
                  <button id="buttonNao" class="btn btn-primary mt-2 mb-2">Não</button>
                  <input type="hidden" id="botao" name="botao" value="">

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
                  <input type="hidden" id="anexoComitePreenchido" name="anexoComitePreenchido" value="{{ old('anexoComitePreenchido') }}" >
                  <div class="input-group">

                    <div class="custom-file">
                      <input disabled type="file" class="custom-file-input @error('anexoComiteEtica') is-invalid @enderror" id="inputEtica" aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica" onchange="exibirAnexoTemp(this)">
                      <label class="custom-file-label" id="custom-file-label" for="inputEtica">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoComiteEtica')
                  <span id="comiteErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6 mt-3">
                  <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação*:') }}</label>
                  @if(old('anexoPlanilhaPreenchido') != null || (isset($rascunho) && $rascunho->anexoPlanilhaPontuacao != ""))
                  <a id="anexoPlanilhaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoPlanilhaPontuacao' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoPlanilhaPreenchido" name="anexoPlanilhaPreenchido" value="{{ old('anexoPlanilhaPreenchido') }}" >
                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoPlanilha') is-invalid @enderror" id="anexoPlanilha" aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha" onchange="exibirAnexoTemp(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoPlanilha">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('anexoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa*:') }}</label>
                  @if(old('anexoJustificativaPreenchido') != null || (isset($rascunho) && $rascunho->justificativaAutorizacaoEtica != "" && $rascunho->justificativaAutorizacaoEtica != null))
                  <a id="anexoJustificativaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'justificativaAutorizacaoEtica' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoJustificativaPreenchido" name="anexoJustificativaPreenchido" value="{{ old('anexoJustificativaPreenchido') }}" >
                  <div class="input-group">


                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('justificativaAutorizacaoEtica') is-invalid @enderror" id="inputJustificativa" aria-describedby="inputGroupFileAddon01" disabled name="justificativaAutorizacaoEtica" onchange="exibirAnexoTemp(this)">
                      <label class="custom-file-label" id="custom-file-label" for="inputJustificativa">O arquivo deve ser no formato PDF de até 2mb.</label>
                    </div>
                  </div>
                  @error('justificativaAutorizacaoEtica')
                  <span id="justificativaErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                {{-- Decisão do CONSU --}}
                <div class="col-sm-6">
                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU*:') }}</label>
                  @if(old('anexoConsuPreenchido') != null || (isset($rascunho) && $rascunho->anexoDecisaoCONSU != "" && $rascunho->anexoDecisaoCONSU != null))
                  <a id="anexoConsuTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'anexoDecisaoCONSU' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoConsuPreenchido" name="anexoConsuPreenchido" value="{{ old('anexoConsuPreenchido') }}" >

                  <div class="input-group">

                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('anexoCONSU') is-invalid @enderror" id="anexoCONSU" aria-describedby="inputGroupFileAddon01" name="anexoCONSU" onchange="exibirAnexoTemp(this)">
                      <label class="custom-file-label" id="custom-file-label" for="anexoCONSU">O arquivo deve ser no formato PDF de até 2mb.</label>
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
                      <div id="novoParticipante" style="display: block;">
                        <br>
                        <h4>Dados do participante</h4>
                        <div class="row">
                          <div class="col-sm-5">
                            <label>Nome Completo*</label>
                            <input type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" value="{{old('nomeParticipante.'.$i)}}">
                            @error('nomeParticipante')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-sm-4">
                            <label>E-mail*</label>
                            <input type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" value="{{old('emailParticipante.'.$i)}}">
                            @error('emailParticipante')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <div class="col-sm-3">
                            <label>Função*:</label>
                            <select class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante">
                              <option value="" disabled selected hidden>-- Função --</option>
                              @foreach($funcaoParticipantes as $funcaoParticipante)
                              <option @if(old('funcaoParticipante.'.$i)==$funcaoParticipante->id ) selected @endif value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                              @endforeach

                              @error('funcaoParticipante')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </select>
                          </div>
                        </div>                      
                      <h6 class="mb-1">Possui plano de trabalho?</h6>
                      <button  class="btn btn-primary mt-2 mb-2 simPlano">Sim</button>
                      <button  class="btn btn-primary mt-2 mb-2 naoPlano">Não</button>                      
                      <div id="planoHabilitado" >
                      <h5>Dados do plano de trabalho</h5>
                      <div class="row">
                        <div class="col-sm-12">
                          <div id="planoTrabalho">
                            <div class="row">
                              <div class="col-sm-4">
                                <label>Titulo* </label>
                                <input type="text" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Nome" value="{{old('nomePlanoTrabalho.'.$i)}}">
                                
                                @error('nomePlanoTrabalho')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                              {{-- Arquivo  --}}
                              <div class="col-sm-7">
                                <label for="nomeTrabalho">Anexo*</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="anexoPlanoTrabalho">Selecione um arquivo:</span>
                                  </div>
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" id="anexoPlanoTrabalho" aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]">
                                    <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                                  </div>
                                </div>
                                @error('anexoPlanoTrabalho')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror                               
                              </div>
                              <div class="col-sm-1">
                                <a class="delete">
                                  <img src="{{ asset('/img/icons/user-times-solid.svg') }}" style="width:25px;margin-top:35px">
                                </a>
                              </div>                              
                            </div>
                          </div>
                        </div>                  
                      </div> 
                      
                  </div>         
                </div>         
                @endfor
                    @endif
                  </div>
                  <input type="hidden" name="countParticipante" id="countParticipante" value="{{ old('countParticipante') != null ? old('countParticipante') : 1}}"></input>
                  <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Participantes +</a>
                </div>
              </div>
    
              </p>
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <button type="submit" formaction="{{route('trabalho.storeParcial')}}" class="btn btn-primary" style="width:100%;margin-bottom:10px">
                    {{ __('Salvar como Rascunho') }}
                  </button>                  
                </div>                
                <div class="col-md-6">                  
                  <button type="submit" class="btn btn-primary" style="width:100%">
                    {{ __('Enviar Projeto') }}
                  </button>
                </div>                
              </div>
              <a href="{{route('evento.visualizar',['id'=>$edital->id])}}" class="btn btn-secondary" style="width:100%">Cancelar</a>
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
    // Coautores
    $('#addCoautor').click(function(e) {
      var countParticipante = document.getElementById('countParticipante');
      if (countParticipante.value < 100) {
        e.preventDefault();
        linha = montarLinhaInput();
        $('#participantes').append(linha);
        setParticipanteDiv(parseInt(countParticipante.value) + 1);        
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
      if (countParticipante.value >= 2) {        
        setParticipanteDiv(parseInt(countParticipante.value) - 1);
        $(this).closest('#novoParticipante').remove();
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

  function montarLinhaInput() {

    return    "<div id="+"novoParticipante"+">" +
          "<br><h4>Dados do participante</h4>" +
          "<div class="+"row"+">"+
            "<div class="+"col-sm-5"+">"+
                "<label>Nome Completo*</label>"+
                "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control' + " @error('nomeParticipante') is-invalid @enderror" + "name=" +'nomeParticipante[]'+" placeholder="+"Nome"+">"+
                "@error('nomeParticipante')" +
                "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                  "<strong>{{ $message }}</strong>" +
                "</span>" +
                "@enderror" +
            "</div>"+
            "<div class="+"col-sm-4"+">"+
                "<label>E-mail*</label>"+
                "<input type='email'" + "style='margin-bottom:10px'" + "class=" + "form-control @error('emailParticipante') is-invalid @enderror" + "name='emailParticipante[]'" + "placeholder='email' >" +
                "@error('emailParticipante')" +
                "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                  "<strong>{{ $message }}</strong>" +
                "</span>" +
                "@enderror" +
            "</div>"+
            "<div class='col-sm-3'>"+
              "<label>Função*:</label>"+
              "<select class=" + "form-control @error('funcaoParticipante') is-invalid @enderror" + "name='funcaoParticipante[]'" + "id='funcaoParticipante'> " +
                  "<option value='' disabled selected hidden> Função </option>"+
                  "@foreach($funcaoParticipantes as $funcaoParticipante)"+
                    "<option value='{{$funcaoParticipante->id}}'>{{$funcaoParticipante->nome}}</option>"+
                  "@endforeach"+
                  "@error('funcaoParticipante')" +
                  "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                    "<strong>{{ $message }}</strong>" +
                  "</span>" +
                  "@enderror" +
              "</select>"+
            "</div>"+
        "</div>" +        
            "<h6 class='mb-1'>Possui plano de trabalho?</h6>"+
            "<button  class="+"'btn btn-primary mt-2 mb-2 mr-1 simPlano'"+">Sim</button>"+
            "<button  class="+"'btn btn-primary mt-2 mb-2 naoPlano'"+">Não</button>"+
            "<div id="+"planoHabilitado"+">" +
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
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
              "</div>"+
              "</div>"+
            "</div>";
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

  function areas() {    
    var grandeArea = $('#grandeArea').val();
    $.getJSON("{{ config('app.url') }}/naturezas/areas/" + grandeArea,
      function(dados) {
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
      })
  }

  function subareas() {
    var area = $('#area').val();
    $.getJSON("{{ config('app.url') }}/naturezas/subarea/" + area,
      function(dados) {
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
  window.onload = areas();
  window.onload = habilitarBotao();
</script>
@endsection