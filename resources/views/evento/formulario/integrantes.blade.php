<div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
        <div class="card-body" style="padding-top: 0.2rem;">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-11">
                        <h5 style="color: #234B8B; font-weight: bold">Adicionar Integrante(s)</h5>
                    </div>

                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="{{ $edital->id }}" id="atribuir1" data-toggle="modal"
                           data-target="#modalIntegrante">
                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                        </a>
                    </div>
                </div>
                <hr style="border-top: 1px solid#1492E6">
                <!-- <h6 style="color: #234B8B; font-weight: bold;">Integrantes</h6> -->
                <div class="row" id="integrante" style="display:none">
                </div>
                @include('evento.formulario.participantes')

            </div>
        </div>
    </div>
</div>


<!-- MODAL -->
<div class="modal fade" id="modalIntegrante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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

                    <div class="form-controll"
                         style="margin-left:10px; margin-top:10px; margin-bottom:15px; font-weight:bold;">

                        <div class="form-row d-flex">
                            <label for="cpf_consulta">CPF:</label>
                            <input type="text" id="cpf_consulta" name="cpf_consulta" class="form-control">
                        </div>

                        <div class="form-row d-flex" style="margin-top:10px">
                            <label for="funcao_participante">Função do Integrante:</label>
                            <select name="" id="funcao_participante" class="form-control">
                                @foreach($funcaoParticipantes as $funcao)
                                    <!-- EXTENSÃO -->
                                    @if($edital->natureza_id == 3 && ($edital->tipo == "CONTINUO" || $edital->tipo == "CONTINUO-AC")) 
                                        @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador")
                                            <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                        @endif
                                    @elseif($edital->natureza_id == 3 && ($edital->tipo == "PIBEX" || $edital->tipo == "PIACEX" || $edital->tipo == "PIBAC"))
                                        @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador" || $funcao->nome == "Bolsista")
                                            <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                        @endif
                                    <!-- PESQUISA -->
                                    @else
                                        @if($funcao->nome == "Bolsista" || $funcao->nome == "Voluntário")
                                            <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row justify-content-center" style="margin-top:20px;">
                            <button type="button" class="btn btn-primary" onclick="preencherUsuarioExistente()">
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- MODAL DE ERRO -->
<div class="modal fade" id="aviso-modal-usuario-nao-existe" data-backdrop="static" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                CPF não consta no sistema!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="aviso-modal-usuario-adicionado" data-backdrop="static" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="aviso-modal-limite-de-integrantes" data-backdrop="static" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="texto-erro">O limite de integrantes para esse projeto foi atingido.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#cpf_consulta").mask("999.999.999-99");
    });

    function removerIntegrante(id) {
        $(`#integrante${id}`).remove()
    }

    function preencherUsuarioExistente() {
        if (!document.getElementById(`exampleModal${modal_id}`)) {
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
                if (data == 'inexistente' || $('#cpf_consulta').val() == "") {
                    exibirModalUsuarioInexistente();
                } else {
                    if ($('#funcao_participante').val() != 4 || data[0].tipo == 'participante') {
                        exibirUsuarioAdicionado(data);
                    } else {
                        marcar(modal_id, data);
                        exibirProfessorAdicionado();

                    }
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

    let modal_id = Number(document.getElementById('quantidadeModais').value);

    function formatarData(data) {
        if (!data) {
            return '';
        }
        let partes = data.split('-');
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }

    function exibirUsuarioAdicionado(data) {

        $('#modalIntegrante').modal('hide');
        document.getElementById(`nome${modal_id}`).value = data[0]['name'];
        document.getElementById(`nome${modal_id}`).setAttribute("readonly", "");

        document.getElementById(`email${modal_id}`).value = data[0]['email'];
        document.getElementById(`email${modal_id}`).setAttribute("readonly", "");

        if (data[0]['tipo'] == "participante") {
            //let [y, m, d] = data[2]['data_de_nascimento'].split('-');
            //document.getElementById(`data_de_nascimento${modal_id}`).value = (new Date(y, m - 1, d)).toLocaleDateString();
            document.getElementById(`data_de_nascimento${modal_id}`).value = formatarData(data[2]['data_de_nascimento']);
            document.getElementById(`data_de_nascimento${modal_id}`).setAttribute("readonly", "");
        } else {

            document.getElementById(`data_de_nascimento${modal_id}`).value = null;
            document.getElementById(`data_de_nascimento${modal_id}`).setAttribute("readonly", "");
        }

        document.getElementById(`cpf${modal_id}`).value = data[0]['cpf'];
        document.getElementById(`cpf${modal_id}`).setAttribute("readonly", "");

        if (data?.[2]?.rg) {
            document.getElementById(`rg${modal_id}`).value = data[2]['rg'];
            document.getElementById(`rg${modal_id}`).setAttribute("readonly", "");
        }

        if (data?.[0]?.celular) {
            document.getElementById(`celular${modal_id}`).value = data[0]['celular'];
            document.getElementById(`celular${modal_id}`).setAttribute("readonly", "");
        }

        if (data[3] != null) {
            document.getElementById(`cep${modal_id}`).value = data[3].cep;
            document.getElementById(`cep${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`uf${modal_id}`).value = data[3].uf;
            document.getElementById(`uf${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`cidade${modal_id}`).value = data[3].cidade;
            document.getElementById(`cidade${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`bairro${modal_id}`).value = data[3].bairro;
            document.getElementById(`bairro${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`rua${modal_id}`).value = data[3].rua;
            document.getElementById(`rua${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`numero${modal_id}`).value = data[3].numero;
            document.getElementById(`numero${modal_id}`).setAttribute("readonly", "");

            document.getElementById(`complemento${modal_id}`).value = data[3].complemento;
            document.getElementById(`complemento${modal_id}`).setAttribute("readonly", "");    
        }
        
        document.getElementById(`instituicao[${modal_id}]`).value = data[0].instituicao;
        document.getElementById(`instituicao[${modal_id}]`).setAttribute("readonly", "");

        document.getElementById(`curso[${modal_id}]`).value = data[2].curso;
        document.getElementById(`curso[${modal_id}]`).setAttribute("readonly", "");

        document.getElementById(`funcaoParticipante${modal_id}`).value = data[1]['nome'];

        if (data[1].nome != "Bolsista" && data[1].nome != "Voluntário") {
            document.getElementById(`plano-titulo${modal_id}`).setAttribute('hidden', "");
            document.getElementById(`plano-nome${modal_id}`).setAttribute('hidden', "");
            document.getElementById(`plano-anexo${modal_id}`).setAttribute('hidden', "");
        }

        $(`#exampleModal${modal_id}`).modal('show');
    }

    function exibirProfessorAdicionado() {
        $('#modalIntegrante').modal('hide');
        $(`#aviso-modal-usuario-adicionado`).modal('show');
    }

</script>