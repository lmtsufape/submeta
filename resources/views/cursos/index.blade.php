@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">
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

  <div class="container" >
    <div class="row" >
      <div class="col-sm-5">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
      <div class="col-sm-3" style="float: center;">
        <h4 class="titulo-table">Cursos</h4>
      </div>
      <div class="col-sm-4">
          <a href="{{route('cursos.criar')}}" class="btn btn-info" style="float: right;">Criar Curso</a>
      </div>

    </div>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Cursos</th>
            <th scope="col">Opção</th>
          </tr>
        </thead>
        <tbody id="cursos">
          @foreach ($cursos as $curso)
            <tr>
              <td>{{ $curso->nome }}</td>
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('cursos.editar', ['id' => $curso->id]) }}" class="dropdown-item text-center">
                          Editar curso
                        </a>
                        <hr class="dropdown-hr">
                          <!-- Button trigger modal -->
                          <button type="button" class="dropdown-item dropdown-item-delete text-center" data-toggle="modal" data-target="#exampleModal{{ $curso->id }}">
                            <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
                          </button>  
                    </div>
                </div>
              </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $curso->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Você tem certeza que deseja deletar o curso: {{ $curso->nome }}?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{route('cursos.excluir',$curso->id)}}" class="text-center">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-primary">Deletar</button>  
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection