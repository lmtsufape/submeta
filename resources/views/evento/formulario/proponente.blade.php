<!-- Proponente -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">2º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do proponente</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px">
    <div class="card-body">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do proponente</h5></div>
          <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

          <div class="form-group col-md-12" style="margin-top: 15px">
            <label for="nomeCompletoProponente1">Proponente</label>
            <input class="form-control" type="text" id="nomeCompletoProponente1" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
          
          </div>

          <div class="form-group col-md-6">
            <label for="linkLattesEstudante">Link do currículo Lattes<span style="color: red; font-weight:bold">*</span></label>
            <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante" 
            @if(Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null)
              value="{{ Auth()->user()->proponentes->linkLattes }}"
            @else
            value=""
            @endif required >
            <small>Ex.: http://lattes.cnpq.br/8363536830656923</small>
            @error('linkLattesEstudante')
            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          
          <div class="form-group col-md-6">
            <label for="linkGrupo">Link do grupo de pesquisa<span style="color: red; font-weight:bold">*</span></label>
            <input class="form-control @error('linkGrupo') is-invalid @enderror" type="url" name="linkGrupo"
                    value="{{old('linkGrupo') !== null ? old('linkGrupo') : (isset($rascunho) ? $rascunho->linkGrupoPesquisa : '')}}" required>

            <small>Ex.: http://dgp.cnpq.br/dgp/espelhogrupo/228363</small>
            @error('linkGrupo')
            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label for="pontuacaoPlanilha">Valor da planilha de pontuação <span style="color: red; font-weight:bold">*</span></label>
            <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha"
                    value="{{old('pontuacaoPlanilha') !== null ? old('pontuacaoPlanilha') : (isset($rascunho) ? $rascunho->pontuacaoPlanilha : '')}}" required>

            @error('pontuacaoPlanilha')
            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          
        </div>
    </div>
    </div>
  </div>
</div>
<!--X Proponente X-->