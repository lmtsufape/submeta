@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Trabalhos do Edital:  {{ $evento->nome }}</h3> 
        {{-- <h6>Data inicioSubmissao: {{ date('d/m/Y', strtotime($evento->inicioSubmissao)) }}</h6> 
        <h6>Data fim da submissao:  {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</h6>  --}}
        <h6>Data inicioRevisao:   {{ date('d/m/Y', strtotime($evento->inicioRevisao)) }}</h6> 
        <h6>Data fimRevisao:      {{ date('d/m/Y', strtotime($evento->fimRevisao)) }}</h6> 
        <h6>Data do resultado:       {{ date('d/m/Y', strtotime($evento->resultado_final)) }}</h6> 
      </div>
    </div>
  </div>
  <hr>
      <div class="accordion" id="accordionExample">
        @foreach( $trabalhos as $trabalho )
        <div class="card ">
          <div class="card-header " id="headingOne">
            <h2 class="mb-0">

              <a class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne{{ $trabalho->id }}" aria-expanded="true" aria-controls="collapseOne">
                <h5>Titulo: {{ $trabalho->titulo }}</h5> 
                
              </a>
            </h2>
          </div>

          <div id="collapseOne{{ $trabalho->id }}" class="collapse @if($trabalhos->first() == $trabalho) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Avaliador</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Avaliação</th>
                    <th scope="col">Data</th>
                    <th scope="col">Recomendação</th>
                    <th scope="col">Parecer</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($trabalho->avaliadors as $avaliador)
                    @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->acesso == 2 || $avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->acesso == 3 || ( $avaliador->tipo == "Interno" && $avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->acesso == null ))
                      @php
                        $parecerInterno = App\ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                      @endphp
                      <tr>
                        <td>{{ $avaliador->user->name }}</td>
                        <td>{{ $avaliador->tipo }}</td>
                        <td>{{ $avaliador->user->email }}</td>
                        <td>Interna</td>
                        <td>
                          @if($parecerInterno == null)
                            Indisponível
                          @else
                            {{ date('d/m/Y', strtotime($parecerInterno->created_at)) }}
                          @endif
                        </td>
                        {{--Parecer--}}
                        <td>
                          @if($parecerInterno == null)
                            Indisponível
                          @else
                            {{ $parecerInterno->statusParecer }}
                          @endif
                        </td>
                        {{--Acesso ao parecer interno--}}
                        <td>
                          @if($parecerInterno == null)
                            <button class="btn btn-danger"  disabled="disabled"  >
                              Indisponível
                            </button>
                          @else
                            <a href="{{ route('admin.visualizarParecerInterno', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" class="btn btn-primary" >
                              Visualizar
                            </a>
                          @endif
                        </td>
                      </tr>
                    @endif


                    @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->acesso == 1 || $avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->acesso == 3 || $avaliador->tipo == "Externo")
                      <tr>
                        <td>{{ $avaliador->user->name }}</td>
                        <td>{{ $avaliador->tipo }}</td>
                        <td>{{ $avaliador->user->email }}</td>
                        <td>Ad Hoc</td>
                        <td>
                          @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->parecer == null)
                            Indisponível
                          @else
                            {{ date('d/m/Y', strtotime($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->created_at)) }}
                          @endif
                        </td>
                        {{--Parecer--}}
                        <td>
                          @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->parecer == null)
                            Indisponível
                          @else
                            {{ $avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->recomendacao }}
                          @endif
                        </td>
                        <td>
                          <form action="{{ route('admin.visualizarParecer') }}" method="post">
                            @csrf
                            <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                            <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}">
                            @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->parecer == null)
                              <button class="btn btn-danger"  disabled="disabled"  >
                                Indisponível
                              </button>
                            @else
                              <button class="btn btn-primary"  >
                                Visualizar
                              </button>
                            @endif
                          </form>

                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach
      </div>
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
