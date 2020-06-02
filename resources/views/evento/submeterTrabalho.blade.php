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
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Nome do Projeto:') }}</label>
                                <input id="nomeTrabalho" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeProjeto" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus>

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
                                <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeAreaId">
                                    <option value="" disabled selected hidden>-- Grande Área --</option>
                                    @foreach($grandeAreas as $grandeArea)
                                      <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                                    @endforeach
                                </select>

                                @error('grandeAreaId')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                                <select class="form-control @error('area') is-invalid @enderror" id="area" name="areaId">
                                    <option value="" disabled selected hidden>-- Área --</option>
                                    @foreach($areas as $area)
                                      <option value="{{$area->id}}">{{$area->nome}}</option>
                                    @endforeach
                                </select>

                                @error('areaId')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                                <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subAreaId">
                                    <option value="" disabled selected hidden>-- Sub Área --</option>
                                    @foreach($subAreas as $subArea)
                                      <option value="{{$subArea->id}}">{{$subArea->nome}}</option>
                                    @endforeach
                                </select>

                                @error('subAreaId')
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
                              <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                              <input class="form-control" type="text" name="linkLattesEstudante"
                                     @if(Auth()->user()->proponentes->linkLattes != null) 
                                        value="{{ Auth()->user()->proponentes->linkLattes }}"
                                        disabled="disabled"
                                      @else
                                      value=""
                                      @endif >
                          </div>
                          <div class="col-sm-6">
                              <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                              <input class="form-control" type="text" name="pontuacaoPlanilha">
                          </div>
                          <div class="col-sm-6">
                              <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                              <input class="form-control" type="text" name="linkGrupo">
                          </div>
                          
                        </div>

                        

                        {{-- Pontuação da Planilha de Pontuação  --}}
                        <div class="row justify-content-center mt-2">
                            {{-- Nome Trabalho  --}}
                          
                        </div>

                        

                        {{-- Link do grupo de pesquisa  --}}
                        <div class="row justify-content-center mb-3">                            
                          
                        </div>

                        {{-- Link do grupo de pesquisa  --}}
                        <div class="row justify-content-center mb-3">                            
                          
                        </div>

                        <hr>
                        <h3>Anexos</h3>

                        {{-- Anexo do Projeto --}}
                        <div class="row justify-content-center">
                          {{-- Arquivo  --}}
                          <div class="col-sm-6" >
                            <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto:') }}</label>

                            <div class="input-group">
                              
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="anexoProjeto"
                                  aria-describedby="inputGroupFileAddon01" name="anexoProjeto">
                                <label class="custom-file-label" id="custom-file-label" for="anexoProjeto">O arquivo deve ser no formato PDF de até 2mb.</label>
                              </div>
                            </div>
                            @error('anexoProjeto')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>

                          <div class="col-sm-6" >
                            <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador:') }}</label>

                            <div class="input-group">
                              
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01"
                                  aria-describedby="anexoLatterCoordenador" name="anexoLatterCoordenador">
                                <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                              </div>
                            </div>
                            @error('arquivo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                          <form>
                            
                            <input type="radio" name="colors" id="red">Red<br>
                            <input type="radio" name="colors" id="blue">Blue
                          </form>

                          <div class="col-sm-6" >
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética:') }}</label>

                            <div class="input-group">
                              
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01"
                                  aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica">
                                <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                              </div>
                            </div>
                            @error('arquivo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>

                          <div class="col-sm-6" >
                            <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação :') }}</label>

                            <div class="input-group">
                              
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="anexoPlanilha"
                                  aria-describedby="anexoPlanilhaDescribe" name="anexoPlanilha">
                                <label class="custom-file-label" id="custom-file-label" for="anexoPlanilha">O arquivo deve ser no formato PDF de até 2mb.</label>
                              </div>
                            </div>
                            @error('arquivo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>

                        
                        
                        @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                          {{-- Decisão do CONSU --}}
                          <div class="row justify-content-center">
                            {{-- Arquivo  --}}
                            <div class="col-sm-12" >
                              <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU:') }}</label>

                              <div class="input-group">
                                
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="anexoCONSU"
                                    aria-describedby="inputGroupFileAddon01" name="anexoCONSU">
                                  <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">O arquivo deve ser no formato PDF de até 2mb.</label>
                                </div>
                              </div>
                              @error('arquivo')
                              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                          </div>
                        @endif


                        <hr>
                        <h4>Participantes</h4>

                        {{-- Participantes  --}}
                        <div class="row" style="margin-top:20px">
                          <div class="col-sm-12">
                            <div id="participantes">

                              <div class="row">
                                <div class="col-sm-5">
                                    <label>Nome Completo</label>
                                    <input type="text" style="margin-bottom:10px" class="form-control emailCoautor" name="nomeParticipante[]" placeholder="Nome" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>E-mail</label>
                                    <input type="email" style="margin-bottom:10px" class="form-control emailCoautor" name="emailParticipante[]" placeholder="E-mail" required>
                                </div>
                                <div class="col-sm-2">
                                    <label for="funcaoParticipante" class="col-form-label">{{ __('Função:') }}</label>
                                <select class="form-control @error('funcaoParticipante') is-invalid @enderror" id="funcaoParticipante" name="funcaoParticipante[]">
                                    <option value="" disabled selected hidden>-- Função --</option>
                                    @foreach($funcaoParticipantes as $funcaoParticipante)
                                      <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-sm-1">
                                    <a  class="delete">
                                      <img src="/img/icons/user-times-solid.svg" style="width:25px;margin-top:35px">
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <label>Nome Completo</label>
                                    <input type="text" style="margin-bottom:10px" class="form-control emailCoautor" name="nomeParticipante[]" placeholder="Nome" required>
                                </div>
                                <div class="col-sm-4">
                                    <label>E-mail</label>
                                    <input type="email" style="margin-bottom:10px" class="form-control emailCoautor" name="emailParticipante[]" placeholder="E-mail" required>
                                </div>
                                <div class="col-sm-2">
                                    <label for="funcaoParticipante" class="col-form-label">{{ __('Função:') }}</label>
                                <select class="form-control @error('funcaoParticipante') is-invalid @enderror" id="funcaoParticipante" name="funcaoParticipante[]">
                                    <option value="" disabled selected hidden>-- Função --</option>
                                    @foreach($funcaoParticipantes as $funcaoParticipante)
                                      <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-sm-1">
                                    <a  class="delete">
                                      <img src="/img/icons/user-times-solid.svg" style="width:25px;margin-top:35px">
                                    </a>
                                </div>
                            </div>

                            </div>
                            <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Participantes +</a>
                          </div>
                        </div>

                        {{-- Plano de Trabalho  --}}
                        <h4 class="mt-3" >Plano de Trabalho</h4>
                        <div class="row" style="margin-top:20px">
                          <div class="col-sm-12">
                            <div id="planoTrabalho">  
                                <div class="row">
                                  <div class="col-sm-4">
                                      <label>Titulo </label>
                                      <input type="text" style="margin-bottom:10px" class="form-control emailCoautor" name="nomePlanoTrabalho[]" placeholder="Nome" required>
                                  </div> 
                                    {{-- Arquivo  --}}
                                    <div class="col-sm-7">
                                      <label for="nomeTrabalho" >Anexo</label>
                                      <div class="input-group"  >
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="anexoPlanoTrabalho">Selecione um arquivo:</span>
                                        </div>
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="anexoPlanoTrabalho"
                                            aria-describedby="anexoPlanoTrabalho" name="anexoPlanoTrabalho[]">
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
                                      <a  class="deletePlano">
                                        <img src="/img/icons/user-times-solid.svg" style="width:25px;margin-top:35px">
                                      </a>
                                  </div>
                              
                                  
                                </div>                              
                            </div>
                            <a href="#" class="btn btn-primary" id="addPlanoTrabalho" style="width:100%;margin-top:10px">Plano de Trabalho +</a>
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

  
  $(function(){
    var qtdLinhas = 1;
    var qtdParticipantes = 2;
    // Coautores
    $('#addCoautor').click(function(e){

      if(qtdParticipantes < 100){
        e.preventDefault();
        linha = montarLinhaInput();
        $('#participantes').append(linha);
        qtdParticipantes++
      }
      
    });

    $('#addPlanoTrabalho').click(function(e){
      e.preventDefault();
      if(qtdLinhas < 4){
        linha = montarLinhaInputPlanoTrabalho();
        $('#planoTrabalho').append(linha);
        qtdLinhas++;
      }
      
    });

    // Exibir modalidade de acordo com a área
    $("#area").change(function(){
      console.log($(this).val());
      addModalidade($(this).val());
    });
    $(document).on('click','.delete',function(){
        if(qtdParticipantes > 2){
          qtdParticipantes--;
          $(this).closest('.row').remove();
            return false;
        }    
    });
    $(document).on('click','.deletePlano',function(){
        if(qtdLinhas > 1){
          qtdLinhas--;
          $("#planoTrabalho div.row:last").remove();
            return false;
        }    
    });
    $('#anexoProjeto').on('change',function(){
        //get the file name
        var fileName = $(this).val();        
        //replace the "Choose a file" label
        $(this).next('#custom-file-label').html(fileName);
    })


  });
  // Remover Coautor
  

  function addModalidade(areaId){
    console.log(modalidades)
    $("#modalidade").empty();
    for(let i = 0; i < modalidades.length; i++){
      if(modalidades[i].areaId == areaId){
        console.log(modalidades[i]);
        $("#modalidade").append("<option value="+modalidades[i].modalidadeId+">"+modalidades[i].modalidadeNome+"</option>")
      }
    }
  }
  function montarLinhaInput(){

    return  "<div class="+"row"+">"+
                "<div class="+"col-sm-5"+">"+
                    "<label>Nome Completo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'nomeParticipante[]'+" placeholder="+"Nome"+" required>"+
                "</div>"+
                "<div class="+"col-sm-4"+">"+
                    "<label>E-mail</label>"+
                    "<input"+" type="+'email'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'emailParticipante[]'+" placeholder="+"E-mail"+" required>"+
                "</div>"+
                "<div class='col-sm-2'>"+
                  "<label for='funcaoParticipante' class='col-form-label'>Função:</label>"+
                "<select class="+"form-control @error('funcaoParticipante') is-invalid @enderror"+" id="+"funcaoParticipante"+"name="+"funcaoParticipante[]"+">"+
                    "<option value='' disabled selected hidden> Função </option>"+
                    "@foreach($funcaoParticipantes as $funcaoParticipante)"+
                      "<option value='{{$funcaoParticipante->id}}'>{{$funcaoParticipante->nome}}</option>"+
                    "@endforeach"+
                "</select>"+
                "</div>"+
                "<div class="+"col-sm-1"+">"+
                    "<a  class="+"delete"+">"+
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
            "</div>";
  }
  function montarLinhaInputPlanoTrabalho(){

    return  "<div class="+"row"+">"+
                "<div class="+"col-sm-4"+">"+
                    "<label>Nome Completo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'nomePlanoTrabalho[]'+" placeholder="+"Nome"+" required>"+
                "</div>"+
                "<div class="+"col-sm-7" +">"+
                  "<label for="+"nomeTrabalho"+">Anexo </label>"+

                  "<div class="+"input-group"+">"+
                    "<div class='input-group-prepend'>"+
                      "<span class='input-group-text' id='inputGroupFileAddon01'>Selecione um arquivo:</span>"+
                    "</div>"+
                    "<div class='custom-file'>"+
                      "<input type='file' class='custom-file-input' id='inputGroupFile01'"+
                        "aria-describedby='inputGroupFileAddon01' name='anexoPlanoTrabalho[]'>"+
                      "<label class='custom-file-label' id='custom-file-label' for='inputGroupFile01'>O arquivo deve ser no formato PDF de até 2mb.</label>"+
                    "</div>"+
                  "</div>"+
                  "@error('arquivo')"+
                  "<span class='invalid-feedback' role='alert' style='overflow: visible; display:block'>"+
                    "<strong>{{ $message }}</strong>"+
                  "</span>"+
                  "@enderror"+
                "</div>"+                 
                "<div class="+"col-sm-1"+">"+
                    "<a class="+"deletePlano"+">"+
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
            "</div>";
  }

</script>
@endsection
