@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    @if (session('sucesso'))
        <div class="alert alert-success" role="alert">
            {{ session('sucesso') }}
        </div>
    @endif

    <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="row" >
                    <div class="col-sm-4">
                        <div class="row">
                        <div class="col-sm-2 noPrint">
                            <button class="btn" onclick="buscarProjeto(this.parentElement.parentElement.children[1].children[0])">
                            <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
                            </button>
                        </div>
                        <div class="col-sm-10 noPrint">
                            <input type="text" class="form-control form-control-edit" placeholder="Digite o nome do projeto" onkeyup="buscarProjeto(this)">
                        </div>
                        </div>
                    </div>

                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5 " style="float: center;">
                        <h4 class="titulo-table">Resultados</h4>
                    </div>
                    <div class="col-sm-2 noPrint">
                        <form>
                            <input type="button" value="Imprimir" class="btn btn-primary float-right"  onclick="window.print()"/>
                        </form>
                    </div>
                </div>
                <hr>
            </div>
        </div>


        <div class="col-sm-12">
            <h4 class="titulo-table" style="text-align: center">Projetos Recomendados</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            <table class="table table-bordered" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
                <thead>
                <tr>
                    <th scope="col">Posição</th>
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
                @php $cont=1;@endphp
                    @foreach($trabalhos as $trabalho)
                        @if($trabalho->status == 'aprovado')
                        <tr>
                            <td>{{$cont}}</td>
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
                        @php $cont+=1;@endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <br>
        <div class="col-sm-12">
            <h4 class="titulo-table" style="text-align: center">Projetos não recomendados</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            <table class="table table-bordered" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
                <thead>
                <tr>
                    <th scope="col">Posição</th>
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
                @php $cont=1;@endphp
                    @foreach($trabalhos as $trabalho)
                        @if($trabalho->status == 'reprovado')
                        <tr>
                            <td>{{$cont}}</td>
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
                        @php $cont+=1;@endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <!-- TODOS OS PROJETOS SUBMETIDOS -->
        <br>
        <div class="col-sm-12">
            <h4 class="titulo-table" style="text-align: center">Projetos Submetidos</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
            <table class="table table-bordered" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
                <thead>
                <tr>
                    <th scope="col">Posição</th>
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
                @php $cont=1;@endphp
                    @foreach($trabalhos as $trabalho)
                        @if($trabalho->status == 'submetido' || $trabalho->status == 'avaliado')
                        <tr>
                            <td>{{$cont}}</td>
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
                        @php $cont+=1;@endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div>
{{--Janelas--}}
@foreach($trabalhos as $trabalho)
    <div class="modal fade" id="modalConfirmTrab{{$trabalho->id}}" tabindex="-1" role="dialog"
         aria-labelledby="modalConfirmLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                            <div class="col-sm-7" style="padding-left: 0px">
                                <p style="font-size: 22px">Discente: {{$participante->user->name}}</p>
                            </div>
                            <div class="col-sm-5 text-right" style="padding-right: 0px">
                                <form id="alteracao_bolsa{{$participante->id}}" method="POST" action="{{route('bolsa.alterar')}}">
                                    @csrf
                                    <input type="hidden" id="participante_{{$participante->id}}" name="id" value="{{$participante->id}}">
                                    <input type="radio" id="bolsista{{$participante->id}}" name="tipo" value="Bolsista" required @if($participante->tipoBolsa=='Bolsista') checked @endif> Bolsista
                                    <input type="radio" id="voluntario{{$participante->id}}" name="tipo" value="Voluntario" required @if($participante->tipoBolsa=='Voluntario') checked @endif> Voluntario

                                    <button type="submit" class="btn btn-primary" form="alteracao_bolsa{{$participante->id}}">Definir</button>
                                </form>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
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