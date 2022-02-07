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
                        <h4 class="card-title" style= "color:#1492E6">
                            Substituir Participante
                        </h4>
                        <h5 style= "color:grey; font-size:medium">{{$edital->nome}}: {{$projeto->titulo}}</h5>
                    </div>
                    <div class="card-body">
                        <h4>Formação Atual</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <h5 class="card-title" style= "color:#1492E6">
                                    Nome/Período
                                </h5>
                            </div>
                            <div class="card-body">
                            @foreach($participantes as $participante)
                                    <div class="row"style="margin-bottom: 20px;">
                                        <div class="col-10">
                                            <h4 style="font-size:20px">{{$participante->user->name}}</h4>
                                            <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($participante->data_entrada))}} - Atualmente</h5>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <div class="row justify-content-around">
                                                <a href="" data-toggle="modal" data-target="#modalTestSubParticipante{{$participante->id}}" class="button"
                                                   @if(($substituicoesProjeto->first() != null) && ($substituicoesProjeto->first()->status == 'Em Aguardo')) style="pointer-events: none; cursor: default;" @endif>
                                                    <i class="fas fa-exchange-alt fa-2x"></i></a>
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button"><i class="far fa-eye fa-2x"></i></a>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Modal TESTE substituir participante -->
                                    <div class="modal fade" id="modalTestSubParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Tipo de substituição</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <button  style="float: right; width:220px;" type="button" id="btnSubmitDiscente" class="btn btn-info" onclick="subsDiscenteDados({{$participante->id}})">
                                                                Substituir Participante
                                                            </button>
                                                        </div>
                                                        <div class="col-4" style="text-align: center">
                                                            <button style=" width:220px;" type="button" id="btnSubmitManter" class="btn btn-info" onclick="subsDiscentePlano({{$participante->id}})">
                                                                Substituir Plano de Trabalho
                                                            </button>
                                                        </div>
                                                        <div class="col-4">
                                                            <button style="float: left; width:220px;" type="button" id="btnSubmitCompleto" class="btn btn-info" onclick="subsDiscenteCompleto({{$participante->id}})">
                                                                Substituir Ambos
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelar">
                                                        Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal substituir participante Completo -->
                                    <div class="modal fade" id="modalSubParticipanteCompleto{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipanteCompletoForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal substituir participante Dados -->
                                    <div class="modal fade" id="modalSubParticipanteDado{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipanteDadoDiscenteForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal substituir participante Plano -->
                                    <div class="modal fade" id="modalSubParticipantePlano{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Novo Plano</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body px-1">
                                                    @include('administrador.substituirParticipantePlanoForm')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal visualizar informações participante -->
                                    <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    @include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <h4 style="margin-top: 50px">Substituições</h4>
                        <div style="margin-top: 20px">
                            <div class="card-header">
                                <div class="row">
                                        <div class="col-3">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Participante Substituído
                                            </h5>
                                        </div>
                                        <div class="col-3">
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
                                        <div class="col-2">
                                            <h5 class="card-title" style= "color:#1492E6">
                                                Justificativa
                                            </h5>
                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($substituicoesProjeto as $subs)
                                    <div class="row"style="margin-bottom: 20px;">
                                            <div class="col-3">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituido()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituido()->withTrashed()->first()->data_saida))}} @endif</h5>
                                            </div>
                                            <div class="col-3">
                                                <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" class="button"><h4 style="font-size:18px">{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}</h4></a>
                                                <h5 style= "color:grey; font-size:medium">{{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_entrada))}} - @if($subs->participanteSubstituto()->withTrashed()->first()->data_saida == null) Atualmente @else {{date('d-m-Y', strtotime($subs->participanteSubstituto()->withTrashed()->first()->data_saida))}} @endif</h5>
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
                                                    <a href="" data-toggle="modal" data-target="#modalVizuJustificativa{{$subs->id}}" class="button"><h4 style="font-size:18px">Visualizar</h4></a>
                                                @endif
                                            </div>
                                    </div>

                                    <!-- Modal vizualizar justificativa -->
                                    <div class="modal fade" id="modalVizuJustificativa{{$subs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" style="overflow-x:auto">
                                                    <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Justificativa</h5>
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
    $(document).ready(function(){
        $('input.cep:text').mask('00000-000');
        $('input.cpf:text').mask('000.000.000-00');
        $('input.celular').mask('(00) 00000-0000');
        $('input.rg:text').mask('00.000.000-0');

        $('input').on("input", function(){
            var maxlength = $(this).attr("maxlength");
            var currentLength = $(this).val().length;
            var idInput = $(this).attr("id");
            if( currentLength >= maxlength ){
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }else if(currentLength == 0){
                $("#caracsRestantes"+idInput).html("");
            }else{
                $("#caracsRestantes"+idInput).html("Caracteres restantes: " + (maxlength - this.value.length));
            }
        });

        $("input.pdf").on("change", function () {
            if(this.files[0].type.split('/')[1] == "pdf") {
                if(this.files[0].size > 20000000){
                    alert("O arquivo possui o tamanho superior a 2MB!");
                    $(this).val('');
                }
            }else{
                alert("O arquivo não é de tipo PDF!");
                $(this).val('');
            }
        });

        $("input[name='anexoComprovanteBancario']").on("change", function () {
            if(this.files[0].type.split('/')[1] == "pdf"
            || this.files[0].type.split('/')[1] == "jpeg"
            || this.files[0].type.split('/')[1] == "jpg"
            || this.files[0].type.split('/')[1] == "png") {
                if(this.files[0].size > 20000000){
                    alert("O arquivo possui o tamanho superior a 2MB!");
                    $(this).val('');
                }
            }else{
                alert("O arquivo não é do tipo Correto!");
                $(this).val('');
            }
        });
    });

    function manterPlano(checkBox){
        var checkboxInput = checkBox;
        var idParticipante = checkboxInput.id;
        var tituloPlano = document.getElementById('nomePlanoTrabalho'+idParticipante);
        var anexoPlano = document.getElementById('anexoPlanoTrabalho'+idParticipante);
        var planoAtual =<?php echo json_encode($participantes->first()->planoTrabalho) ?>;
        var arquivo = document.getElementById('arquivo'+idParticipante);

        if(checkboxInput.checked){
            tituloPlano.setAttribute('value', planoAtual.titulo);
            tituloPlano.setAttribute('disabled', 'disabled');
            tituloPlano.removeAttribute('required');

            anexoPlano.setAttribute('disabled', 'disabled');
            anexoPlano.removeAttribute('required');

            document.getElementById("arqParticipantes").hidden=true;
            document.getElementById("arqAtual").hidden=false;

            arquivo.href = "/baixar/plano-de-trabalho/"+planoAtual.id;
        }else if(!checkboxInput.checked){
            tituloPlano.setAttribute('value','');
            tituloPlano.removeAttribute('disabled');
            tituloPlano.setAttribute('required', 'required');

            anexoPlano.removeAttribute('disabled');
            anexoPlano.setAttribute('required', 'required');

            document.getElementById("arqParticipantes").hidden=false;
            document.getElementById("arqAtual").hidden=true;
        }
    }

    function substituirApenasPlano(checkBox){
        var checkboxInput = checkBox;
        var checkBoxId = checkboxInput.id;
        var idParticipante = checkBoxId.slice(11);
        var inputsForm = [];

        inputsForm.push(document.getElementById('nome'+idParticipante));
        inputsForm.push(document.getElementById('email'+idParticipante));
        inputsForm.push(document.getElementById('nascimento'+idParticipante));
        inputsForm.push(document.getElementById('dt_entrada'+idParticipante));
        inputsForm.push(document.getElementById('cpf'+idParticipante));
        inputsForm.push(document.getElementById('rg'+idParticipante));
        inputsForm.push(document.getElementById('cep'+idParticipante));
        inputsForm.push(document.getElementById('celular'+idParticipante));
        inputsForm.push(document.getElementById('linkLattes'+idParticipante));
        inputsForm.push(document.getElementById('estado'+idParticipante));
        inputsForm.push(document.getElementById('cidade'+idParticipante));
        inputsForm.push(document.getElementById('bairro'+idParticipante));
        inputsForm.push(document.getElementById('rua'+idParticipante));
        inputsForm.push(document.getElementById('numero'+idParticipante));

        var complementoInput = document.getElementById('complemento'+idParticipante);
        inputsForm.push(complementoInput);

        inputsForm.push(document.getElementById('instituicao['+idParticipante+']'));

        var outraInstituicaoInput = document.getElementById('outrainstituicao['+idParticipante+']');
        inputsForm.push(outraInstituicaoInput);

        inputsForm.push(document.getElementById('curso['+idParticipante+']'));

        var outroCursoInput = document.getElementById('outrocurso['+idParticipante+']');
        inputsForm.push(outroCursoInput);

        inputsForm.push(document.getElementById('turno'+idParticipante));
        inputsForm.push(document.getElementById('periodosTotal'+idParticipante));
        inputsForm.push(document.getElementById('periodo'+idParticipante));
        inputsForm.push(document.getElementById('ordem'+idParticipante));
        inputsForm.push(document.getElementById('media'+idParticipante));

        inputsForm.push(document.getElementById('anexoTermoCompromisso'+idParticipante));
        inputsForm.push(document.getElementById('anexoComprovanteMatricula'+idParticipante));
        inputsForm.push(document.getElementById('anexoCurriculoLattes'+idParticipante));
        inputsForm.push(document.getElementById('anexoAutorizacaoPais'+idParticipante));
        inputsForm.push(document.getElementById('anexoComprovanteBancario'+idParticipante));

        if(checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.setAttribute('disabled', 'disabled');
                item.removeAttribute('required');
            });
        }else if(!checkboxInput.checked){
            inputsForm.forEach(function(item,indice,array){
                item.removeAttribute('disabled');
                item.setAttribute('required', 'required');
            });

            complementoInput.removeAttribute('required');
            outraInstituicaoInput.removeAttribute('required');
            outroCursoInput.removeAttribute('required');
        }
    }

    function showInstituicao(instituicao){
        var instituicaoSelect = instituicao;
        var idSelect = instituicaoSelect.id;
        var instituicao = document.getElementById('outra'+idSelect);
        var display = document.getElementById('display'+idSelect);

        if(instituicaoSelect.value === "Outra"){
            display.style.display = "block";
            instituicao.parentElement.style.display = '';
            instituicao.value="";
        }else if(instituicaoSelect.value === "UFAPE"){
            display.style.display = "none";
        }
    }

    function showCurso(curso){
        var cursoSelect = curso;
        var idSelect = cursoSelect.id;
        var curso = document.getElementById('outro'+idSelect);
        var displayCurso = document.getElementById('display'+idSelect);

        if(cursoSelect.value === "Outro"){
            displayCurso.style.display = "block";
            curso.parentElement.style.display = '';
            curso.value="";
        }else{
            displayCurso.style.display = "none";
        }
    }

    function gerarPeriodo(e){
        var select = e.parentElement.parentElement.nextElementSibling;
        selectPeriodos = select.children[0].children[1];
        var html = `<option value="" disabled selected>-- TOTAL DE PERIODOS --</option>`;
        for(var i = 0; i < parseInt(e.value); i++) {
        html += `<option value="${i+1}">${i+1}º</option>`;
        }
        $(selectPeriodos).html('');
        $(selectPeriodos).append(html);

    }

    function subsDiscenteCompleto(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipanteCompleto"+discenteId).modal(); }, 500);
    }
    function subsDiscenteDados(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipanteDado"+discenteId).modal(); }, 500);
    }
    function subsDiscentePlano(discenteId){
        $("#modalTestSubParticipante"+discenteId).modal('hide');
        setTimeout(() => {  $("#modalSubParticipantePlano"+discenteId).modal(); }, 500);
    }
</script>
@endsection