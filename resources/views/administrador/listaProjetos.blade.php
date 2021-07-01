@extends('layouts.app')

@section('content')
  <div class="container" >
    <div class="row" >
      <div class="col-sm-5" style="float: center;">
        <h4 class="titulo-table">Editais</h4>
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
            <th scope="col">Nome da Proposta</th>
            <th scope="col">Autor</th>
            <th scope="col">Email</th>
            <th scope="col">Data de Criação</th>
            <th scope="col">Status</th>
            <th scope="col">Opção</th>
          </tr>
        </thead>
        <tbody id="eventos">
          @foreach ($projetos as $projeto)
            <tr>
              <td>
                <a href="{{  route('trabalho.show',['id'=>$projeto->id])  }}" class="visualizarEvento">
                    {{ $projeto->titulo }}
                </a>
              </td>
              <td>{{ $projeto->proponente->user->name }}</td>
              <td>{{ $projeto->proponente->user->email }}</td>
              <td>{{ date('d/m/Y', strtotime($projeto->created_at)) }}</td>
              
              <td>{{ $projeto->status }}</td>
              <td>
                
              </td>
            </tr>
            
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection