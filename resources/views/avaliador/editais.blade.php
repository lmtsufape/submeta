@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-12">
        <h3>Meus Editais</h3> 
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Edital</th>
        <th scope="col">Data de Criação</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($eventos as $evento)
        <tr>
          <td>            
              {{ $evento->nome }}
          </td>
          <td>10/05/2020</td>
          <td>
            <div class="btn-group dropright dropdown-options">
                <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> 
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]) }}" class="dropdown-item">
                        <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                        Projetos para avaliar
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
