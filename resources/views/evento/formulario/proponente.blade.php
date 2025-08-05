<!-- Proponente -->
<div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
        <div class="card-body" style="padding-top: 0.2rem;">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-12">
                        <h5 style="color: #234B8B; font-weight: bold">Informações do Proponente</h5>
                    </div>
                </div>
                <hr style="border-top: 1px solid#1492E6">
                <div class="form-row mt-3">
                    <div class="col-md-1">
                        <label for="nome" class="col-form-label font-tam"
                            style="font-weight: bold">{{ __('Nome: ') }}</label>
                    </div>
                    <div class="col-md-11">
                        <input class="form-control" type="text" id="nomeCompletoProponente1" name="nomeCoordenador"
                            disabled="disabled" value="{{ Auth()->user()->name }}">
                    </div>

                    <div class="col-md-2">
                        <br>
                        <label for="lattes" class="col-form-label font-tam"
                            style="font-weight: bold">{{ __('Currículo Lattes: ') }}</label>
                    </div>
                    <div class="col-md-10">
                        <br>
                        <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text"
                            name="linkLattesEstudante" readonly="readonly"
                            @if (Auth()->user()->proponentes != null && Auth()->user()->proponentes->linkLattes != null) value="{{ Auth()->user()->proponentes->linkLattes }}"
                   @else
                   value="" @endif>
                        @error('linkLattesEstudante')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if (
                        $edital->tipo != 'PIBEX' &&
                            $edital->tipo != 'CONTINUO' &&
                            $edital->tipo != 'PIACEX' &&
                            $edital->tipo != 'PIBAC' &&
                            $edital->tipo != 'CONTINUO-AC' &&
                            $edital->tipo != 'PROGRAMAS-EXTENSAO')
                        <div class="col-md-2">
                            <br>
                            <label for="lattes" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Grupo de Pesquisa: ') }}<span
                                    style="color: red; font-weight:bold">*</span></label>
                        </div>
                        <div class="col-md-10">
                            <br>
                            <input class="form-control @error('linkGrupoPesquisa') is-invalid @enderror" type="url"
                                name="linkGrupoPesquisa" value="{{ old('linkGrupoPesquisa') }}">
                            @error('linkGrupoPesquisa')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                    @if (
                        $edital->tipo != 'PIBEX' &&
                            $edital->tipo != 'CONTINUO' &&
                            $edital->tipo != 'PIACEX' &&
                            $edital->tipo != 'PIBAC' &&
                            $edital->tipo != 'CONTINUO-AC' &&
                            $edital->tipo != 'PICP' &&
                            $edital->tipo != 'PROGRAMAS-EXTENSAO')
                        <div class="col-md-3">
                            <br>
                            <label for="lattes" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Valor da Planilha de Pontuação: ') }}<span
                                    style="color: red; font-weight:bold">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <br>
                            <input class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="number"
                                min="0" step=".01" name="pontuacaoPlanilha"
                                value="{{ old('pontuacaoPlanilha') }}" style="width: 100px">
                            @error('pontuacaoPlanilha')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                    @if ($edital->cotaDoutor != false)
                        <div class="col-md-1">
                            <br>
                            <label for="modalidade" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Modalidade: ') }}</label>
                        </div>
                        <div class="col-md-11">
                            <br>
                            <select id="modalidade" type="text"
                                class="form-control @error('modalidade') is-invalid @enderror" name="modalidade"
                                value="{{ old('modalidade') }}" required style="width: 250px">
                                <option value="" disabled selected hidden>-- Modalidade --</option>
                                <option @if (old('modalidade') == 'AmplaConcorrencia') selected @endif value="AmplaConcorrencia">
                                    Ampla Concorrência</option>
                                <option @if (old('modalidade') == 'RecemDoutor') selected @endif value="RecemDoutor">Recém
                                    Doutor</option>
                            </select>

                        </div>
                    @endif

                    @if ($edital->numParticipantes == 0)
                        <div class="col-md-3">
                            <br>
                            <label for="nomePlanoTrabalho" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Título do plano de trabalho: ') }}<span
                                    style="color: red; font-weight:bold">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <br>
                            <input type="text" class="form-control" value="{{ old('nomePlanoTrabalho') ?? '' }}"
                                name="nomePlanoTrabalho" maxlength="255" id="nomePlanoTrabalho" required>
                            <span style="color: red; font-size: 12px" id="caracsRestantesnomePlanoTrabalho">
                            </span>
                            @error('nomePlanoTrabalho')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <br>
                            <label for="anexoPlanoTrabalho" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Anexo do plano de trabalho: ') }}<span
                                    style="color: red; font-weight:bold">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <br>
                            <input type="file" class="input-group-text"
                                value="{{ old('anexoPlanoTrabalho') ?? '' }}" name="anexoPlanoTrabalho"
                                accept=".pdf" placeholder="Anexo do Plano de Trabalho" required />
                            @error('anexoPlanoTrabalho')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                    @if (
                        $edital->tipo != 'CONTINUO' &&
                            $edital->tipo != 'PIBEX' &&
                            $edital->tipo != 'PIACEX' &&
                            $edital->tipo != 'PIBAC' &&
                            $edital->tipo != 'CONTINUO-AC' &&
                            $edital->tipo != 'PICP' &&
                            $edital->tipo != 'PIBIC' &&
                            $edital->tipo != 'PIBIC-AF' &&
                            $edital->tipo != 'PIBIC-EM' &&
                            $edital->tipo != 'PROGRAMAS-EXTENSAO')
                        <div class="col-md-2">
                            <br>
                            <label for="conflitosInteresse" class="col-form-label font-tam"
                                style="font-weight: bold">{{ __('Conflitos de interesse: ') }}</label>
                        </div>
                        <div class="col-md-10">
                            <br>
                            <textarea class="form-control @error('conflitosInteresse') is-invalid @enderror" autocomplete="conflitosInteresse"
                                id="conflitosInteresse" name="conflitosInteresse" rows="3">{{ old('conflitosInteresse') }}</textarea>
                            @error('conflitosInteresse')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!--X Proponente X-->
