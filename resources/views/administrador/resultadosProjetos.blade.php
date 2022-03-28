@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row" >
                    <div class="col-sm-4">
                        <div class="row">
                        <div class="col-sm-2">
                            <button class="btn" onclick="buscarProjeto(this.parentElement.parentElement.children[1].children[0])">
                            <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
                            </button>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-edit" placeholder="Digite o nome do projeto" onkeyup="buscarProjeto(this)">
                        </div>
                        </div>
                    </div>

                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5" style="float: center;">
                        <h4 class="titulo-table">Resultados</h4>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
            <table class="table table-bordered" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
                <thead>
                <tr>
                    <th scope="col">Pontuação</th>
                    <th scope="col" style="width: 100%;">Nome do projeto</th>
                    <th scope="col">Proponente</th>
                    <th scope="col">Área</th>
                    <th scope="col">N. Planos</th>
                    <th scope="col">Avaliador</th>
                    <th scope="col">Status</th>
                    <th scope="col">Bolsas</th>
                </tr>
                </thead>
                <tbody id="projetos">
                    @foreach($trabalhos as $trabalho)
                        @if($trabalho->status == 'aprovado')
                        <tr>
                            <td>{{$trabalho->pontuacao}}</td>
                            <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">
                                {{$trabalho->titulo}}
                            </td>
                            <td>
                                {{$trabalho->proponente->user->name}}
                            </td>
                            <td>
                                {{$trabalho->area->nome}}
                            </td>
                            <td>
                                {{$trabalho->participantes->count()}}
                            </td>
                            <td>
                                @if($trabalho->avaliadors->count() > 0)
                                    @foreach($trabalho->avaliadors as $avaliador)
                                        {{$avaliador->user->name}}<br>
                                    @endforeach
                                @else
                                    Sem Atribuição
                                @endif
                            </td>
                            @if($trabalho->avaliadors->count() > 0)
                                <td>
                                    @foreach($trabalho->avaliadors as $avaliador)
                                        @if($avaliador->tipo == "Externo")
                                            {{$avaliador->pivot->recomendacao}}<br>
                                            @php
                                                $parecer = App\ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                                            @endphp
                                            @if($parecer != null && $parecer->statusParecer !=null){{$parecer->statusParecer}} @else Pendente @endif
                                        @endif
                                    @endforeach
                                </td>
                            @else
                                <td>Pendente</td>
                            @endif
                            <td>
                                <button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalConfirmTrab{{$trabalho->id}}" >
                                    Definir
                                </button>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    <div class="row justify-content-center" >
        <div class="col-md-12">
            <br>
            {{ $trabalhos->links() }}

        </div>

    </div>
</div>
{{--Janelas--}}
@foreach($trabalhos as $trabalho)
    <div class="modal fade" id="modalConfirmTrab{{$trabalho->id}}" tabindex="-1" role="dialog"
         aria-labelledby="modalConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalConfirmLabel" align="center" title="Participantes do {{$trabalho->titulo}}">
                        Projeto {{$trabalho->titulo}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: rgb(182, 182, 182)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($trabalho->participantes as $participante)
                        <div class="row modal-header-submeta">
                            <div class="col-sm-8">
                                <p style="font-size: 22px">Discente: {{$participante->user->name}}</p>
                            </div>
                            <div class="col-sm-4" align="left" style="padding-left: 0px">
                                <button type="button"  class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modalConfirm{{$participante->id}}" onclick="myFunction({{$trabalho->id}})">
                                    @if($participante->tipoBolsa==null)
                                        Não Definida
                                    @elseif($participante->tipoBolsa == "Voluntario")
                                        Voluntário
                                    @else
                                        {{$participante->tipoBolsa}}
                                    @endif
                                </button>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @foreach($trabalho->participantes as $participante)
        {{-- Janela de alocação de bolsa--}}
        <div class="modal fade" id="modalConfirm{{$participante->id}}" tabindex="-1" role="dialog"
             aria-labelledby="modalConfirmLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalConfirmLabel" align="center">
                            Confirmar alteração do tipo de bolsa ?</h4>
                    </div>
                    @if($participante->tipoBolsa!=null)
                        <div class="modal-body">
                            <h5 class="modal-title" id="modalConfirmLabel" align="center">
                                @if($participante->tipoBolsa=='Voluntario')
                                    O discente {{$participante->user->name}} será definido como bolsista
                                @else
                                    O discente {{$participante->user->name}} será definido como voluntário
                                @endif
                            </h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Não
                            </button>
                            <a type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>1])  }}"  id="btnSubmit" class="btn btn-info">
                                Sim
                            </a>
                        </div>
                    @else
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <a  style="float: right;" type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>1])  }}"  id="btnSubmit" class="btn btn-info">
                                        Voluntário
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a style="float: left;" type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>2])  }}"  id="btnSubmit" class="btn btn-info">
                                        Bolsista
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endforeach

@endsection

@section('javascript')
<script>
    function buscarProjeto(input) {
        var projetos = document.getElementById('projetos').children;
        if(input.value.length > 2) {      
            for(var i = 0; i < projetos.length; i++) {
                var nomeProjeto = projetos[i].innerText;
                if(nomeProjeto.substr(0).indexOf(input.value) >= 0) {
                    projetos[i].style.display = "";
                } else {
                    projetos[i].style.display = "none";
                }
            }
        } else {
            for(var i = 0; i < projetos.length; i++) {
                projetos[i].style.display = "";
            }
        }
    }

    function myFunction(data){
        document.getElementById('modalConfirmTrab'+data).modal('hide');
    }
</script>
@endsection