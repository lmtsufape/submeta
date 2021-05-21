@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">

    {{-- @if(isset($mensagem))
    <div class="col-sm-12">
        <br>
        <div class="alert alert-success">
            <p>{{ $mensagem }}</p>
        </div>
    </div>
    @endif --}}
    
    <div class="container" >
      <div class="row" >
        <div class="col-sm-1">
          <a href="{{ route('proponente.index') }}" class="btn btn-secondary" style="position:relative; float: right;">Voltar</a>
        </div>
        <div class="col-sm-7" style="text-align: center">
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
              <h4 class="titulo-table">Meus Projetos</h4>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="row">
            <div class="col-sm-2">
              <button class="btn" onclick="buscarEdital(this.parentElement.parentElement.children[1].children[0])">
                <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
              </button>
            </div>
            <div class="col-sm-10">
              <input type="text" class="form-control form-control-edit" placeholder="Digite o nome do edital" onkeyup="buscarEdital(this)">
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(session('mensagem'))
    <div class="row">
      <div class="col-sm-12">
        <br>
        <div class="alert alert-success">
            <p>{{session('mensagem')}}</p>
        </div>
      </div>
    </div>
    @endif
    <hr>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Projeto</th>
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
                  <td>{{ date('d/m/Y', strtotime($projeto->updated_at)) }}</td>
                  <td>
                    <div class="btn-group dropright dropdown-options">
                        <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                        </a>
                        <div class="dropdown-menu">
                          @if($projeto->evento->inicioSubmissao <= $hoje && $hoje <= $projeto->evento->fimSubmissao)
                            <a href="{{ route('trabalho.editar', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center;">
                              Editar
                            </a>
                            <hr class="dropdown-hr">
                          @else
                          @endif
                            <a href="{{ route('trabalho.show', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center">
                              Visualizar
                            </a>
                          {{--  <a href="" class="dropdown-item" style="text-align: center">
                              Recorrer
                            </a>
                            <a href="" class="dropdown-item" style="text-align: center">
                              Resultado
                            </a> --}}
                            @if($projeto->status == 'Submetido')
                              <hr class="dropdown-hr">
                              <!-- Button trigger modal -->
                              <button type="button"  class="dropdown-item dropdown-item-delete" style="text-align: center" data-toggle="modal" data-target="#modal{{$projeto->id}}">
                                <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
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
    </div>
</div>
@endsection

@section('javascript')
<script>

</script>
@endsection
