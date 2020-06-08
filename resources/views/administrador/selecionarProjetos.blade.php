@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">
  

  <div class="container" >
    <div class="row justify-content-center d-flex align-items-center" >
      {{-- <div class="col-md-12"> --}}
         <h3>Lista  de Projetos do Edital: {{ $evento->nome }} </h3>         
      {{-- </div> --}}

    </div>
    <div class="row justify-content-center d-flex align-items-center" >
      {{-- <div class="col-md-12"> --}}
         <h5>Total:  </h5>         
      {{-- </div> --}}

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
    <tbody>
      @foreach ($trabalhos as $trabalho)
        <tr>
          <td>{{ $trabalho->titulo}}</td>
          <td>{{ $trabalho->area->nome}}</td>
          <td>{{ $trabalho->proponente->user->name }}</td>
          <td style="text-align:center">
              <button type="button" class="btn btn-primary" value="{{ $trabalho->id }}" id="atribuir1" data-toggle="modal" data-target="#exampleModalCenter{{ $trabalho->id }}">
                Atribuir
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter{{ $trabalho->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Selecione o avaliador(es)</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <form action="{{ route('admin.atribuicao') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                        <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                        <div class="form-group">
                          <label for="exampleFormControlSelect2">Example multiple select</label>
                          <select  name="avaliadores_id[]" multiple class="form-control" id="exampleFormControlSelect2">              
                            @foreach ($trabalho->aval as $avaliador)                
                              <option value="{{ $avaliador->id }}" > {{ $avaliador->user->name }} ({{ $avaliador->area->nome }}) </option>
                            @endforeach     
                          </select>
                          <small id="emailHelp" class="form-text text-muted">Segure SHIFT do teclado para selecionar mais de um.</small>
                        </div>

                        <div class="mx-auto" >
                          <button type="submit" class="btn btn-success mx-auto">Atribuir</button>
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
  
  <div class="container" >
    <div class="row justify-content-center d-flex align-items-center" >
      
        <h3>Status dos Projetos em Avaliação: {{ $evento->nome }} </h3> 

    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">E-mail</th>
        <th scope="col">Status</th>
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
        @endforeach
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>{{ $contador }} / {{ $avaliador->trabalhos->where('evento_id', $evento->id)->count() }}</td>
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
  })

</script>
@endsection
