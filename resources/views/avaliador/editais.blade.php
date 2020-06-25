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
        <th scope="col">Data de Inicio da Revisão</th>
        <th scope="col">Data de Fim da Revisão</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($eventos as $evento)
        <tr>
          <td>            
              {{ $evento->nome }}
          </td>
          <td>{{ date('d/m/Y', strtotime($evento->inicioRevisao)) }}</td>
          <td>{{ date('d/m/Y', strtotime($evento->fimRevisao)) }}</td>
          <td>
            <div class="btn-group dropright dropdown-options">
                <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> 
                </a>
                <div class="dropdown-menu">
                  @if(!is_null(Auth::user()->avaliadors->eventos->where('id', 1)->first()->pivot->convite) && Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite == true )
                    <a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]) }}" class="dropdown-item">
                        <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                        Projetos para avaliar
                    </a>
                  @elseif(!is_null(Auth::user()->avaliadors->eventos->where('id', 1)->first()->pivot->convite) && Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite == false)
                    <button disabled="disabled" class="dropdown-item">
                       Convite recusado
                    </button>
                  @elseif(is_null(Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite) )
                    <a href="{{ route('avaliador.conviteResposta', ['evento_id' => $evento->id, 'resposta'=>true]) }}" class="dropdown-item">
                        <img src="{{asset('img/icons/confirm.png')}}" class="icon-card" alt="" style="width: 20px; height: auto">
                        Aceitar Convite
                    </a>
                    <a href="{{ route('avaliador.conviteResposta', ['evento_id' => $evento->id, 'resposta'=>false]) }}" class="dropdown-item">
                        <img src="{{asset('img/icons/recuse.png')}}" class="icon-card" alt="" style="width: 20px; height: auto">
                        Recusar Convite
                    </a>
                  @endif
                    

                    
                    
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
