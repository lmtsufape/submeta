<!-- Proponente -->
<div class="col-md-10" style="text-align: center; margin-top:2rem">
    <h4 style="margin-top: 1rem;">2º Passo</h4>
</div>
<div class="col-md-10" style="text-align: center;">
    <h5 style="margin-bottom:1rem;color:#909090">Preencha os campos com as informações do proponente</h5>
</div>
<div class="col-md-10">
    <div class="card" style="border-radius: 12px">
        <div class="card-body">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-12">
                        <h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do proponente</h5>
                    </div>
                    <div class="col-md-12" style="margin-bottom: -0.8rem;">
                        <hr style="border-top: 1px solid#1492E6">
                    </div>

                    <div class="form-group col-md-12" style="margin-top: 15px">
                        <label for="nomeCompletoProponente1">Proponente</label>
                        <input class="form-control" type="text" id="nomeCompletoProponente1" name="nomeCoordenador"
                            disabled="disabled" value="{{ $projeto->proponente->user->name }}">

                    </div>

                    <div class="form-group col-md-6">
                        <label for="linkLattesEstudante">Link do currículo Lattes<span
                                style="color: red; font-weight:bold">*</span></label>
                        <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text"
                            name="linkLattesEstudante" value="{{ $projeto->linkLattesEstudante }}" disabled>
                        <small>Ex.: http://lattes.cnpq.br/8363536830656923</small>
                        @error('linkLattesEstudante')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="linkGrupo">Link do grupo de pesquisa</label>
                        <input class="form-control @error('linkGrupo') is-invalid @enderror" type="url"
                            name="linkGrupo" value="{{ $projeto->linkGrupoPesquisa }}" disabled>

                        <small>Ex.: http://dgp.cnpq.br/dgp/espelhogrupo/228363</small>
                        @error('linkGrupo')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pontuacaoPlanilha">Valor da planilha de pontuação <span
                                style="color: red; font-weight:bold">*</span></label>
                        <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="number"
                            min="0" step=".01" name="pontuacaoPlanilha"
                            value="{{ $projeto->pontuacaoPlanilha }}" disabled>

                        @error('pontuacaoPlanilha')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if ($projeto->conflitosInteresse != null &&
                        (Auth::user()->tipo == 'administrador' ||
                            Auth::user()->tipo == 'administradorResponsavel' ||
                            Auth::user()->tipo == 'coordenador'))
                        <div class="form-group col-md-6">
                            <label for="conflitosInteresse">Conflitos de interesse: </label>
                            <textarea class="form-control @error('conflitosInteresse') is-invalid @enderror" name="conflitosInteresse"
                                rows="4" disabled>{{ $projeto->conflitosInteresse }}</textarea>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!--X Proponente X-->
