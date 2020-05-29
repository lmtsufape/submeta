@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Trabalhos</h3> 
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Projeto</th>
        <th scope="col">Data de Criação</th>
        <th scope="col">Baixar</th>
        <th scope="col">Parecer</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($trabalhos as $trabalho)
        <tr>
          <td>{{ $trabalho->titulo }}</td>
          <td>{{ $trabalho->create_at }}</td>
          <td>baixar</td>
          <td>parecer</td>
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
