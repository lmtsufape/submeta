@extends('layouts.app')

@section('content')

    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-8">
            <h3 style="color: #1492E6;">Todas as Notificações</h3>
        </div>

        <!--Titulos -->
        @foreach($notificacoes as $notificacao)
            <div class="col-md-8">
                <div class="card" style="border-radius: 5px">
                    <div class="card-body" style="padding-top: 0.2rem;">
                        <div class="container">
                            <div class="form-row mt-3">
                                <div class="col-md-12">
                                    <!--Criação de proposta-->

                                    @if($notificacao->tipo==1)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id && $notificacao->remetente_id != Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Nova proposta
                                                        para {{$notificacao->trabalho->evento->nome}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Proposta enviada
                                                        para {{$notificacao->trabalho->evento->nome}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <!--Substituição de participante-->
                                    @elseif($notificacao->tipo==2)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id  && $notificacao->remetente_id != Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Substituição
                                                        para {{$notificacao->trabalho->evento->nome}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Pedido de substituição de discente
                                                        para {{$notificacao->trabalho->evento->nome}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <!-- Relatórios-->
                                    @elseif($notificacao->tipo==3)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Entrega de Relatório Parcial
                                                        do {{$notificacao->trabalho->titulo}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @elseif($notificacao->tipo==4)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Entrega de Relatório Final
                                                        do {{$notificacao->trabalho->titulo}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <!--Avaliação-->
                                    @elseif($notificacao->tipo==5)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Avaliação
                                                        para {{$notificacao->trabalho->titulo}}</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @elseif($notificacao->tipo==7)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Solicitação de desligamento
                                                        para {{$notificacao->trabalho->evento->nome}}</h6>
                                            @endif
                                        {{-- Certificado --}}
                                    @elseif ($notificacao->tipo == 6)
                                        <div class="row">
                                            @if($notificacao->destinatario_id == Auth::user()->id)
                                                <div class="col-sm-11">
                                                    <h6 style="font-size: 18px">Solicitação de certificado/declaração</h6>
                                                </div>
                                                @if(!$notificacao->lido)
                                                    <div class="col-sm-1">
                                                        <p class="circulo"></p>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                    <p style="font-size: 14px;     margin-bottom: 0;">
                                        Projeto: {{$notificacao->trabalho->titulo}}</p>
                                    <div style="text-align: right">
                                        <a href="{{route('notificacao.ler',['id'=>$notificacao->id])}}">Visualizar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @endforeach
        <style>
            .circulo {
                width: 35%;
                height: 60%;
                border-radius: 50%;
                background-color: #1492E6;
                margin: auto;
            }
        </style>


@endsection
