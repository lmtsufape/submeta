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
                {{-- @if($hasFile) --}}
                  <input type="hidden" name="trabalhoId" value="" id="trabalhoNovaVersaoId">
                {{-- @endif --}}
                {{-- <input type="hidden" name="eventoId" value="{{$evento->id}}"> --}}
  
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
  
<div class="container content">
    {{-- titulo da página --}}
    <div class="row justify-content-center titulo">
        <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-10">
                <h1>Meus Trabalhos</h1>
              </div>
              <div class="col-sm-2">
                <a href="{{route('home')}}" class="btn btn-primary">Eventos</a>
              </div>
            </div>
        </div>
    </div>
    
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
                <th style="text-align:center">Status</th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach($trabalhos as $trabalho)
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
                    <a href="#" onclick="changeTrabalho({{$trabalho->id}})" data-toggle="modal" data-target="#modalTrabalho" style="color:#114048ff">
                    <img class="" src="{{asset('img/icons/file-upload-solid.svg')}}" style="width:20px">
                    </a>
                </td>
                </tr>
            @endforeach --}}
            </tbody>
        </table>
        </div>
    </div>
      

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
                <th style="text-align:center">Baixar</th>
                <th style="text-align:center">Status</th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach($trabalhosCoautor as $trabalho)
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
            @endforeach --}}
            </tbody>
        </table>
        </div>
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
