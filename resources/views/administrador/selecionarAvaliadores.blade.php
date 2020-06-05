@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">
  

  <div class="container" >
    <div class="row justify-content-center d-flex align-items-center" >
      <div class="col-md-10">
         <h3>Avaliadores </h3>
      </div>
      <div class="col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
          Enviar Convite
        </button>
      </div>
        

    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Email</th>
        <th scope="col">Área</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avaliadores as $avaliador)
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>{{ $avaliador->area->nome }}</td>
          <td style="text-align:center">
            <form action="{{ route('admin.adicionar') }}" method="POST">
              @csrf
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" >
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="submit" class="btn btn-primary" >Adicionar</button>
            </form>          
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  
  <div class="container" >
    <div class="row justify-content-center d-flex align-items-center" >
      
        <h4>Avaliadores Selecionados para o Edital: {{ $evento->nome }} </h4> 

    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Email</th>
        <th scope="col">Status</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avalSelecionados as $avaliador)
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>Status-Aceito ou Rejeitado</td>

          <td style="text-align:center">
            <form action="{{ route('admin.remover') }}" method="POST">
              @csrf
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" >
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="submit" class="btn btn-primary" @if($avaliador->trabalhos->count() != 0) disabled="disabled" @endif >Remover</button>
            </form>   
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Enviar Convite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('admin.enviarConvite') }}" method="POST">
          @csrf
          <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
          <div class="form-group">
            <label for="exampleInputEmail1">Nome Completo</label>
            <input type="text" class="form-control" name="nomeAvaliador" id="exampleInputNome1">            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="emailAvaliador" id="exampleInputEmail1">            
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Tipo</label>
            <select class="form-control" name="tipo" id="exampleFormControlSelect1">
              <option value="avaliador" >Avaliador</option>
            </select>
          </div>

          <div class="mx-auto" >
            <button type="submit" class="btn btn-success mx-auto">Enviar</button>
          </div>             
        </form>

      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  })
</script>
@endsection
