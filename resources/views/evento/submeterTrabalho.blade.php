@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-8">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                  <h5 class="card-title">Enviar Trabalho</h5>
                  <p class="card-text">
                    <form method="POST" action="{{route('trabalho.store')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">
                        <div>
                          @error('numeroMax')
                            @include('componentes.mensagens')
                          @enderror
                        </div>

                        <div class="row justify-content-center">
                            {{-- Nome Trabalho  --}}
                          <div class="col-sm-12">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Título:') }}</label>
                                <input id="nomeTrabalho" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeTrabalho" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus>

                                @error('nomeTrabalho')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            {{-- Nome Trabalho  --}}
                          <div class="col-sm-12">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Autor:') }}</label>
                                <input class="form-control" type="text" disabled value="{{Auth::user()->name}}">
                            </div>
                        </div>

                        <div class="row" style="margin-top:20px">
                          <div class="col-sm-12">
                            <div id="coautores">

                            </div>
                            <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Coautor +</a>
                          </div>
                        </div>


                        @if($evento->hasResumo)
                          <div class="row justify-content-center">
                              <div class="col-sm-12">
                                  <label for="resumo" class="col-form-label">{{ __('Resumo:') }}</label>
                                  <textarea id="resumo" class="form-control @error('resumo') is-invalid @enderror" name="resumo" value="{{ old('resumo') }}"  autocomplete="resumo" autofocusrows="5"></textarea>

                                  @error('resumo')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror


                              </div>
                          </div>
                        @endif
                        <!-- Areas -->
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                                <select class="form-control @error('area') is-invalid @enderror" id="area" name="areaId">
                                    <option value="" disabled selected hidden>-- Área --</option>
                                    @foreach($areasEnomes as $area)
                                      <option value="{{$area->id}}">{{$area->nome}}</option>
                                    @endforeach
                                </select>

                                @error('areaId')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Modalidades -->
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <label for="areaModalidadeId" class="col-form-label">{{ __('Modalidade:') }}</label>
                                <select class="form-control @error('modalidade') is-invalid @enderror" id="modalidade" name="modalidadeId">
                                  <option value="" disabled selected hidden>-- Modalidade --</option>
                                </select>

                                @error('modalidadeId')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-center">
                          {{-- Arquivo  --}}
                          <div class="col-sm-12" style="margin-top: 20px;">
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Arquivo:') }}</label>

                            <div class="custom-file">
                              <input type="file" class="filestyle" data-placeholder="Nenhum arquivo" data-text="Selecionar" data-btnClass="btn-primary-lmts" name="arquivo">
                            </div>
                            <small>O arquivo Selecionado deve ser no formato PDF de até 2mb.</small>
                            @error('arquivo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                          </div>
                        </div>



                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <a href="{{route('evento.visualizar',['id'=>$evento->id])}}" class="btn btn-secondary" style="width:100%">Cancelar</a>
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

  var modalidades = JSON.parse('<?php echo json_encode($modalidadesIDeNome) ?>');
  $(function(){
    // Coautores
    $('#addCoautor').click(function(){
      linha = montarLinhaInput();
      $('#coautores').append(linha);
    });

    // Exibir modalidade de acordo com a área
    $("#area").change(function(){
      console.log($(this).val());
      addModalidade($(this).val());
    });


  });
  // Remover Coautor
  $(document).on('click','.delete',function(){
    $(this).closest('.row').remove();
          return false;
  });

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
                "<div class="+"col-sm-6"+">"+
                    "<label>Nome Completo</label>"+
                    "<input"+" type="+'text'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'nomeCoautor[]'+" placeholder="+"Nome"+" required>"+
                "</div>"+
                "<div class="+"col-sm-5"+">"+
                    "<label>E-mail</label>"+
                    "<input"+" type="+'email'+" style="+"margin-bottom:10px"+" class="+'form-control emailCoautor'+" name="+'emailCoautor[]'+" placeholder="+"E-mail"+" required>"+
                "</div>"+
                "<div class="+"col-sm-1"+">"+
                    "<a href="+"#"+" class="+"delete"+">"+
                      "<img src="+"/img/icons/user-times-solid.svg"+" style="+"width:25px;margin-top:35px"+">"+
                    "</a>"+
                "</div>"+
            "</div>";
  }
</script>
@endsection
