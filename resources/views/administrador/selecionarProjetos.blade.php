@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 30px;">


  <div class="container" >
    <div class="row justify-content-center" style="margin-bottom: 50px;">
      <div class="col-md-1">
        <a href="{{ route('admin.atribuir', ['evento_id' => $evento->id]) }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-md-10" style="text-align: center;">
        <h3  class="titulo-table">Lista de Projetos do Edital: <span style="color: black;">{{ $evento->nome }}</span> </h3>
      </div>
      <div class="col-md-1">
        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
          Enviar Convite
        </button> --}}
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-sm-1">
            <button class="btn" onclick="buscar(this.parentElement.parentElement.children[1].children[0])">
              <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
            </button>
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control form-control-edit" placeholder="Digite o nome do projeto" onkeyup="buscar(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Nome do Projeto</th>
        <th scope="col">Área</th>
        <th scope="col">Proponente</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody id="projetos">
      @foreach ($trabalhos as $trabalho)
        <tr>
          <td>{{ $trabalho->titulo}}</td>
          <td>{{ App\Area::find($trabalho->area_id)->nome}}</td>
          <td>{{ $trabalho->proponente->user->name }}</td>
          <td style="text-align:center">
              <button type="button" class="btn btn-primary" value="{{ $trabalho->id }}" id="atribuir1" data-toggle="modal" data-target="#exampleModalCenter{{ $trabalho->id }}">
                Atribuir
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter{{ $trabalho->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content modal-submeta">
                    <div class="modal-header modal-header-submeta">
                      <h5 class="modal-title titulo-table" id="exampleModalLongTitle">Selecione o(s) avaliador(es)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"  style="color: rgb(182, 182, 182)">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form action="{{ route('admin.atribuicao.projeto') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                        <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                        <div class="form-group">
                          <label for="exampleFormControlSelect2">Selecione o(s) avaliador(es) para esse projeto</label>
                          <select  name="avaliadores_id[]" multiple class="form-control" id="exampleFormControlSelect2">
                            @foreach ($trabalho->aval as $avaliador)
                              <option value="{{ $avaliador->id }}" > {{ $avaliador->user->name }} ({{$avaliador->area->nome ?? 'Indefinida'}}) </option>
                            @endforeach
                          </select>
                          <small id="emailHelp" class="form-text text-muted">Segure SHIFT do teclado para selecionar mais de um.</small>
                        </div>

                        <div>
                          <button type="submit" class="btn btn-info" style="width: 100%">Atribuir</button>
                        </div>

                      </form>

                    </div>
                  </div>
                </div>
              </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="container" style="margin-top: 50px;">
    <div class="row justify-content-center d-flex align-items-center" >

        <h3 class="titulo-table">Status dos Projetos em Avaliação do edital: <span style="color: black;">{{ $evento->nome }}</span> </h3>

    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Nome do Usuário</th>
        <th scope="col">E-mail</th>
        <th scope="col">Titulo do projeto</th>
        <th scope="col">Status avaliação</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avaliadores as $avaliador)
        @php $contador = 0;  @endphp
        @foreach($avaliador->trabalhos->where('evento_id', $evento->id) as $trabalho)
          @if($trabalho->pivot->status == true)
            @php $contador++;  @endphp
          @endif
          <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>{{ $trabalho->titulo }}</td>
          {{-- <td>{{ $contador }} / {{ $avaliador->trabalhos->where('evento_id', $evento->id)->count() }}</td> --}}
          <td>@if($trabalho->pivot->parecer == null) Pendente @else Avaliado @endif</td>
          <td> 
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                      @if($trabalho->pivot->parecer != null)
                        <a href="{{ route('admin.visualizarParecer', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" class="dropdown-item text-center">
                          Vizualizar Parecer
                        </a>
                      @else
                        <a href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" class="dropdown-item text-center">
                            Desatribuir Avaliador
                        </a>
                      @endif
                    </div>
                </div>
          </td>
        </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

</div>


<!-- Button trigger modal -->




@endsection

@section('javascript')
<script>
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  });

  function buscar(input) {
    var editais = document.getElementById('projetos').children;
    if(input.value.length > 2) {      
      for(var i = 0; i < editais.length; i++) {
        var nomeEvento = editais[i].children[0].textContent;
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
