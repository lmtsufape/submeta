<h4 style="margin-top: 50px">Substituições</h4>
<div style="margin-top: 20px">
    <div class="card-header">
        <div class="row">
            <div class="col-3">
                <h5 class="card-title" style="color:#1492E6">Participante Substituído</h5>
            </div>
            <div class="col-3">
                <h5 class="card-title" style="color:#1492E6">Participante Substituto</h5>
            </div>
            <div class="col-2">
                <h5 class="card-title" style="color:#1492E6">Tipo</h5>
            </div>
            <div class="col-2">
                <h5 class="card-title" style="color:#1492E6">Status</h5>
            </div>
            <div class="col-2">
                <h5 class="card-title" style="color:#1492E6">Justificativa</h5>
            </div>
        </div>
    </div>

    @if($substituicoesProjeto != null && !$substituicoesProjeto->isEmpty())
        <div class="card-body">
        @foreach($substituicoesProjeto as $subs)
        @php
            $substituido = $subs->participanteSubstituido()->withTrashed()->first();
            $substituto  = $subs->participanteSubstituto()->withTrashed()->first();
        @endphp

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-3">
                <a href="" data-toggle="modal" data-target="#modal-info-participante-{{$substituido->id}}" class="button">
                    <h4 style="font-size:18px">{{$substituido->user->name}}</h4>
                </a>
                <h5 style="color:grey; font-size:medium">
                    {{date('d-m-Y', strtotime($substituido->data_entrada))}} -
                    @if($substituido->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($substituido->data_saida))}} @endif
                </h5>
            </div>
            <div class="col-3">
                <a href="" data-toggle="modal" data-target="#modal-info-participante-{{$substituto->id}}" class="button">
                    <h4 style="font-size:18px">{{$substituto->user->name}}</h4>
                </a>
                <h5 style="color:grey; font-size:medium">
                    {{date('d-m-Y', strtotime($substituto->data_entrada))}} -
                    @if($substituto->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($substituto->data_saida))}} @endif
                </h5>
            </div>
            <div class="col-2">
                @if($subs->tipo == 'ManterPlano')
                    <h5>Manter Plano</h5>
                @elseif($subs->tipo == 'TrocarPlano')
                    <h5>Alterar Plano</h5>
                @elseif($subs->tipo == 'Completa')
                    <h5>Completa</h5>
                @endif
            </div>
            <div class="col-2">
                @if($subs->status == 'Finalizada')
                    <h5>Concluída</h5>
                @elseif($subs->status == 'Negada')
                    <h5>Negada</h5>
                @elseif($subs->status == 'Em Aguardo')
                    <h5>Pendente</h5>
                @endif
            </div>
            <div class="col-2">
                @if($subs->status == 'Em Aguardo')
                    <h5>Pendente</h5>
                @else
                    <a href="" data-toggle="modal" data-target="#modal-justificativa-substituicao-{{$subs->id}}" class="button">
                        <h4 style="font-size:18px">Visualizar</h4>
                    </a>
                @endif
            </div>
        </div>

        <!-- Modal: justificativa da substituição -->
        <div class="modal fade" id="modal-justificativa-substituicao-{{$subs->id}}" tabindex="-1" role="dialog" aria-labelledby="modalJustificativaSubLabel{{$subs->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="overflow-x:auto">
                        <h5 class="modal-title" id="modalJustificativaSubLabel{{$subs->id}}" style="color:#1492E6">Justificativa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 style="font-size:18px">{{$subs->justificativa}}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: info participante substituído -->
        <div class="modal fade" id="modal-info-participante-{{$substituido->id}}" tabindex="-1" role="dialog" aria-labelledby="modalInfoSubstituidoLabel{{$substituido->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                        <h5 class="modal-title" id="modalInfoSubstituidoLabel{{$substituido->id}}" style="color:#1492E6">Informações Participante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 20px 32px 32px;">
                        @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: info participante substituto -->
        <div class="modal fade" id="modal-info-participante-{{$substituto->id}}" tabindex="-1" role="dialog" aria-labelledby="modalInfoSubstitutoLabel{{$substituto->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                        <h5 class="modal-title" id="modalInfoSubstitutoLabel{{$substituto->id}}" style="color:#1492E6">Informações Participante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 20px 32px 32px;">
                        @include('administrador.vizualizarParticipante')
                    </div>
                </div>
            </div>
        </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning mt-3" role="alert">
            Não há substituições registradas nesse projeto.
        </div>
    @endif
    </div>