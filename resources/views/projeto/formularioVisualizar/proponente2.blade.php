<!-- Proponente -->
<div class="col-md-12" style="margin-top: 20px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Informações do Proponente</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6">
        <div class="form-row mt-3">
          <div class="col-md-12">
            <p style="color: #4D4D4D; padding: 0px"><b>Nome:</b> {{ App\Proponente::find($projeto->proponente_id)->user->name }}</p>
          </div>
          <div class="col-md-12">
            <b style="color: #4D4D4D;">Lattes:</b>
            @if(App\Proponente::where('id', $projeto->proponente_id)->first()->linkLattes != null)
              <a style="color: #4D4D4D;" href="{{ App\Proponente::where('id', $projeto->proponente_id)->first()->linkLattes }}"
                 target="_blank"
              >{{ App\Proponente::where('id', $projeto->proponente_id)->first()->linkLattes }}</a>
            @endif
          </div>

          <div class="col-md-12">
            <br>
            <b style="color: #4D4D4D;">Grupo de Pesquisa: </b>
            <a style="color: #4D4D4D;" href="{{ $projeto->linkGrupoPesquisa }}"
               target="_blank"
            >{{ $projeto->linkGrupoPesquisa }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--X Proponente X-->