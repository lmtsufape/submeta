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
                    <form method="POST" action="{{ route('area.deletar', ['id' => $area->id]) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="dropdown-item dropdown-item-delete text-center">
                          <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                            Deletar
                        </button>

                    </form>
                </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection