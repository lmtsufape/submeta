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
              <input type="hidden" value="{{sizeof($participantes)}}" id="qtdParticipantes">

              {{-- Participantes  --}}
              <div class="row" style="margin-top:20px">
                <div class="col-sm-12">
                  <div id="participantes">
                    @foreach($participantes as $participante)
                      @foreach($users as $user)
                        @if($participante->user_id === $user->id)
                          <div id="novoParticipante">
                            <br>
                            <h4>Dados do participante</h4>
                            <div class="row">
                              <div class="col-sm-5">
                                <label>Nome Completo</label>
                                <input value="{{ $user->name }}" type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" required>
                                @error('nomeParticipante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                              <div class="col-sm-4">
                                <label>E-mail</label>
                                <input value="{{ $user->email }}" type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" required>
                                @error('emailParticipante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                              <div class="col-sm-3">
                                <label>Função:</label>
                                <select class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante">
                                  <option value="" disabled selected hidden>-- Função --</option>
                                  @foreach($funcaoParticipantes as $funcaoParticipante)
                                    @if($funcaoParticipante->id === $participante->funcao_participante_id)
                                      <option value="{{$funcaoParticipante->id}}" selected>{{$funcaoParticipante->nome}}</option>
                                    @else
                                      <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                    @endif
                                  @endforeach

                                  @error('funcaoParticipante')
                                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                                </select>
                              </div>
                            </div>    
                            <div class="row">   
                              <div class='col-sm-11'>                    
                                <h6 class="mb-1">Possui plano de trabalho?</h6>
                                <button  class="btn btn-primary mt-2 mb-2 simPlano" id="simPlano">Sim</button>
                                <button  class="btn btn-primary mt-2 mb-2 naoPlano">Não</button>   
                                <input type="hidden" name="semPlano[]" value="">                            
                              </div>
                              <div class="col-sm-1 deletarSemPlano" >
                                <a  class="delete">
                                  <img src="/img/icons/user-times-solid.svg" style="width:25px;margin-top:35px">
                                </a>
                              </div>
                            </div>
                            <div id="planoHabilitado" >                            
                            @foreach ($arquivos as $arquivo)
                            @if($arquivo->participanteId === $participante->id)
                              <input type="hidden" class="exibirPlano">
                              <h5>Dados do plano de trabalho</h5>
                              <a href="{{ route('baixar.plano', ['id' => $arquivo->id]) }}">Plano de trabalho atual</a>                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div id="planoTrabalho">
                                    <div class="row">
                                      <div class="col-sm-4">
                                        <label>Titulo </label>
                                        <input type="text" value="{{$arquivo->titulo}}" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Nome">
                                        
                                        @error('nomePlanoTrabalho')
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                      </div>
                                      {{-- Arquivo  --}}
                                      <div class="col-sm-7">
                                        <label for="nomeTrabalho">Anexo</label>
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
                                          <img src="/img/icons/user-times-solid.svg" style="width:25px;margin-top:35px">
                                        </a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              @endif
                              @endforeach
                          </div>
                        </div>
                        @endif
                      @endforeach
                    @endforeach
                  </div>                  
                  <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Participantes +</a>
                </div>
              </div>

          </p>
          <div class="row justify-content-center">
            <div class="col-md-6">
              <a href="{{route('evento.visualizar',['id'=>$edital->id])}}" class="btn btn-secondary" style="width:100%">Cancelar</a>
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
    var qtdParticipantes = $('#qtdParticipantes').val();
    // Coautores
    $('#addCoautor').click(function(e) {
      if (qtdParticipantes < 100) {
        e.preventDefault();
        linha = montarLinhaInput();
        $('#participantes').append(linha);
        qtdParticipantes++
      }

    });
    
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
      if (qtdParticipantes > 1) {
        qtdParticipantes--;
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
    $('.simPlano').click(function(e) { 
      e.preventDefault();     
      var possuiPlano = $(this).parent().parent().next();
          
      //se o participante não tem plano, adicionar; se ele já tem, apenas exibir
      if(possuiPlano[0].firstElementChild == null){      
        linha = linhaPlanoTrabalho();                
        possuiPlano.append(linha);   
        possuiPlano[0].style.display = 'block';         
      }else if(possuiPlano[0].firstElementChild.className == 'exibirPlano'){
        possuiPlano[0].style.display = 'block';
      }

      //esconder a imagem de deletar
      deletar = $(this).parent().next()[0];
      deletar.style.display = "none";

    });

    // se não há plano de trabalho, esconder a div planoHabilitado e exibir imagem de deletar
    $(document).on('click', '.naoPlano', function(e) {
      e.preventDefault();
      var plano = $(this).parent().parent().next()[0];
      plano.style.display = 'none';  
     
      deletar = $(this).parent().next()[0]
      deletar.style.display = "block";

      //comunicar ao controller para deletar somente o plano
      $(this).next().val('sim'); 
           
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

    return    "<div id="+"novoParticipante"+">" +
              "<br><h4>Dados do participante</h4>" +
              "<div class="+"row"+">"+
                "<div class="+"col-sm-5"+">"+
                    "<label>Nome Completo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control' + " @error('nomeParticipante') is-invalid @enderror" + "name=" +'nomeParticipante[]'+" placeholder="+"Nome"+" required>"+
                    "@error('nomeParticipante')" +
                    "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                      "<strong>{{ $message }}</strong>" +
                    "</span>" +
                    "@enderror" +
                "</div>"+
                "<div class="+"col-sm-4"+">"+
                    "<label>E-mail</label>"+
                    "<input type='email'" + "style='margin-bottom:10px'" + "class=" + "form-control @error('emailParticipante') is-invalid @enderror" + "name='emailParticipante[]'" + "placeholder='email' required>" +
                    "@error('emailParticipante')" +
                    "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                      "<strong>{{ $message }}</strong>" +
                    "</span>" +
                    "@enderror" +
                "</div>"+
                "<div class='col-sm-3'>"+
                  "<label>Função:</label>"+
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
            "<h5>Dados do plano de trabalho</h5>" +
            "<div class="+"row"+">"+
                "<div class="+"col-sm-4"+">"+
                    "<label>Titulo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+"form-control @error('nomePlanoTrabalho') is-invalid @enderror"+" name="+'nomePlanoTrabalho[]'+" placeholder="+"Nome"+" required>"+
                    "@error('nomePlanoTrabalho')" +
                      "<span class='invalid-feedback'" + "role='alert'" + "style='overflow: visible; display:block'>" +
                        "<strong>{{ $message }}</strong>" +
                      "</span>" +
                    "@enderror" +
                "</div>"+
                "<div class="+"col-sm-7" +">"+
                  "<label for="+"nomeTrabalho"+">Anexo </label>"+

                  "<div class="+"input-group"+">"+
                    "<div class='input-group-prepend'>"+
                      "<span class='input-group-text' id='inputGroupFileAddon01'>Selecione um arquivo:</span>"+
                    "</div>"+
                    "<div class='custom-file'>"+
                      "<input type='file' class='custom-file-input @error('anexoPlanoTrabalho') is-invalid @enderror" + "id='anexoPlanoTrabalho'" + "aria-describedby='anexoPlanoTrabalho'" + "name='anexoPlanoTrabalho[]' required"+
                        "aria-describedby='inputGroupFileAddon01'>"+
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
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
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
</script>
@endsection