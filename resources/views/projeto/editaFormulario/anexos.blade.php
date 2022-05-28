<!-- Anexos -->
<div class="col-md-12" style="margin-top: 20px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6; margin-bottom: 10px" >

        {{-- Anexo do Projeto --}}
        <div class="row justify-content-start">
          {{-- Arquivo  --}}

          <div class="form-group col-md-6">
            <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }} </label>
            @if($projeto->anexoProjeto)
              <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}"><i class="fas fa-file-pdf fa-2x"></i></a>
            @else
              <p><i class="fas fa-times-circle fa-2x"></i></p>
            @endif
            <input type="file" class="input-group-text" name="anexoProjeto" placeholder="nomeProjeto" accept="application/pdf" />
            @error('anexoProjeto')
            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
            @enderror

          </div>

          @if($edital->tipo != "PIBEX")
            <div class="form-group col-md-6" style="margin-top: 10px">
              <label for="anexoLatterCoordenador" class="col-form-label font-tam" style="font-weight: bold">{{ __('Lattes do Coordenador: ') }}</label>
              @if($projeto->anexoLattesCoordenador)
                <a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
              @else
                <i class="fas fa-times-circle fa-2x"></i>
              @endif
              <input type="file" class="input-group-text" name="anexoLattesCoordenador" placeholder="anexoPlanoTrabalho" accept=".pdf" />
              @error('anexoLattesCoordenador')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          @endif


          @if($edital->tipo != "PIBEX")
            <div class="form-group col-md-6">
              <label for="anexoPlanilhaPontuacao" class="col-form-label font-tam" style="font-weight: bold">{{ __('Planilha de Pontuação: ') }}</label>
              @if($projeto->anexoPlanilhaPontuacao)
                  <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
              @else
                  <i class="fas fa-times-circle fa-2x"></i>
              @endif
              <input type="file" class="input-group-text" name="anexoPlanilhaPontuacao" placeholder="anexoPlanilhaPontuacao" accept=".xlsx, .xls, .ods" />
              @error('anexoPlanilhaPontuacao')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror

            </div>
          @endif

          @if($edital->consu)
            <div class="form-group col-md-6">
              <label title="Decisão da Câmara ou Conselho Pertinente" for="anexoCONSU" class="col-form-label font-tam" style="font-weight: bold">{{ __('Decisão da Câmara ou Conselho Pertinente: ') }}<span style="color: red; font-weight:bold">*</span></label>
              @if($projeto->anexoDecisaoCONSU)
                  <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
              @else
                  <i class="fas fa-times-circle fa-2x"></i>
              @endif
              <input type="file" class="input-group-text" name="anexoDecisaoCONSU"  accept=".pdf" />
              @error('anexoDecisaoCONSU')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          @else
            <div class="form-group col-md-6">
              <label title="Decisão da Câmara ou Conselho Pertinente" for="anexoCONSU" class="col-form-label font-tam" style="font-weight: bold">{{ __('Decisão da Câmara ou Conselho Pertinente: ') }}</label>
              @if($projeto->anexoDecisaoCONSU)
                <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
              @else
                <i class="fas fa-times-circle fa-2x"></i>
              @endif
              <input type="file" class="input-group-text" name="anexoDecisaoCONSU"  accept=".pdf" />
              @error('anexoDecisaoCONSU')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          @endif

          @if($edital->tipo != "PIBEX")
            <div class="form-group col-md-6" style="margin-top: 10px">
              <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Grupo de Pesquisa: ') }}</label>
              @if($projeto->anexoGrupoPesquisa)
                  <a href="{{ route('baixar.anexoGrupoPesquisa', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
              @else
                  <i class="fas fa-times-circle fa-2x"></i>
              @endif
              <input type="file" class="input-group-text" name="anexoGrupoPesquisa" placeholder="Anexo do Grupo de Pesquisa" accept="application/pdf" />
              @error('anexoGrupoPesquisa')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          @endif


            @if($edital->tipo != "PIBEX")
            <div class="form-group col-md-6">

              <label for="botao" class="col-form-label font-tam @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="font-weight: bold">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label>
              <input type="radio" checked id="radioSim" onchange="displayAutorizacoesEspeciais('sim')">
              <label for="radioSim" style="margin-right: 5px">Sim</label>
              <input type="radio" id="radioNao" onchange="displayAutorizacoesEspeciais('nao')">
              <label for="radioNao" style="margin-right: 5px">Não</label><br>
              <span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
              <strong>Selecione a autorização e envie o arquivo!</strong>
            </span>

              <div class="form-group" id="displaySim" style="display: block; margin-top:-1rem">
                <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold;font-size: 13px">{{ __('Sim, declaro que necessito de autorizações especiais') }}</label>
                @if($projeto->anexoAutorizacaoComiteEtica )

                      <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>

                @else
                    <i class="fas fa-times-circle fa-2x"></i>
                @endif
                <input type="file" class="input-group-text" name="anexoAutorizacaoComiteEtica" placeholder="anexoComiteEtica" accept=".pdf" />
                @error('anexoAutorizacaoComiteEtica')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group" id="displayNao" style="display: none; margin-top:-1rem">
                <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Declaração de que não necessito de autorização especiais ') }}</label>
                @if($projeto->justificativaAutorizacaoEtica)
                      <a href="{{ route('baixar.anexo.justificativa', ['id' => $projeto->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                @else
                    <i class="fas fa-times-circle fa-2x"></i>
                @endif
                <input type="file" class="input-group-text" name="justificativaAutorizacaoEtica" placeholder="justificativaAutorizacaoEtica" accept=".pdf" />
                @error('justificativaAutorizacaoEtica')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                      <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            @endif
        </div>
      </div>
    </div>
  </div>
</div>