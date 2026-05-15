<h4 style="margin-top: 50px">Desligamentos</h4>
<div style="margin-top: 20px">
    <div class="card-header">
        <div class="row">
            <div class="col-4">
                <h5 class="card-title" style="color:#1492E6">Participante</h5>
            </div>
            <div class="col-2" style="text-align: center">
                <h5 class="card-title" style="color:#1492E6">Status</h5>
            </div>
            <div class="col-6" style="text-align: center">
                <h5 class="card-title" style="color:#1492E6">Justificativa</h5>
            </div>
        </div>
    </div>
    @if($desligamentos != null && !$desligamentos->isEmpty())
    <div class="card-body">
        @foreach($desligamentos as $desligamento)
            @php
                $participanteDesligado = $desligamento->participante()->withTrashed()->first();
            @endphp

            <div class="row" style="margin-bottom: 20px;">
                <div class="col-4">
                    <a href="" data-toggle="modal" data-target="#modal-info-participante-{{$participanteDesligado->id}}" class="button">
                        <h4 style="font-size:18px">{{$participanteDesligado->user->name}}</h4>
                    </a>
                    <h5 style="color:grey; font-size:medium">
                        {{date('d-m-Y', strtotime($desligamento->created_at))}}
                    </h5>
                </div>
                <div class="col-2" style="text-align: center">
                    <h5>{{$desligamento->getStatus()}}</h5>
                </div>
                <div class="col-6" style="text-align: center">
                    <h5>{{$desligamento->justificativa}}</h5>
                </div>
            </div>
            @endforeach
    </div>
    @else
        <div class="alert alert-warning mt-3" role="alert">
            Não há desligamentos registrados nesse projeto.
        </div>
    @endif
</div>