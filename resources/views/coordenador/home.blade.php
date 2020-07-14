@extends('layouts.app')

@section('content')

<div class="container">

    {{-- titulo da página --}}
    <div class="row justify-content-center titulo">
        <div class="col-sm-12">
            <div class="row">

                <h3>Editais</h3>

            </div>
        </div>
    </div>

    <div class="row">


        @foreach ($eventos as $evento)
            <div class="card" style="width: 18rem;">
                @if(isset($evento->fotoEvento))
                  <img src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" class="card-img-top" alt="...">
                @else
                  <img src="{{asset('img/colorscheme.png')}}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title">
                                <div class="row justify-content-center">
                                    <div class="col-sm-12">
                                        {{$evento->nome}}
                                        {{-- @if(Auth::user()->tipo == "administrador" || Auth::user()->tipo == "administradorResponsavel") --}}
                                        @can('isCoordenador', $evento)
                                            <div class="btn-group dropright dropdown-options">
                                                <a id="options" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('coord.detalhesEvento', ['eventoId' => $evento->id]) }}" class="dropdown-item">
                                                        <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                                                        Detalhes
                                                    </a>
                                                    <a href="{{route('evento.editar',$evento->id)}}" class="dropdown-item">
                                                        <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                                                        Editar
                                                    </a>
                                                    <form method="POST" action="{{route('evento.deletar',$evento->id)}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="dropdown-item">
                                                            <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
                                                            Deletar
                                                        </button>

                                                    </form>
                                                </div>
                                            </div>
                                        @endcan
                                       {{--  @endif --}}
                                    </div>

                                </div>

                            </h4>

                        </div>
                    </div>
                    <p class="card-text">
                        <strong>Submissão:</strong> {{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}<br>
                        <strong>Revisão:</strong> {{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}<br>
                        <strong>Resultado Preliminar:</strong> {{date('d/m/Y',strtotime($evento->resultado_preliminar))}}<br>
                        <strong>Recurso:</strong> {{date('d/m/Y',strtotime($evento->inicio_recurso))}} - {{date('d/m/Y',strtotime($evento->fim_recurso))}}<br>
                        <strong>Resultado Final:</strong> {{date('d/m/Y',strtotime($evento->resultado_final))}}<br>
                    </p>

                    <p>
                        @if (Auth::check())
                            <a href="{{  route('evento.visualizar',['id'=> $evento->id])  }}" class="visualizarEvento">Visualizar edital</a>
                            @if($evento->inicioSubmissao <= $hoje && $hoje <= $evento->fimSubmissao)
                              @if(Auth::user()->proponentes == null)
                                <br><a href="{{ route('proponente.create' )}}" class="visualizarEvento">Criar projeto</a>
                              @else
                                  <br><a href="{{ route('trabalho.index', ['id' => $evento->id] )}}" class="visualizarEvento">Criar projeto</a>
                              @endif
                            @endif
                        @else
                            <a href="{{  route('evento.visualizarNaoLogado', ['id'=>$evento->id])  }}" class="visualizarEvento">Visualizar edital</a>
                        @endif
                    </p>
                </div>

            </div>
        @endforeach
    </div>

</div>

@endsection
