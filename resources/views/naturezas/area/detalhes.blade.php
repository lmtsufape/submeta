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
      <div class="col-sm-1">
        <a href="{{ route('grandearea.show', ['id' => $area->grandeArea->id]) }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-sm-9" style="text-align: center;">
        <h2 class="titulo-table">{{ __('Subáreas de ') . $area->nome }}</h2>
      </div>
      <div class="col-sm-2">
        <a href="{{ route('subarea.criar', ['id' => $area->id]) }}" class="btn btn-info" style="float: right;">{{ __('Criar subárea') }}</a>
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
      @foreach ($subAreas as $subArea)
        <tr>
          <td>
            {{ $subArea->nome }}
          </td>
          <td>
            <div class="btn-group dropright dropdown-options">
                <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('subarea.editar', ['id' => $subArea->id]) }}" class="dropdown-item text-center">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('subarea.deletar', ['id' => $subArea->id]) }}">
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