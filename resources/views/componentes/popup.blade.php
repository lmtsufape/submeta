

<div class="modal" tabindex="-1" role="dialog" id="{{$id}}" style="color:black">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <strong>{{$titulo}}</strong> </h5>
        </button>
      </div>
      <div class="modal-body" id="modalBody">
        {{$conteudo}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
{{-- @component('componentes.popup', [
                                  "titulo"=>"Informações:", 
                                  "conteudo"=>$requisicao_documento['detalhes'],
                                  "id"=>$requisicao_documento['id']
                                ])
@endcomponent    --}}