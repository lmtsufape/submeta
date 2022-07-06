@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        @if(session('mensagem'))
        <div class="col-md-12" style="margin-top: 30px;">
            <div class="alert alert-success">
                <p>{{session('mensagem')}}</p>
            </div>
        </div>
        @endif
    </div>
    <div class="row" style="margin-top: 30px;">
      <div class="col-md-1">
        <a href="{{ route('grandearea.index') }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-sm-9" style="text-align: center;">
        <h2 class="titulo-table">{{ __('Áreas de ') . $grandeArea->nome }}</h2>
      </div>
      <div class="col-sm-2">
        <a href="{{route('area.criar', ['id' => $grandeArea->id] )}}" class="btn btn-info" style="float: right;">{{ __('Criar Área') }}</a>
      </div>
    </div>
    <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($areas as $area)
        <tr>
          <td>
            <a href="{{ route('area.show', ['id' => $area->id]) }}" class="visualizarEvento">
                {{ $area->nome }}
            </a>
          </td>
          <td>
            <div class="btn-group dropright dropdown-options">
                <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('area.show', ['id' => $area->id ]) }}" class="dropdown-item text-center">
                        Detalhes
                      </a>
                      <hr class="dropdown-hr">
                    <a href="{{ route('area.editar', ['id' => $area->id]) }}" class="dropdown-item text-center">
                        Editar
                    </a>
                    <hr class="dropdown-hr">
                    <button data-toggle="modal" data-target="#removerArea{{ $area->id }}" class="dropdown-item dropdown-item-delete text-center">
                        <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                        Deletar
                    </button>
                </div>
            </div>
          </td>
        </tr>

        <!-- Modal Remover -->
        <div class="modal fade" id="removerArea{{ $area->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remover Área</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja remover a Área: {{ $area->nome }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route('area.deletar', ['id' => $area->id]) }}" >
                            @csrf
                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    </tbody>
  </table>
</div>

@endsection