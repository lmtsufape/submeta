<style>
    .event-item {
        display: none;
    }
</style>

@extends('layouts.app')

@section('content')

<div class="container">

    {{-- titulo da página --}}
    <div class="row justify-content-center" style="margin-top: 3rem; text-align:center">

        <div class="col-md-12">
            <div class="row justify-content-between">
                <div class="col-sm">
                    <select id="seletor" class="form-control select-submeta" onchange="onChangeSeletor(this)" style="width: 140px;">
                        <option value="aberto" selected>Aberto(s)</option>
                        <option value="encerrado">Encerrado(s)</option>
                        <option value="vaiAbrir">Previstos</option>
                        <option value="todos">Todos</option>
                    </select>
                </div>
                <div class="col-sm" style="margin-bottom: 10px">
                    @if($flag == 'false')
                        @if(count($eventos)>0)
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Editais</h5>
                        @else
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Edital</h5>
                        @endif
                    @else
                        <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Resultado da busca por: <span style="font-style: italic; font-weight:bold">{{$palavra}}</span></h5>
                    @endif
                </div>
                <div class="col-sm">
                        <form action="{{route('coord.home')}}" method="get">
                            @csrf
                            <div class="btn-group">
                                <input type="text" class="form-control shadow-sm" name="buscar" placeholder="Digite o nome do edital" value="{{$palavra}}" style="margin-right: 5px;border-radius:8px; border-color:#fff;">
                                <button type="submit" class="btn btn-light shadow-sm" style="border-radius: 8px"><img src="{{asset('img/icons/logo_lupa.png')}}" alt="" width="20px"></button>
                            </div>
                        </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <hr>
        </div>
    </div>
    
    <div class="row justify-content-center">
        @if(count($eventos)>0)
            @foreach ($eventos as $evento)

            @if (Auth::check())
                @if($evento->fimSubmissao >= $hoje && $hoje >= $evento->inicioSubmissao)
                    <a href="{{  route('evento.visualizar',['id'=> $evento->id])  }}" style="text-decoration: none" class="event-item aberto">
                @elseif($hoje > $evento->fimSubmissao)
                    <a href="{{  route('evento.visualizar',['id'=> $evento->id])  }}" style="text-decoration: none" class="event-item encerrado">
                @else
                    <a href="{{  route('evento.visualizar',['id'=> $evento->id])  }}" style="text-decoration: none" class="event-item vaiAbrir">
                @endif
            @else
                @if($evento->fimSubmissao >= $hoje && $hoje >= $evento->inicioSubmissao) 
                    <a href="{{  route('evento.visualizarNaoLogado', ['id'=>$evento->id])  }}" style="text-decoration: none" class="event-item aberto">
                @elseif($hoje > $evento->fimSubmissao)
                    <a href="{{  route('evento.visualizarNaoLogado', ['id'=>$evento->id])  }}" style="text-decoration: none" class="event-item encerrado">
                @else
                    <a href="{{  route('evento.visualizarNaoLogado',['id'=> $evento->id])  }}" style="text-decoration: none" class="event-item vaiAbrir">
                @endif
            @endif
                <div class="card" style="width: 18rem; border-radius:12px; border-width:0px; margin:10px">
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
                        <div class="row justify-content-lg-left" style="margin-left:1px; margin-right:1px; margin-bottom:-0.8rem">
                            <div><img src="{{asset('img/icons/icon_resultado_final.png')}}" class="card-img-top" alt="..." style="width:45px; margin-right:15px"></div>
                            <div class="form-group" style="text-align: left">
                                <div  style="font-weight: normal;color:black; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:-5px">Resultado final</div>
                                <div style="color: #909090">{{date('d/m/Y',strtotime($evento->resultado_final))}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
                <div id="empty-message" class="col-md-5" style="text-align: center;margin-top:1rem"><h5>Nenhum edital encontrado com esse status!</h5></div>

        @else
            <div class="form-row justify-content-lg-center" style="width:100%; margin-top:4rem; text-align:center">
                <div class="col-md-12">
                    <img src="{{asset('img/icons/logo_projeto.png')}}"  alt="..." width="190px">
                </div>
                @if($flag == 'true')
                    <div class="col-md-5" style="text-align: center;margin-top:1rem">
                        <h5>Nenhum edital encontrado!</h5>
                        <a href="{{route('coord.home')}}">Clique aqui para ver todos os editais</a>
                    </div>
                @else
                    <div class="col-md-5" style="text-align: center;margin-top:1rem"><h5>Nenhum edital cadastrado!</h5></div>
                @endif
            </div>
        @endif
    </div>

</div>

@endsection

@section('javascript')
<script>

    const STORAGE_KEY = 'eventos.status';

    function onChangeSeletor(select) {
        localStorage.setItem(STORAGE_KEY, select.value);
        exibirEditais(select);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const seletor = document.getElementById('seletor');
        if (!seletor) return;

        // restore saved value (fallback to default)
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            seletor.value = saved;
        }

        // apply filter after restoring
        exibirEditais(seletor);
    });

    function exibirEditais(select) {
        let abertos = document.getElementsByClassName("aberto");
        let encerrados = document.getElementsByClassName("encerrado");
        let vaiAbrir = document.getElementsByClassName("vaiAbrir");

        
        if(select.value == "todos"){
            for(let i = 0; i < abertos.length; i++ ){
                abertos[i].style.display = "block";
            }
            
            for(let j = 0; j < encerrados.length; j++ ){
                encerrados[j].style.display = "block";
            }
            
            for(let l = 0; l < vaiAbrir.length; l++ ){
                vaiAbrir[l].style.display = "block";
            }
        }else if(select.value == "aberto") {
            for(let i = 0; i < abertos.length; i++){
                abertos[i].style.display = "block";
            }

            for(let j = 0; j < encerrados.length; j++ ){
                encerrados[j].style.display = "none";
            }

            for(let l = 0; l < vaiAbrir.length; l++ ){
                vaiAbrir[l].style.display = "none";
            }
        }else if(select.value == "vaiAbrir"){

            for(let l = 0; l < vaiAbrir.length; l++ ){
                vaiAbrir[l].style.display = "block";
            }

            for(let i = 0; i < abertos.length; i++){
                abertos[i].style.display = "none";
            }

            for(let j = 0; j < encerrados.length; j++ ){
                encerrados[j].style.display = "none";
            }

        }else {

            for(let j = 0; j < encerrados.length; j++ ){
                encerrados[j].style.display = "block";
            }

            for(let i = 0; i < abertos.length; i++){
                abertos[i].style.display = "none";
            }

            for(let l = 0; l < vaiAbrir.length; l++ ){
                vaiAbrir[l].style.display = "none";
            }

        }
        checkEmpty();
    }

    function checkEmpty() {
        const items = document.querySelectorAll('.aberto, .encerrado, .vaiAbrir');
        let visible = 0;

        items.forEach(el => {
            if (el.style.display !== "none") {
                visible++;
            }
        });

        const empty = document.getElementById('empty-message');

        if (visible === 0) {
            empty.style.display = 'block';
        } else {
            empty.style.display = 'none';
        }
    }
</script>
<style>
    .event-item {
        display: none;
    }
</style>
@endsection