<div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
        <div class="card-body" style="padding-top: 0.2rem;">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-11">
                        <h5 style="color: #234B8B; font-weight: bold">Integrante(s)</h5>
                    </div>
                    
                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="{{ $edital->id }}" id="atribuir1" data-toggle="modal" data-target="#modalIntegrante">
                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                        </a>
                    </div>
                </div>
                <hr style="border-top: 1px solid#1492E6">  
                <div class="row" id="integrante" style="display:none">
                </div>
                @include('projeto.editaFormulario.participantes')
            </div>
        </div>    
    </div>    
</div>

<div class="modal fade" id="modalIntegrante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="container">
                <div class="row justify-content-center" style="padding-left:35px; padding-right:45px">

                    <div class="form-controll" style="margin-left:10px; margin-top:10px; margin-bottom:15px; font-weight:bold;">

                        <div class="form-row d-flex">
                            <label for="cpf_consulta">CPF:</label>
                            <input type="text" id="cpf_consulta" name="cpf_consulta" class="form-control" onkeyup="mask_cpf();">
                        </div>

                        <div class="form-row d-flex" style="margin-top:10px">
                            <label for="funcao_participante">Função do Integrante:</label>
                            <select name="" id="funcao_participante" class="form-control">
                                @foreach($funcaoParticipantes as $funcao)
                                    @if($funcao->nome != 'Bolsista')
                                        <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                    @elseif($edital->tipo != "CONTINUO")
                                        <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row justify-content-center" style="margin-top:20px;">
                            <button type="button" class="btn btn-primary" onclick="preencherUsuarioExistente()">Adicionar</button>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="aviso-modal-usuario-adicionado" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #32CD32;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Sucesso!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                Integrante adicionado com sucesso
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE ERRO -->
<div class="modal fade" id="aviso-modal-usuario-nao-existe" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" >
                <span id="texto-erro">CPF não consta no sistema!</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="aviso-modal-limite-de-integrantes" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" >
                <span id="texto-erro">O limite de integrantes para esse projeto foi atingido.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>



<script>
    function mask_cpf() {
        $("#cpf_consulta").keydown(function(){
            try {
                $("#cpf_consulta").unmask();
            } catch (e) {}

            $("#cpf_consulta").mask("999.999.999-99");
            
            // ajustando foco
            var elem = this;
            setTimeout(function(){
                // mudo a posição do seletor
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            // reaplico o valor para mudar o foco
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
        });
    }

    function removerIntegrante(id) {
        $(`#integrante${id}`).remove()
    }

    function preencherUsuarioExistente() {
        //console.log(modal_id);
        if(!document.getElementById(`exampleModal${modal_id}`)){
            exibirModalNumeroMaximoDeIntegrantes();
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: '{{ route('trabalho.buscarUsuario') }}', 
        type: 'POST',
        dataType: 'json',
        data: {
            'cpf_consulta': $('#cpf_consulta').val(),
            'funcao': $('#funcao_participante').val()
        }, 


        success: function (data) {
            // console.log(data)
            if(data == 'inexistente' || $('#cpf_consulta').val() == ""){
                $('#texto-erro').html('CPF não consta no sistema!');
                exibirModalUsuarioInexistente();
            }else {
                exibirUsuarioAdicionado(data);
                $('#integrante').append(`
                <div id="integrante${data[0]['id']}" class="col-md-6">
                    <div class="row">
                        <input name="integrantes[]" type="text" value="${data[0]['id']},${$('#funcao_participante').val()}" hidden>
                        <div class="col-md-2" style="display: flex; align-items: center;">
                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                        </div>
                        <div class="col-md-4 mb-1">
                            <strong>Nome:</strong> ${data[0]['name']}
                            <strong>CPF:</strong> ${data[0]['cpf']}
                            <strong>Função:</strong> ${data[1]['nome']}
                            <button type="button" class="btn btn-danger" onclick="removerIntegrante(${data[0]['id']})">Remover</button>
                        </div>
                    </div>
                </div>
                `)
            }
        }
        });

    }

    function exibirModalUsuarioInexistente() {
        $('#aviso-modal-usuario-nao-existe').modal('show');
    }

    function exibirModalNumeroMaximoDeIntegrantes() {
        $('#aviso-modal-limite-de-integrantes').modal('show');
    }

    let modal_id = 0;
   

    function exibirUsuarioAdicionado(data) {
        // console.log(`${modal_id}`, data);
        $('#modalIntegrante').modal('hide'); 
        document.getElementById(`nome${modal_id}`).value = data[0]['name'];
        document.getElementById(`nome${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`email${modal_id}`).value = data[0]['email'];
        document.getElementById(`email${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`data_de_nascimento${modal_id}`).value = (new Date(data[2]['data_de_nascimento'])).toLocaleDateString();
        document.getElementById(`data_de_nascimento${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`cpf${modal_id}`).value = data[0]['cpf'];
        document.getElementById(`cpf${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`rg${modal_id}`).value = data[2]['rg'];
        document.getElementById(`rg${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`celular${modal_id}`).value = data[0]['celular'];
        document.getElementById(`celular${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`cep${modal_id}`).value = data[3]['cep'];
        document.getElementById(`cep${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`uf${modal_id}`).value = data[3]['uf'];
        document.getElementById(`uf${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`cidade${modal_id}`).value = data[3]['cidade'];
        document.getElementById(`cidade${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`bairro${modal_id}`).value = data[3]['bairro'];
        document.getElementById(`bairro${modal_id}`).setAttribute("readonly", "");
        document.getElementById(`rua${modal_id}`).value = data[3]['rua'];
        document.getElementById(`rua${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`numero${modal_id}`).value = data[3]['numero'];
        document.getElementById(`numero${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`complemento${modal_id}`).value = data[3]['complemento'];
        document.getElementById(`complemento${modal_id}`).setAttribute("readonly", "");
        
        document.getElementById(`instituicao[${modal_id}]`).value = data[0]['instituicao'];
        document.getElementById(`instituicao[${modal_id}]`).setAttribute("readonly", "");
        document.getElementById(`curso[${modal_id}]`).value = data[2]['curso'];
        document.getElementById(`curso[${modal_id}]`).setAttribute("readonly", "");
        $(`#exampleModal${modal_id}`).modal('show');
    }

    $(document).ready(function() {
        
        @foreach($trabalhos_user as $trabalho_user)
        
        if(<?php echo json_encode($trabalho_user) ?>['funcao']){
            modal_id += 1;
        }

        $('#integrante').append(`
                <div id="integrante{{$trabalho_user->id}}" class="col-md-6">
                    <div class="row">
                        <input name="integrantesExistentes[]" type="text" value="{{ $trabalho_user->user->id }}" hidden>
                        <div class="col-md-2" style="display: flex; align-items: center;">
                            <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                        </div>
                        <div class="col-md-4 mb-1">
                            <strong>Nome:</strong> {{{$trabalho_user->user->name}}}
                            <strong>CPF:</strong> {{ $trabalho_user->user->cpf }}
                            <strong>Função:</strong> {{ $trabalho_user->funcao->nome }}
                            <button type="button" class="btn btn-danger" onclick="removerIntegrante({{$trabalho_user->id}})">Remover</button>
                        </div>
                    </div>
                </div>
            `)
    
        @endforeach
    });

</script>