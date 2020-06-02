@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">

    <div class="container" >
      <div class="row" >
        <div class="col-sm-10">
            <h3>Projetos do edital {{ $edital->nome }}</h3> 
            <h6 style="color: rgb(4, 78, 4);">Submissão irá até o dia {{ date('d-m-Y', strtotime($edital->fimSubmissao)) }}</h6>
        </div>
          <div class="col-sm-2">
            <a href="{{route('trabalho.index', ['id' => $edital->id] )}}" class="btn btn-primary">Criar projeto</a>
          </div>
      </div>
    </div>
    <hr>
    <table class="table table-bordered">
        <thead>
          <tr>   
            <th scope="col">Nome do projeto</th>
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
              @if($projeto->avaliado)
                <td style="color: rgb(6, 85, 6)">Avaliado</td>
              @else
                <td style="color: rgb(0, 0, 0)">Submetido</td>
              @endif
              <td>{{$projeto->update}}</td>   
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{-- <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> --}}
                    </a>
                    <div class="dropdown-menu">
                        <a href="" class="dropdown-item" style="text-align: center;">
                            Editar projeto
                        </a>
                        <a href="" class="dropdown-item" style="text-align: center">
                          Adicionar participantes
                        </a>
                        <a href="" class="dropdown-item" style="text-align: center">
                          Recorrer
                        </a>
                        <a href="" class="dropdown-item" style="text-align: center">
                          Resultado
                        </a>
                    </div>
                </div>
              </td>
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