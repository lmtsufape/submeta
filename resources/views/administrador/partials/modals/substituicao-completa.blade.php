<div class="modal fade" id="modal-substituicao-completa-{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="modalSubCompletoLabel{{$participante->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="overflow-x:auto">
                <h5 class="modal-title w-100 text-center" id="modalSubCompletoLabel{{$participante->id}}" style="color:#1492E6">Novo Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-1">
                <div class="container">
                    <div class="row justify-content-center" style="padding-left:35px; padding-right:45px">
                        <div class="form-controll w-100" style="margin-left:10px; margin-top:10px; margin-bottom:15px; font-weight:bold;">

                            <div class="form-group w-100" style="margin-top:10px; position:relative;">
                                <label for="cpf_consulta{{$participante->id}}">CPF:</label>
                                <input
                                        type="text"
                                        id="cpf_consulta{{$participante->id}}"
                                        name="cpf"
                                        class="form-control"
                                        maxlength="14"
                                        onkeyup="buscarCpf({{$participante->id}})"
                                >
                                <div
                                        id="resultadoCpf{{$participante->id}}"
                                        class="list-group"
                                        style="position:absolute; top:100%; z-index:1000; width:100%;"
                                ></div>
                            </div>

                            <div class="form-group w-100" style="margin-top:10px">
                                <label for="funcao_participante{{$participante->id}}">Função do Integrante:</label>
                                <select name="" id="funcao_participante{{$participante->id}}" class="form-control">
                                    @foreach($funcaoParticipantes as $funcao)
                                        @if($edital->natureza_id == 3 && ($edital->tipo == "CONTINUO" || $edital->tipo == "CONTINUO-AC"))
                                            @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador")
                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                            @endif
                                        @elseif($edital->natureza_id == 3 && ($edital->tipo == "PIBEX" || $edital->tipo == "PIBAC"))
                                            @if($funcao->nome == "Vice-coordenador" || $funcao->nome == "Colaborador" || $funcao->nome == "Bolsista")
                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                            @endif
                                        @else
                                            @if($funcao->nome == "Bolsista" || $funcao->nome == "Voluntário")
                                                <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-row justify-content-center" style="margin-top:20px;">
                                <button type="button" class="btn btn-primary" onclick="preencherFormUsuario({{$participante->id}})">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    function preencherFormUsuario(integranteAntigoId) {
        if (!document.getElementById(`exampleModal${integranteAntigoId}`)) {
            exibirModalNumeroMaximoDeIntegrantes();
            return;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let cpf = $(`#cpf_consulta${integranteAntigoId}`).val();

        $.ajax({
            url: "{{ route('trabalho.buscarUsuario') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                'cpf_consulta': cpf,
                'funcao': $(`#funcao_participante${integranteAntigoId}`).val()
            },

            success: function (data) {
                if (data === 'inexistente' ) {
                    $('#modal-cpf-nao-encontrado').modal('show');
                } else {
                    if ($(`#funcao_participante${integranteAntigoId}`).val() !== 4 || user.tipo === 'participante') {
                        exibirUsuarioSubstituto(data, integranteAntigoId);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log('STATUS:', status);
                console.log('ERROR:', error);
                console.log('RESPONSE:', xhr.responseText);
            },
        });

        // if (document.getElementById('check')) {//QUE CHECK BOX E ESSEEEEEEEEEEEEEEEEEEEEEEEE
        //     tituloPlano.setAttribute('value', planoAtual.titulo);
        //     tituloPlano.setAttribute('disabled', 'disabled');
        //     tituloPlano.removeAttribute('required');
        //
        //     anexoPlano.setAttribute('disabled', 'disabled');
        //     anexoPlano.removeAttribute('required');
        //
        //     document.getElementById("arqParticipantes").hidden = true;
        //     document.getElementById("arqAtual").hidden = false;
        //
        //     arquivo.href = "/baixar/plano-de-trabalho/" + planoAtual.id;
        // } else if (!checkboxInput.checked) {
        //     tituloPlano.setAttribute('value', '');
        //     tituloPlano.removeAttribute('disabled');
        //     tituloPlano.setAttribute('required', 'required');
        //
        //     anexoPlano.removeAttribute('disabled');
        //     anexoPlano.setAttribute('required', 'required');
        //
        //     document.getElementById("arqParticipantes").hidden = false;
        //     document.getElementById("arqAtual").hidden = true;
        //}
    }
    
    function exibirUsuarioSubstituto(data, integranteAntigoId) {
        const user = data[0];
        const funcaoUsuario = data[1];
        const participante = data[2];
        const endereco = data[3];

        //$('#modalIntegrante').modal('hide'); nao imagino por que isso tava aqui

        $(`#modal-substituicao-completa-${integranteAntigoId}`).modal('hide');
        document.getElementById(`nome${integranteAntigoId}`).value = user['name'];
        document.getElementById(`nome${integranteAntigoId}`).setAttribute("readonly", "");

        document.getElementById(`email${integranteAntigoId}`).value = user['email'];
        document.getElementById(`email${integranteAntigoId}`).setAttribute("readonly", "");

        if (user['tipo'] === "participante") {

            if (participante === null) {
                exibirModalPerfilParticipanteIncompleto();
                return;
            }
            let [y, m, d] = participante['data_de_nascimento'].split('-');
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).value = (new Date(y, m - 1, d)).toLocaleDateString();
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).setAttribute("readonly", "");
        } else {

            document.getElementById(`data_de_nascimento${integranteAntigoId}`).value = null;
            document.getElementById(`data_de_nascimento${integranteAntigoId}`).setAttribute("readonly", "");
        }
        document.getElementById(`cpf${integranteAntigoId}`).value = user['cpf'];
        document.getElementById(`cpf${integranteAntigoId}`).setAttribute("readonly", "");

        if (participante?.rg) {
            document.getElementById(`rg${integranteAntigoId}`).value = participante['rg'];
            document.getElementById(`rg${integranteAntigoId}`).setAttribute("readonly", "");
        }

        if (user?.celular) {
            document.getElementById(`celular${integranteAntigoId}`).value = user['celular'];
            document.getElementById(`celular${integranteAntigoId}`).setAttribute("readonly", "");
        }

        if (endereco != null) {
            document.getElementById(`cep${integranteAntigoId}`).value = endereco.cep;
            document.getElementById(`cep${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`uf${integranteAntigoId}`).value = endereco.uf;
            document.getElementById(`uf${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`cidade${integranteAntigoId}`).value = endereco.cidade;
            document.getElementById(`cidade${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`bairro${integranteAntigoId}`).value = endereco.bairro;
            document.getElementById(`bairro${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`rua${integranteAntigoId}`).value = endereco.rua;
            document.getElementById(`rua${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`numero${integranteAntigoId}`).value = endereco.numero;
            document.getElementById(`numero${integranteAntigoId}`).setAttribute("readonly", "");

            document.getElementById(`complemento${integranteAntigoId}`).value = endereco.complemento;
            document.getElementById(`complemento${integranteAntigoId}`).setAttribute("readonly", "");
        }

        document.getElementById(`instituicao${integranteAntigoId}`).value = user.instituicao;
        document.getElementById(`instituicao${integranteAntigoId}`).setAttribute("readonly", "");

        document.getElementById(`curso${integranteAntigoId}`).value = participante.curso;
        document.getElementById(`curso${integranteAntigoId}`).setAttribute("readonly", "");


        //document.getElementById(`funcaoParticipante${modal_id}`).value = funcaoUsuario['nome'];

        if (funcaoUsuario.nome !== "Bolsista" && funcaoUsuario.nome !== "Voluntário") {//???????????????????????????
            document.getElementById(`plano-titulo${integranteAntigoId}`).setAttribute('hidden', "");
            document.getElementById(`plano-nome${integranteAntigoId}`).setAttribute('hidden', "");
            document.getElementById(`plano-anexo${integranteAntigoId}`).setAttribute('hidden', "");
        } else {
            document.getElementById(`plano-titulo${integranteAntigoId}`).removeAttribute('hidden');
            document.getElementById(`plano-nome${integranteAntigoId}`).removeAttribute('hidden');
            document.getElementById(`plano-anexo${integranteAntigoId}`).removeAttribute('hidden');
        }

        document.getElementById(`novoParticianteId${integranteAntigoId}`).value = user.id;

        $(`#exampleModal${integranteAntigoId}`).modal('show');
    }

    // func para mostrar cpf enquanto digita
    function buscarCpf(participanteId) {

        let cpf = $("#cpf_consulta" + participanteId).val().replace(/\D/g, '');

        if (cpf.length < 1) {
            $("#resultadoCpf" + participanteId).html('');
            return;
        }

        $.ajax({
            url: "/buscar-cpf",
            type: "GET",
            data: {
                cpf: cpf,
                excludeId: participanteId
            },

            success: function (response) {

                let html = '';
                let user = response;
                if(user !== null){
                    let name = user.name.length > 60 ? user.name.substring(0, 60) + '...' : user.name;
                    html += `
                    <button
                        type="button"
                        class="list-group-item list-group-item-action"
                        onclick="selecionarCpf('${user.cpf}', ${participanteId})"
                    >
                    ${name} - ${aplicarMascaraCpf(user.cpf)}
                    </button>
                `;
                }


                $("#resultadoCpf" + participanteId).html(html);
            }
        });
    }
    //selecionar e preencher cpf encontrado
    function selecionarCpf(cpf, participanteId) {

        $("#cpf_consulta" + participanteId).val(aplicarMascaraCpf(cpf));

        $("#resultadoCpf" + participanteId).html('');
    }

    function exibirModalPerfilParticipanteIncompleto() {
        $('#modal-perfil-participante-incompleto').modal('show');
    }

    

    function aplicarMascaraCpf(valor) {

        valor = valor.replace(/\D/g, '');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

        return valor;
    }

    $(document).on('input', '[id^="cpf_consulta"]', function () {
        this.value = aplicarMascaraCpf(this.value);
    });
</script>