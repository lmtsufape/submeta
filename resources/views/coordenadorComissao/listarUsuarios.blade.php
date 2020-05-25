@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Usuarios</h3> 
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Data de Criação</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->user->name }}</td>
          <td>{{ $usuario->user->email }}</td>
          <td>3</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
