<div class="modal fade" id="modal-tipo-substituicao-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="modalTipoSubLabel{{$id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="overflow-x:auto">
                <h5 class="modal-title" id="modalTipoSubLabel{{$id}}" style="color:#1492E6">Tipo de substituição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4" style="text-align: center; margin-left: 45px;">
                        <button style="width:220px;" type="button" class="btn btn-info" onclick="substituirPlano({{$id}})">
                            Substituir Plano de Trabalho
                        </button>
                    </div>
                    <div class="col-4" style="margin:auto">
                        <button style="float: left; width:220px;" type="button" class="btn btn-info" onclick="substituirDiscente({{$id}})">
                            Substituir Ambos
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function substituirDiscente(discenteId) {
        $("#modal-tipo-substituicao-" + discenteId).modal('hide');
        setTimeout(() => {
            $("#modal-substituicao-completa-" + discenteId).modal();
        }, 500);
    }

    function substituirPlano(discenteId) {
        $("#modal-tipo-substituicao-" + discenteId).modal('hide');
        setTimeout(() => {
            $("#modalSubParticipantePlano" + discenteId).modal();
        }, 500);
    }
</script>