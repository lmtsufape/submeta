@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        @if(session('mensagem'))
        <div class="col-md-12" style="margin-top: 100px;">
            <div class="alert alert-success">
                <p>{{session('mensagem')}}</p>
            </div>
        </div>
        @endif
        <div class="col-sm-9">
          <h2 style="margin-top: 100px; ">{{ __('Subáreas de ') . $area->nome }}</h2>
        </div>
        <div class="col-sm-3">
          <a href="{{ route('area.criar', ['id' => $area->id]) }}" class="btn btn-primary" style="position:relative;top:100px;">{{ __('Criar subárea') }}</a>
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
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('area.editar', ['id' => $subArea->id]) }}" class="dropdown-item">
                        <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('area.deletar', ['id' => $subArea->id]) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="dropdown-item">
                            <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
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