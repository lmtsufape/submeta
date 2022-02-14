@extends('layouts.app')

@section('content')

<div class="container">
  @if(isset($mensagem))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{ $mensagem }}</p>
      </div>
  </div>
  @endif
  @if(session('mensagem'))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{session('mensagem')}}</p>
      </div>
  </div>
  @endif
  <div class="row justify-content-center" style="margin-top: 3rem;">
    <div class="col-md-11" style="margin-bottom: -3rem">
      <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
            <div class="bottomVoltar" style="margin-top: -20px">
              <a href="{{ route('home') }}"  class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div class="form-group">
                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Meus editais</h5>
            </div>
            <div style="margin-top: -2rem">
              <div class="form-group">
                <div style="margin-top:30px;">
                 {{-- Pesquisar--}}
                </div>
              </div>
            </div>
          </div>
        </div>
        

        <div class="card-body" >
            <table class="table table-bordered table-hover" style="display: block; overflow-x: auto; white-space: nowrap; border-radius:10px; margin-bottom:0px">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Nome do Edital</th>
                  <th scope="col">Data de Início da Revisão</th>
                  <th scope="col" style="text-align: center">Data de Fim da Revisão</th>
                  <th scope="col">Opção</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($eventos as $evento)
                  @if($evento->pivot->convite !== false)
                    <tr>
                      <td>
                          {{ $evento->nome }}
                      </td>
                      <td style="text-align:center">{{ date('d/m/Y', strtotime($evento->inicioRevisao)) }}</td>
                      <td style="text-align:center">{{ date('d/m/Y', strtotime($evento->fimRevisao)) }}</td>
                      <td>
                        <div class="btn-group dropright dropdown-options" style="width: 100%; text-align:center; float:none">
                            <a id="options" class="dropdown-toggle btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                            </a>
                            <div class="dropdown-menu">
                              @if(!is_null(Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite) && Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite == true )
                                <a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id]) }}" class="dropdown-item">
                                    <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                                    Avaliar Propostas
                                </a>
                              @elseif(!is_null(Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite) && Auth::user()->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite == false)
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
                  @endif
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('javascript')
<script>

</script>
@endsection
