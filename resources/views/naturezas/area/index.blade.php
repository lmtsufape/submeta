@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
      <h3> {{ __('Áreas') }} </h3> 
      </div>
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
                        <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                        Detalhes
                    </a>
                    <hr class="dropdown-hr">
                    <a href="{{ route('area.editar', ['id' => $area->id]) }}" class="dropdown-item text-center">
                        <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
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