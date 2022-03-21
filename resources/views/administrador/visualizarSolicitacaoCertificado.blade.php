@extends('layouts.app')

@section('content')
    <div class="row justify-content-center"
        style="margin-top: 100px;">
        <div class="col-md-11">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-body"
                        style="padding-top: 0.2rem;">
                        <div class="container">
                            <div class="form-row mt-3">
                                <div class="col-md-12">
                                    <h5 style="color: #1492E6; font-size: 20px;">Trabalho - {{ $trabalho->titulo }}</h5>
                                </div>
                                <div class="col-md-12">
                                    <h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold; font-size: 14px;">
                                        Solicitação de certificado/declaração</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($notificacao->solicitacaoCertificado->solicitacoesParticipantes as $solicitacao)
        <!--Informações Proponente-->
        <div class="row justify-content-center"
            style="margin-top: 20px;">
            <br>
            <div class="col-md-11">
                <div class="card"
                    style="border-radius: 5px;">
                    <div class="card-body"
                        style="padding-top: 0.2rem;">
                        <div class="container">
                            <div class="form-row mt-3">
                                <div class="col-md-10">
                                    <h5 style="color: #234B8B; font-weight: bold">Solicitante: {{ $solicitacao->user->name }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
