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
          <h2 style="margin-top: 100px; ">{{ __('Subáreas') }}</h2>
        </div>
    </div>

    <hr>
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-md-12">
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
                          <a href="{{ route('subarea.editar', ['id' => $subArea->id]) }}" class="dropdown-item">
                              <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                              Editar
                          </a>
                          <hr class="dropdown-hr">
                          <form method="POST" action="{{ route('subarea.deletar', ['id' => $subArea->id]) }}">
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
    </div>
</div>

@endsection