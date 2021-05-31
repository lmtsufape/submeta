<!-- Anexos -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">3º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Anexos</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px">
    <div class="card-body">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Anexos</h5></div>
          <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

          <div class="form-group col-md-6" style="margin-top: 10px">
            @component('componentes.input', ['label' => 'Anexo do projeto'])
              <input type="file" class="input-group-text" name="anexoProjeto" placeholder="nomeProjeto" accept="application/pdf" required/>
            @endcomponent
            
          </div>

          <div class="form-group col-md-6" style="margin-top: 10px">
            @component('componentes.input', ['label' => 'Anexo do currículo Lattes do Coordenador'])
              <input type="file" class="input-group-text" name="anexoLattesCoordenador" placeholder="anexoPlanoTrabalho" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6">
            @component('componentes.input', ['label' => 'Anexo da Planilha de Pontuação'])
              <input type="file" class="input-group-text" name="anexoPlanilha" placeholder="anexoPlanoTrabalho" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6">
            @component('componentes.input', ['label' => 'Decisão do CONSU'])
              <input type="file" class="input-group-text" name="anexoConsuPreenchido" placeholder="anexoConsuPreenchido" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6">
            <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="margin-right: 15px;">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label>
            <input type="radio" id="radioSim" onchange="displayAutorizacoesEspeciais('sim')">
            <label for="radioSim" style="margin-right: 5px">Sim</label>
            <input type="radio" id="radioNao" onchange="displayAutorizacoesEspeciais('nao')">
            <label for="radioNao" style="margin-right: 5px">Não</label><br>
            <span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
              <strong>Selecione a autorização e envie o arquivo!</strong>
            </span>
            
            <div class="form-group" id="displaySim" style="display: none; margin-top:-1rem">
              <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf.">{{ __('Sim, declaro que necessito de autorizações especiais') }}</label>
                @error('botao')
                  <span id="botao" class="invalid-feedback" role="alert" style="overflow: visible; display:inline">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <br/>
                @if(old('anexoComitePreenchido') != null || (isset($rascunho) && $rascunho->anexoAutorizacaoComiteEtica != "" && $rascunho->anexoAutorizacaoComiteEtica != null))
                  <a id="anexoComiteTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                        'nomeAnexo' => 'anexoAutorizacaoComiteEtica' ])}}">Arquivo atual</a>
                @endif
                <input type="hidden" id="anexoComitePreenchido" name="anexoComitePreenchido" 
                  @if( isset($rascunho) && $rascunho->anexoAutorizacaoComiteEtica != "") value="sim" @else value="{{old('anexoComitePreenchido')}}" @endif >

                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input @error('anexoComiteEtica') is-invalid @enderror" id="inputEtica" aria-describedby="inputGroupFileAddon01" name="anexoComiteEtica" onchange="verificarArquivoAnexado_pdf(this, 'anexoComiteEticaLegenda')">
                    <label class="custom-file-label" id="anexoComiteEticaLegenda" for="inputEtica">O arquivo deve ser no formato PDF de até 2MB.</label>
                  </div>
                </div>
                @error('anexoComiteEtica')
                <span id="comiteErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="form-group" id="displayNao" style="display: none; margin-top:-1rem">
                <label for="nomeTrabalho" class="col-form-label">{{ __('Declaração de que não necessito de autorização especiais') }}</label>
                  @if(old('anexoJustificativaPreenchido') != null || (isset($rascunho) && $rascunho->justificativaAutorizacaoEtica != "" && $rascunho->justificativaAutorizacaoEtica != null))
                  <a id="anexoJustificativaTemp" href="{{ route('baixar.anexo.temp', ['eventoId' => $edital->id,
                                                          'nomeAnexo' => 'justificativaAutorizacaoEtica' ])}}">Arquivo atual</a>
                  @endif
                  <input type="hidden" id="anexoJustificativaPreenchido" name="anexoJustificativaPreenchido"
                    @if( isset($rascunho) && $rascunho->justificativaAutorizacaoEtica != "") value="sim" @else value="{{old('anexoJustificativaPreenchido')}}" @endif >
                  <div class="input-group">


                    <div class="custom-file">
                      <input type="file" class="custom-file-input @error('justificativaAutorizacaoEtica') is-invalid @enderror" id="inputJustificativa" aria-describedby="inputGroupFileAddon01" name="justificativaAutorizacaoEtica" onchange="verificarArquivoAnexado_pdf(this, 'justificativaAutorizacaoEticaLegenda')" required>
                      <label class="custom-file-label" id="justificativaAutorizacaoEticaLegenda" for="inputJustificativa">O arquivo deve ser no formato PDF de até 2MB.</label>
                    </div>
                  </div>
                  @error('justificativaAutorizacaoEtica')
                  <span id="justificativaErro" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
            </div>
          </div>
          
        </div>
    </div>
    </div>
  </div>
</div>
<!--X Anexos X-->