<div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
        <div class="card-body" style="padding-top: 0.2rem;">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-11">
                        <h5 style="color: #234B8B; font-weight: bold">Adicionar Integrante(s)</h5>
                    </div>
                    
                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="{{ $edital->id }}" id="atribuir1" data-toggle="modal" data-target="#modalIntegrante">
                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                        </a>
                    </div>
                </div>
                <hr style="border-top: 1px solid#1492E6">  
                <div class="row" id="integrante">
                </div>
            </div>
        </div>    
    </div>    
</div>



<!-- MODAL -->
<div class="modal fade" id="modalIntegrante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Integrante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="form-row" style="padding: 30px;">
                <div class="col-md-8">
                    <label for="cpf_consulta">CPF:</label>
                    <input type="text" id="cpf_consulta" name="cpf_consulta" class="form-control" onkeyup="mask_cpf();">
                </div>
                <div class="col-md-4 mt-4">
                    <button type="button" class="btn btn-primary" onclick="preencherUsuarioExistente()">Adicionar</button>
                </div>
            </div>
        
            <div class="form-row" style="padding: 0px 30px 30px 30px;">
                <label for="funcao_participante">Função do Participante:</label>
                <select name="" id="funcao_participante" class="form-control">
                    @foreach($funcaoParticipantes as $funcao)
                        <option value="{{$funcao->id}}">{{ $funcao->nome }}</option>
                    @endforeach
                </select>
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
            <div class="modal-body">
                CPF não consta no sistema!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
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
            if(data == 'inexistente' || $('#cpf_consulta').val() == ""){
                exibirModalUsuarioInexistente();
            }else {
                exibirUsuarioAdicionado();
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

    function exibirUsuarioAdicionado() {
        $('#aviso-modal-usuario-adicionado').modal('show');;
    }

</script>