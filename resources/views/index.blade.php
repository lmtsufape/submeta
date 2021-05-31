@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(count($eventos)>0)
            <div class="col-sm-6" style="position: relative; top: 50px; padding: 25px;">
                <div class="row">
                    <img class="position-image" src="{{ asset('img/icons/logo_submeta_grande.png') }}" alt="">
                </div>
                <div class="row position-text">
                    <p style="text-indent: 0.5cm; color:#909090; font-size:16px">
                        O Submeta é um sistema de submissão de projetos acadêmicos, que pode ser adotado para os diferentes propósitos de Ensino, Pesquisa e Extensão. O sistema abrange todas as principais etapas relacionadas à submissão de projetos, permitindo o lançamento e configuração de editais, além de gerenciar a distribuição das avaliações e os pareceres técnicos dos avaliadores, como também, visualizar os projetos submetidos pelos proponentes.
                    </p>
                </div>
                <div class="row position-text">
                    {{-- <button class="btn btn-opcoes-edital" style="margin-bottom: 20px;">
                        Leia mais
                    </button> --}}
                </div>
            </div>
            <br>
            <div class="col-sm-6" style=" position: relative; top: 50px; padding: 25px;">
                <h4 style="color:  rgb(0, 140, 255);">Editais</h4>
                <div id="editais">
                    <ul class="col-sm-12 list-editais flexcroll" style="list-style-type: none;">
                        @php
                            $today = \Carbon\Carbon::create($hoje);
                        @endphp
                        @foreach ($eventos as $i => $evento)
                            @php
                                $fimSub = \Carbon\Carbon::create($evento->fimSubmissao);
                                $inicioRev = \Carbon\Carbon::create($evento->inicioRevisao);
                                $fimRev = \Carbon\Carbon::create($evento->fimRevisao);
                            @endphp
                            
                            @if ($fimSub >= $today)
                                <li class="col-sm-12 li-editais aberto bg-white">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img class="img-arquivo" src="{{ asset('img/icons/logo_arquivo.png') }}" alt="">
                                            </div>
                                            <div class="col-sm-8">
                                                <div>{{$evento->nome}}</div>
                                                <div class="color-subtitle-edital">Submissão até o dia {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</div>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ route('evento.visualizarNaoLogado', ['id' => $evento->id]) }}">
                                                    <button class="btn btn-opcoes-edital" style="float: right;">
                                                        Visualizar
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @elseif($fimSub < $today)
                                <li class="col-sm-12 li-editais encerrado bg-white" style="display: none;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img class="img-arquivo" src="{{ asset('img/icons/logo_arquivo.png') }}" alt="">
                                            </div>
                                            <div class="col-sm-8">
                                                <div>{{$evento->nome}}</div>
                                                <div class="color-subtitle-edital">Submissão até o dia {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</div>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ route('evento.visualizarNaoLogado', ['id' => $evento->id]) }}">
                                                    <button class="btn btn-opcoes-edital background-red" style="float: right;">
                                                        Encerrado
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                {{-- <li class="col-sm-12 li-editais avaliacao" style="display: none;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img class="img-arquivo" src="{{ asset('img/icons/logo_arquivo.png') }}" alt="">
                                            </div>
                                            <div class="col-sm-7">
                                                <div>{{$evento->nome}}</div>
                                                <div class="color-subtitle-edital">Submissão até o dia {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</div>
                                            </div>
                                            <div class="col-sm-4">
                                                <a href="{{ route('evento.visualizarNaoLogado', ['id' => $evento->id]) }}">
                                                    <button class="btn btn-opcoes-edital background-yellow" style="float: right;" disable>
                                                        Em avaliação
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li> --}}
                            {{-- @elseif($fimRev <= $today) 
                                <li class="col-sm-12 li-editais encerrado" style="display: none;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <img class="img-arquivo" src="{{ asset('img/icons/logo_arquivo.png') }}" alt="">
                                            </div>
                                            <div class="col-sm-8">
                                                <div>{{$evento->nome}}</div>
                                                <div class="color-subtitle-edital">Submissão até o dia {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</div>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ route('evento.visualizarNaoLogado', ['id' => $evento->id]) }}">
                                                    <button class="btn btn-opcoes-edital background-red" style="float: right;" disabled>
                                                        Encerrado
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li> --}}
                            @endif
                        @endforeach
                    </ul>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8" style="float: right;">
                    </div>
                    <div class="col-md-4" style="float: right;">
                        <select id="" class="form-control select-submeta" onchange="exibirEditais(this)">
                            <option value="aberto" selected>Aberto</option>
                            {{-- <option value="avaliacao">Em Avaliação</option> --}}
                            <option value="encerrado">Encerrado</option>
                            <option value="todos">Todos</option>
                        </select>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12" style="text-align: center;">
                <div class="form-row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div style="margin-top: 6rem"><img class="position-image" src="{{ asset('img/icons/logo_submeta_grande.png') }}" alt=""></div>
                            <div style="margin-top: 3rem">
                                <p style="text-indent: 0.5cm; color:#909090; font-size:16px">
                                    O Submeta é um sistema de submissão de projetos acadêmicos, que pode ser adotado para os diferentes propósitos de Ensino, Pesquisa e Extensão. O sistema abrange todas as principais etapas relacionadas à submissão de projetos, permitindo o lançamento e configuração de editais, além de gerenciar a distribuição das avaliações e os pareceres técnicos dos avaliadores, como também, visualizar os projetos submetidos pelos proponentes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        @endif
    </div>
</div>
@endsection

@section('javascript')
<script>
    function exibirEditais(select) {
        var abertos = document.getElementsByClassName("aberto");
        var avaliacao = document.getElementsByClassName("avaliacao");
        var encerrado = document.getElementsByClassName("encerrado");

        console.log(abertos);
        if (select.value == "aberto" || select.value == "todos") {
            for(var i = 0; i < abertos.length; i++) {
                abertos[i].style.display = "";
            }
        } else {
            for(var i = 0; i < abertos.length; i++) {
                abertos[i].style.display = "none";
            }
        }

        if (select.value == "avaliacao" || select.value == "todos") {
            for(var i = 0; i < avaliacao.length; i++) {
                avaliacao[i].style.display = "";
            }
        } else {
            for(var i = 0; i < avaliacao.length; i++) {
                avaliacao[i].style.display = "none";
            }
        }

        if (select.value == "encerrado" || select.value == "todos") {
            for(var i = 0; i < encerrado.length; i++) {
                encerrado[i].style.display = "";
            }
        } else {
            for(var i = 0; i < encerrado.length; i++) {
                encerrado[i].style.display = "none";
            }
        }
    }
</script>
@endsection
