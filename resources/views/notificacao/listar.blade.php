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
                          @if($notificacao->destinatario_id == Auth::user()->id || Auth::user()->administradors != null)
                              <h6 style="font-size: 18px">Nova proposta para {{$notificacao->trabalho->evento->nome}}</h6>
                              <p style="font-size: 14px;     margin-bottom: 0;">Projeto: {{$notificacao->trabalho->titulo}}</p>
                              <div style="text-align: right">
                                <a href="{{route('admin.analisarProposta',['id'=>$notificacao->trabalho->id])}}" >Visualizar</a>
                              </div>
                          @else
                              <h6 style="font-size: 18px">Proposta enviada para {{$notificacao->trabalho->evento->nome}}</h6>
                              <p style="font-size: 14px;     margin-bottom: 0;">Projeto: {{$notificacao->trabalho->titulo}}</p>
                              <div style="text-align: right">
                                  <a href="{{ route('trabalho.show', ['id' => $notificacao->trabalho->id]) }}" >Visualizar</a>
                              </div>
                          @endif
                      <!--Substituição de participante-->
                      @elseif($notificacao->tipo==2)
                          @if($notificacao->destinatario_id == Auth::user()->id || Auth::user()->administradors != null)
                              <h6 style="font-size: 18px">Substituição de discente para {{$notificacao->trabalho->evento->nome}}</h6>
                              <p style="font-size: 14px;     margin-bottom: 0;">Projeto: {{$notificacao->trabalho->titulo}}</p>
                              <div style="text-align: right">
                                  <a href="{{route('admin.analisarProposta',['id'=>$notificacao->trabalho->id])}}" >Visualizar</a>
                              </div>
                          @else
                              <h6 style="font-size: 18px">Pedido de substituição de discente para {{$notificacao->trabalho->evento->nome}}</h6>
                              <p style="font-size: 14px;     margin-bottom: 0;">Projeto: {{$notificacao->trabalho->titulo}}</p>
                              <div style="text-align: right">
                                  <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $notificacao->trabalho->evento->id, 'projeto_id' => $notificacao->trabalho->id])}}" >Visualizar</a>
                              </div>
                          @endif
                      @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  @endforeach



@endsection
