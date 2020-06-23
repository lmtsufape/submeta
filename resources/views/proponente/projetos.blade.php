@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">

    <div class="container" >
      <div class="row" >
        <div class="col-sm-12">
            <h3>Projetos submetidos</h3> 
        </div>
      </div>
    </div>
    <hr>
    <table class="table table-bordered">
        <thead>
          <tr>   
            <th scope="col">Nome do projeto</th>
            <th scope="col">Status</th>
            <th scope="col">Data de Criação</th>
            <th scope="col">Opção</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projetos as $projeto)
            <tr>
              <td>
                {{ $projeto->titulo }}
              </td>
              @if($projeto->status == 'Avaliado')
                <td style="color: rgb(6, 85, 6)">Avaliado</td>
              @elseif($projeto->status == 'Submetido')
                <td style="color: rgb(0, 0, 0)">Submetido</td>
              @elseif($projeto->status == 'Rascunho')
                <td style="color: rgb(0, 0, 0)">Rascunho</td>
              @endif
              <td>{{ date('d-m-Y', strtotime($projeto->updated_at)) }}</td>   
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> 
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('trabalho.editar', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center;">
                          Editar projeto
                        </a>
                        <a href="{{ route('trabalho.show', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center">
                          Visualizar projeto
                        </a>
                       {{--  <a href="" class="dropdown-item" style="text-align: center">
                          Recorrer
                        </a>
                        <a href="" class="dropdown-item" style="text-align: center">
                          Resultado
                        </a> --}}
                        @if($projeto->status == 'Submetido')                          
                          <!-- Button trigger modal -->
                          <button type="button"  class="dropdown-item" style="text-align: center" data-toggle="modal" data-target="#modal{{$projeto->id}}">
                            Excluir projeto
                          </button>
                        @endif
                        
                    </div>
                </div>
              </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="modal{{$projeto->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar o projeto: {{ $projeto->titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Você tem certeza que deseja deletar o projeto: {{ $projeto->titulo }}?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('trabalho.destroy', ['id' => $projeto->id]) }}" class="btn btn-primary">
                      Deletar
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('javascript')
<script>

</script>
@endsection