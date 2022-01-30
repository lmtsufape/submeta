@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 30px;">


  <div class="container" >
    <div class="row justify-content-center" style="margin-bottom: 50px;">
      <div class="col-md-1">
        <a href="{{ route('plano.trabalho.index', ['evento_id' => $evento->id]) }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-md-10" style="text-align: center;">
        <h3  class="titulo-table">Lista de Planos do Edital: <span style="color: black;">{{ $evento->nome }}</span> </h3>
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
        <th scope="col">Proponente</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody id="projetos">
      @foreach ($planos as $plano)
        <tr>
          <td>{{ $plano->titulo}}</td>
          {{-- <td>{{ App\Area::find($trabalho->area_id)->nome}}</td> --}}
          <td>{{ $plano->participante->user->name }}</td>
          <td style="text-align:center">
              <button type="button" class="btn btn-primary" value="{{ $plano->id }}" id="atribuir1" data-toggle="modal" data-target="#exampleModalCenter{{ $plano->id }}">
                Atribuir
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter{{ $plano->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content modal-submeta">
                    <div class="modal-header modal-header-submeta">
                      <h5 class="modal-title titulo-table" id="exampleModalLongTitle">Selecione o(s) avaliador(es)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"  style="color: rgb(182, 182, 182)">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form action="{{ route('plano.trabalho.atribuicao') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plano_id" value="{{ $plano->id }}">
                        <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                        <div class="form-group">
                          <label for="exampleFormControlSelect2">Selecione o(s) avaliador(es) para esse plano</label>
                          <select  name="avaliadores_id[]" multiple class="form-control" id="exampleFormControlSelect2">
                            @foreach ($plano->aval as $avaliador)
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

        <h3 class="titulo-table">Status dos Planos em Avaliação do edital: <span style="color: black;">{{ $evento->nome }}</span> </h3>

    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Tipo</th>
        <th scope="col">E-mail</th>
        <th scope="col">Status</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avaliadores as $avaliador)
        @php $contador = 0;  @endphp
        @foreach($avaliador->planoTrabalhos as $plano)
          @if($plano->pivot->status == true)
            @php $contador++;  @endphp
          @endif
        @endforeach
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->tipo }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>{{ $contador }} / {{ $avaliador->planoTrabalhos->count() }}</td>
          <td style="text-align:center"> ...</td>
        </tr>
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
