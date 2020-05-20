@extends('layouts.app')

@section('content')


<div class="modal fade" id="modalTrabalho" tabindex="-1" role="dialog" aria-labelledby="modalTrabalho" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Submeter nova versão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('trabalho.novaVersao')}}" enctype="multipart/form-data">
        @csrf
      <div class="modal-body">

        <div class="row justify-content-center">
          <div class="col-sm-12">
              @if($hasFile)
                <input type="hidden" name="trabalhoId" value="" id="trabalhoNovaVersaoId">
              @endif
              <input type="hidden" name="eventoId" value="{{$evento->id}}">

              {{-- Arquivo  --}}
              <label for="nomeTrabalho" class="col-form-label">{{ __('Arquivo') }}</label>

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

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>









<div class="container-fluid content">
    <div class="row">
        @if(isset($evento->fotoEvento))
        <div class="banner-evento">
            <img src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" alt="">
        </div>
        <img class="front-image-evento" src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" alt="">
        @else
        <div class="banner-evento">
            <img src="{{asset('img/colorscheme.png')}}" alt="">
        </div>
        <img class="front-image-evento" src="{{asset('img/colorscheme.png')}}" alt="">
        @endif
    </div>
</div>
<div class="container" style="margin-top:20px">
    @if(!Auth::check())
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong> A submissão de um trabalho é possível apenas quando cadastrado no sistema. </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row margin">
        <div class="col-sm-12">
            <h1>
                {{$evento->nome}}
            </h1>
        </div>
    </div>

    <div class="row margin">
        <div class="col-sm-12">
            <h4>Descrição</h4>
        </div>
    </div>
    <div class="row margin">
        <div class="col-sm-12">
            <p>{{$evento->descricao}}</p>
        </div>
    </div>
    <div class="row margin">
        <div class="col-sm-12 info-evento">
            <h4>Realização do Evento</h4>
            <p>
                <img class="" src="{{asset('img/icons/calendar-evento.svg')}}" alt="">
                {{date('d/m/Y',strtotime($evento->dataInicio))}} - {{date('d/m/Y',strtotime($evento->dataFim))}}
            </p>
        </div>
    </div>
    <div class="row margin">
        <div class="col-sm-12 info-evento">
            <h4>Submissão de Trabalhos</h4>
            <p>
                <img class="" src="{{asset('img/icons/calendar-evento.svg')}}" alt="">
                {{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}
            </p>
        </div>
    </div>
    <div class="row margin">
        <div class="col-sm-12 info-evento">
            <h4>Revisão de Trabalhos</h4>
            <p>
                <img class="" src="{{asset('img/icons/calendar-evento.svg')}}" alt="">
                {{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}
            </p>
        </div>
    </div>

    <div class="row margin">
        <div class="col-sm-12 info-evento">
            <h4>Endereço</h4>
            <p>
                <img class="" src="{{asset('img/icons/map-marker-alt-solid.svg')}}" alt="">
                {{$evento->endereco->rua}}, {{$evento->endereco->numero}} - {{$evento->endereco->cidade}} / {{$evento->endereco->uf}}.
            </p>
        </div>
    </div>
    @if($hasFile == true)
      <div class="row margin">
          <div class="col-sm-12">
              <h1>
                  Meus Trabalhos
              </h1>
          </div>
      </div>
      @if($hasTrabalho)
        <div class="row margin">
            <div class="col-sm-12 info-evento">
                <h4>Como Autor</h4>
            </div>
        </div>

        <!-- Tabela de trabalhos -->

        <div class="row justify-content-center">
          <div class="col-sm-12">

            <table class="table table-responsive-lg table-hover">
              <thead>
                <tr>
                  <th>Título</th>
                  <th style="text-align:center">Baixar</th>
                  <th style="text-align:center">Nova Versão</th>
                </tr>
              </thead>
              <tbody>
                @foreach($trabalhos as $trabalho)
                  <tr>
                    <td>{{$trabalho->titulo}}</td>
                    <td style="text-align:center">
                      @php $arquivo = ""; @endphp
                      @foreach($trabalho->arquivo as $key)
                        @php
                          if($key->versaoFinal == true){
                            $arquivo = $key->nome;
                          }
                        @endphp
                      @endforeach
                      <a href="{{route('download', ['file' => $arquivo])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                          <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                      </a>
                    </td>
                    <td style="text-align:center">
                      @if($evento->inicioSubmissao <= $mytime)
                        @if($mytime < $evento->fimSubmissao)
                          <a href="#" onclick="changeTrabalho({{$trabalho->id}})" data-toggle="modal" data-target="#modalTrabalho" style="color:#114048ff">
                            <img class="" src="{{asset('img/icons/file-upload-solid.svg')}}" style="width:20px">
                          </a>
                        @endif
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif

      @if($hasTrabalhoCoautor)
        <div class="row margin">
            <div class="col-sm-12 info-evento">
                <h4>Como Coautor</h4>
            </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-sm-12">

            <table class="table table-responsive-lg table-hover">
              <thead>
                <tr>
                  <th>Título</th>
                  <th  style="text-align:center">Baixar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($trabalhosCoautor as $trabalho)
                  <tr>
                    <td>{{$trabalho->titulo}}</td>
                    <td style="text-align:center">
                      @php $arquivo = ""; @endphp
                      @foreach($trabalho->arquivo as $key)
                        @php
                          if($key->versaoFinal == true){
                            $arquivo = $key->nome;
                          }
                        @endphp
                      @endforeach
                      <a href="{{route('download', ['file' => $arquivo])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                          <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    @endif

    <div class="row justify-content-center" style="margin: 20px 0 20px 0">

        <div class="col-md-6 botao-form-left" style="">
            <a class="btn btn-secondary botao-form" href="{{route('cancelarCadastro')}}" style="width:100%">Voltar</a>
        </div>

        @if($evento->inicioSubmissao <= $mytime)
          @if($mytime < $evento->fimSubmissao)
            <div class="col-md-6 botao-form-right" style="">
              <a class="btn btn-primary botao-form" href="{{route('trabalho.index',['id'=>$evento->id])}}" style="width:100%">Submeter Trabalho</a>
            </div>
          @endif
        @endif

    </div>
</div>


@endsection

@section('javascript')
<script>
  function changeTrabalho(x){
    document.getElementById('trabalhoNovaVersaoId').value = x;
  }
</script>
@endsection
