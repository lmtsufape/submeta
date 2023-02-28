@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        @if(session('error'))
        <div class="col-md-12" style="margin-top: 30px;">
            <div class="alert alert-danger">
                <p>{{session('error')}}</p>
            </div>
        </div>
        @endif
    </div>
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
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
          Voltar
        </a>
     </div>
      {{-- <div class="col-sm-9" style="text-align: center;">
        <h2 class="titulo-table">{{ __('Grandes áreas') }}</h2>
      </div>
      <div class="col-sm-2">
        <a href="{{route('grandearea.criar')}}" class="btn btn-info" style="float: right;">{{ __('Criar grande área') }}</a>
      </div> --}}
    </div>
    <hr>

    <div class="row" >
        <div class="col" >
            @include('naturezas.grandeArea.collapse-grande-area')
        </div>
    </div>
    

      
  {{-- <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($grandesAreas as $grandeArea)
        <tr>
          <td>
            <a href="{{ route('grandearea.show', ['id' => $grandeArea->id ]) }}" class="visualizarEvento">
                {{ $grandeArea->nome }}
            </a>
          </td>
          <td>
            <div class="btn-group dropright dropdown-options">
                <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('grandearea.show', ['id' => $grandeArea->id ]) }}" class="dropdown-item text-center">
                      Detalhes
                    </a>
                    <hr class="dropdown-hr">
                    <a href="{{ route('grandearea.editar', ['id' => $grandeArea->id]) }}" class="dropdown-item text-center">
                        Editar
                    </a>
                    <hr class="dropdown-hr">
                    <form method="POST" action="{{ route('grandearea.deletar', ['id' => $grandeArea->id]) }}">
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
  </table> --}}
</div>

@endsection