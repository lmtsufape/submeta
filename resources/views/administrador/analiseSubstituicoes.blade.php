@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('sucesso'))
        <div class="alert alert-success" role="alert">
            {{ session('sucesso') }}
        </div>
    @endif
    @if(session('erro'))
        <div class="alert alert-danger" role="alert">
            {{ session('erro') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card" style="margin-top:50px">
                <div class="card-header">
                    <h4 class="card-title" style="color:#1492E6">
                        Substituições
                    </h4>
                    <h5 style="color:grey; font-size:medium">{{$trabalho->titulo}}</h5>
                </div>
                <div class="card-body">
                    @if($substituicoesPendentes->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Participante Substituido</th>
                                <th scope="col">Participante Substituto</th>
                                <th scope="col">Plano Substituto</th>
                                <th scope="col">Opção</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($substituicoesPendentes as $subs)
                                <tr>
                                    <td><a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" class="button">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</a></td>
                                    <td><a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" class="button">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</a></td>
                                    <td><a href="{{ route('baixar.plano', ['id' => $subs->planoSubstituto()->withTrashed()->first()->id]) }}">{{$subs->planoSubstituto()->withTrashed()->first()->titulo}}</a></td>
                                    <td>
                                        <div class="row justify-content-around">
                                            <a href="" data-toggle="modal" data-target="#modalResultadoSubst{{$subs->id}}" class="button"><i class="far fa-check-circle fa-2x"></i></a>
                                            <a href="" data-toggle="modal" data-target="#modalCancelarSubst{{$subs->id}}" class="button"><i class="far fa-times-circle fa-2x"></i></a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal aprovar substituição -->
                                <div class="modal fade" id="modalResultadoSubst{{$subs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Proceder Com Substituição</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" id="AprovarSubParticForm" action="{{route('trabalho.aprovarSubstituicao')}}">
                                                    @csrf
                                                    <input type="hidden" name="substituicaoID" value="{{$subs->id}}">
                                                    <input type="hidden" name="aprovar" value="true">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="justificativaTextArea">Justificativa:</label>
                                                                <textarea class="form-control" id="justificativaTextArea" rows="3" name="textJustificativa" ></textarea>
                                                            </div>
                                                            <select class="custom-select" name="selectJustificativa" >
                                                                <option value="DESISTENCIA">DESISTÊNCIA</option>													  
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end mt-4">
                                                        <div class="col-md-auto">
                                                            <div><button type="submit" class="btn btn-success">Aprovar Substituição</button></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal reprovar substituição -->
                                <div class="modal fade" id="modalCancelarSubst{{$subs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="overflow-x:auto">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Cancelar Substituição</h5>

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="POST" id="CancelarSubParticForm" action="{{route('trabalho.aprovarSubstituicao')}}">
                                                    @csrf
                                                    <input type="hidden" name="substituicaoID" value="{{$subs->id}}">
                                                    <input type="hidden" name="aprovar" value="false">

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="justificativaTextArea">Justificativa:</label>
                                                                <textarea class="form-control" id="justificativaTextArea" rows="3" name="textJustificativa" ></textarea>
                                                            </div>
                                                            <select class="custom-select" name="selectJustificativa" >
                                                                <option value="DESISTENCIA">DESISTÊNCIA</option>													  
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-end mt-4">
                                                        <div class="col-md-auto">
                                                            <div><button type="submit" class="btn btn-success">Cancelar Substituição</button></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal vizualizar info participante substituido -->
                                <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <!-- Modal vizualizar info participante substituto -->
                                <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    @include('administrador.vizualizarParticipante')
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <h4>Nenhuma substituição Pendente</h4>
                    @endif

                    <h4 style="margin-top: 50px">Substituições</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <div class="row">
                                        <div class="col-4">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituido
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituto
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Tipo
                                            </h5>
                                        </div>
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Status
                                            </h5>
                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($substituicoesProjeto as $subs)
                                    <div class="row"style="margin-bottom: 20px;">
                                            <div class="col-4">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->created_at))}} - @if($subs->participanteSubstituido()->withTrashed()->first()->deleted_at == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->deleted_at))}} @endif</h5>
                                            </div>
                                            <div class="col-4">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->created_at))}} - @if($subs->participanteSubstituto()->withTrashed()->first()->deleted_at == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->deleted_at))}} @endif</h5>
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
                                    </div>

                                    <!-- Modal vizualizar info participante substituido -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @include('administrador.vizualizarParticipante', ['visualizarSubstituido' => 1])
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar info participante substituto -->
                                    <div class="modal fade" id="modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">

                                                    <div class="modal-header" style="overflow-x:auto">
                                                        <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        @include('administrador.vizualizarParticipante')
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>

</script>
@endsection