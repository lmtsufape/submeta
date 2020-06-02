@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        @if(auth()->user()->tipo === "administrador")
          <h3>Meus Editais</h3> 
        @else
          <h3>Editais</h3> 
        @endif
      </div>
      @if(auth()->user()->tipo === "administrador")
        <div class="col-sm-2">
          <a href="{{route('evento.criar')}}" class="btn btn-primary">Criar Edital</a>
        </div>
      @endif
    </div>
  </div>
  <hr>
  @if(auth()->user()->tipo === "administrador")
    <table class="table table-bordered">
      <thead>
        <tr>   
          <th scope="col">Nome do Edital</th>
          <th scope="col">Data de Criação</th>
          <th scope="col">Opção</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($eventos as $evento)
          <tr>
            <td>
              <a href="{{  route('evento.visualizar',['id'=>$evento->id])  }}" class="visualizarEvento">
                  {{ $evento->nome }}
              </a>
            </td>
            <td>10/05/2020</td>
            <td>
              <div class="btn-group dropright dropdown-options">
                  <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{-- <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> --}}
                  </a>
                  <div class="dropdown-menu">
                      <a href="{{ route('coord.detalhesEvento', ['eventoId' => $evento->id]) }}" class="dropdown-item">
                          <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                          Editar Edital
                      </a>
                      <a href="{{route('admin.atribuir', ['evento_id' => $evento->id])}}" class="dropdown-item">
                          <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                          Atribuir Avaliadores
                      </a>
                      <form method="POST" action="{{route('evento.deletar',$evento->id)}}">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
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
  @endif

  @if(auth()->user()->tipo === "proponente")
    <table class="table table-bordered">
      <thead>
        <tr>   
          <th scope="col">Nome do Edital</th>
          <th scope="col">Status</th>
          <th scope="col">Data de Criação</th>
          <th scope="col">Opção</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($eventos as $evento)
          <tr>
            <td>
              <a href="{{  route('evento.visualizar',['id'=>$evento->id])  }}" class="visualizarEvento">
                  {{ $evento->nome }}
              </a>
            </td>
            <td></td>
            <td>10/05/2020</td>
            <td>
              <div class="btn-group dropright dropdown-options">
                  <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{-- <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> --}}
                  </a>
                  <div class="dropdown-menu">
                      <a href="{{ route('baixar.edital', ['id' => $evento->id]) }}" class="dropdown-item" style="text-align: center;">
                          Baixar edital
                      </a>
                      <a href="{{ route('projetos.edital', ['id' => $evento->id]) }}" class="dropdown-item" style="text-align: center">
                          Submeter projeto
                      </a>
                      <a href="" class="dropdown-item" style="text-align: center">
                        Visualizar resultado
                      </a>
                      <a href="" class="dropdown-item" style="text-align: center">
                        Recurso ao resultado
                      </a>
                      <a href="" class="dropdown-item" style="text-align: center">
                        Resultado preeliminar
                      </a>
                      <a href="" class="dropdown-item" style="text-align: center">
                        Resultado final
                      </a>
                  </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
