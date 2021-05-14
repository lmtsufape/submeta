@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
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
      <div class="col-sm-1">
      </div>
      <div class="col-sm-5" style="float: center;">
        <h4 class="titulo-table">Editais</h4>
      </div>
      <div class="col-sm-2">
          <a href="{{route('evento.criar')}}" class="btn btn-info" style="float: right;">Criar Edital</a>
      </div>
  </div>
  <hr>
  @if(session('mensagem'))
    <div class="row">
      <div class="col-md-12" style="margin-top: 30px;">
        <div class="alert alert-success">
            <p>{{session('mensagem')}}</p>
        </div>
      </div>
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Nome do Edital</th>
            <th scope="col">Data de Criação</th>
            <th scope="col">Opção</th>
          </tr>
        </thead>
        <tbody id="eventos">
          @foreach ($eventos as $evento)
            <tr>
              <td>
                <a href="{{  route('evento.visualizar',['id'=>$evento->id])  }}" class="visualizarEvento">
                    {{ $evento->nome }}
                </a>
              </td>
              <td>{{ date('d/m/Y', strtotime($evento->created_at)) }}</td>
              <td>
                @if(auth()->user()->id == $evento->criador_id)
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('evento.editar', ['id' => $evento->id]) }}" class="dropdown-item text-center">
                          Editar Edital
                        </a>
                        <hr class="dropdown-hr">
                        <a href="{{route('admin.atribuir', ['evento_id' => $evento->id])}}" class="dropdown-item text-center">
                            Atribuir Avaliadores
                        </a>
                        <hr class="dropdown-hr">
                        <a href="{{route('admin.pareceres', ['evento_id' => $evento->id])}}" class="dropdown-item text-center">
                            Visualizar Pareceres
                        </a>
                        <hr class="dropdown-hr">
                        <a href="{{route('admin.analisar', ['evento_id' => $evento->id])}}" class="dropdown-item text-center">
                          Analisar projetos
                        </a>
                        <hr class="dropdown-hr">
                          <!-- Button trigger modal -->
                          <button type="button" class="dropdown-item dropdown-item-delete text-center" data-toggle="modal" data-target="#exampleModal{{ $evento->id }}">
                            <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
                          </button>
  
  
                    </div>
                </div>
                @endif
              </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $evento->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar edital</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Você tem certeza que deseja deletar o edital:{{ $evento->nome }}?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{route('evento.deletar',$evento->id)}}" class="text-center">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-primary">
  
                          Deletar
                      </button>
  
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

@section('javascript')
<script>
  function buscarEdital(input) {
    var editais = document.getElementById('eventos').children;
    if(input.value.length > 2) {      
      for(var i = 0; i < editais.length; i++) {
        var nomeEvento = editais[i].children[0].children[0].textContent;
        if(nomeEvento.substr(0).indexOf(input.value) >= 0) {
          editais[i].style.display = "";
        } else {
          editais[i].style.display = "none";
        }
      }
    } else {
      for(var i = 0; i < editais.length; i++) {
        editais[i].style.display = "";
      }
    }
  }
</script>
@endsection
