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
                    <th scope="col" style="width: 100%;">Nome do projeto</th>
                    <th scope="col">Proponente</th>
                    <th scope="col">Área</th>
                    <th scope="col">N. Planos</th>
                    <th scope="col">Avaliador Externo</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody id="projetos">
                    @foreach($trabalhos as $trabalho)
                        <tr>
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
                                    {{$trabalho->avaliadors->first()->user->name}}
                                @endif
                            </td>
                            @if($trabalho->avaliadors->count() > 0)
                                <td>
                                    {{$trabalho->avaliadors->first()->pivot->recomendacao}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
</div>

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
</script>
@endsection