@extends('layouts.app')

@section('content')

<div class="container">

    {{-- titulo da página --}}
    <div class="row justify-content-center" style="margin-top: 3rem; text-align:center">
        <div class="col-md-12" style="margin-bottom: -0.5rem">
            <h3>Editais</h3>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    @php
        $hoje = now();
    @endphp
    <div class="row">

        @if(count($eventos)>0)
            @foreach ($eventos as $evento)

            @if (Auth::check())
            <a href="{{  route('evento.visualizar',['id'=> $evento->id])  }}" style="text-decoration: none">
            @else 
            <a href="{{  route('evento.visualizarNaoLogado', ['id'=>$evento->id])  }}" style="text-decoration: none">
            @endif
                <div class="card" style="width: 18rem; border-radius:12px; border-width:0px">
                    @if(isset($evento->fotoEvento))
                    <img src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" class="card-img-top" alt="...">
                    @else
                    <img src="{{asset('img/img_fundo.png')}}" class="card-img-top" alt="..." style="border-radius: 12px;">
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="card-title">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <h3 style="color: #01487E; font-family:Arial, Helvetica, sans-serif; font-size:30px; font-weight:bold">{{$evento->nome}}</h3>
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
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px">
                            <div><img src="{{asset('img/icons/icon_submissao.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Submissão</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}</div>
                            </div>
                        </div>
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px">
                            <div><img src="{{asset('img/icons/icon_revisao.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Revisão</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}</div>
                            </div>
                        </div>
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px">
                            <div><img src="{{asset('img/icons/icon_resultado_preliminar.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Resultado preliminar</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->resultado_preliminar))}}</div>
                            </div>
                        </div>
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px">
                            <div><img src="{{asset('img/icons/icon_recurso.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Recurso</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->inicio_recurso))}} - {{date('d/m/Y',strtotime($evento->fim_recurso))}}</div>
                            </div>
                        </div>
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px">
                            <div><img src="{{asset('img/icons/icon_resultado_final.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Resultado final</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->resultado_final))}}</div>
                            </div>
                        </div>
                        <!--<p class="card-text">
                            
                            <strong>Submissão:</strong> {{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}<br>
                            <strong>Revisão:</strong> {{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}<br>
                            <strong>Resultado Preliminar:</strong> {{date('d/m/Y',strtotime($evento->resultado_preliminar))}}<br>
                            <strong>Recurso:</strong> {{date('d/m/Y',strtotime($evento->inicio_recurso))}} - {{date('d/m/Y',strtotime($evento->fim_recurso))}}<br>
                            <strong>Resultado Final:</strong> {{date('d/m/Y',strtotime($evento->resultado_final))}}<br>
                        </p>-->

                        <!--<p>
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
                        </p> -->
                    </div>

                </div>
            </a>
            @endforeach
        @else
            <div class="form-row justify-content-lg-center" style="width:100%; margin-top:4rem; text-align:center">
                <div class="col-md-12">
                    <img src="{{asset('img/icons/logo_projeto.png')}}"  alt="..." width="190px">
                </div>
                <div class="col-md-5" style="text-align: center;margin-top:1rem"><h5>Nenhum edital cadastrado!</h5></div>
            </div>
        @endif
    </div>

</div>

@endsection
