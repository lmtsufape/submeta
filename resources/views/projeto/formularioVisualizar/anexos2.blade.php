<!--Anexos-->
  <div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
      <div class="card-body" style="padding-top: 0.2rem;">
        <div class="container">
          <div class="form-row mt-3">
            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
          </div>
          <hr style="border-top: 1px solid#1492E6">

          {{-- Anexo do Projeto --}}
          <div class="row justify-content-start">
            @if($edital->tipo != "CONTINUO")
              {{-- Arquivo  --}}
              <div class="col-sm-4" style="float: left">
                <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }}</label>
                <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

              </div>

              @if($edital->tipo != "PIBEX")
              <div class="col-sm-4">
                <label for="anexoLatterCoordenador" class="col-form-label font-tam" style="font-weight: bold">{{ __('Lattes do Coordenador: ') }}</label>
                <a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

              </div>
              @endif

              @if($edital->tipo != "PIBEX")
              <div class="col-sm-4">
                @if($projeto->anexoAutorizacaoComiteEtica != null)
                <label title="Declaração da autorização especial" for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
                  <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                @else
                  <label title="Declaração de não necessidade de autorização especial" for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Declaração Autorização Especial: ') }}</label>
                  @if($projeto->justificativaAutorizacaoEtica != null)
                  <a href="{{ route('baixar.anexo.justificativa', ['id' => $projeto->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                  @else
                    -
                  @endif
                @endif
              </div>
              @endif

              @if($edital->tipo != "PIBEX")
              <div class="col-sm-4">
                <label for="anexoPlanilha" class="col-form-label font-tam" style="font-weight: bold">{{ __('Planilha de Pontuação: ') }}</label>
                <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/xlsx.ico')}}" style="width:40px" alt=""></a>

              </div>
              @endif

              @if($edital->tipo != "PIBEX")
              <div class="col-sm-4">
                <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Grupo de Pesquisa: ') }}</label>
                @if($projeto->anexoGrupoPesquisa != null)
                  <a href="{{ route('baixar.anexoGrupoPesquisa', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                @else
                  -
                @endif
              </div>
              @endif

              @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM' || $edital->tipo == "PIBEX")
                {{-- Decisão do CONSU --}}
                <div class="col-sm-4">
                  <label title="Decisão da Câmara ou Conselho Pertinente" for="anexoCONSU" class="col-form-label font-tam" style="font-weight: bold">{{ __('Câmara ou Conselho Pertinente: ') }}</label>
                  <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                </div>
              @endif

              @if($edital->nome_docExtra != null)
                {{-- Documento Extra --}}
                <div class="col-sm-4">
                  <label title="{{$edital->nome_docExtra}}" for="anexo_docExtra" class="col-form-label font-tam" style="font-weight: bold">{{$edital->nome_docExtra}}:</label>
                    @if($projeto->anexo_docExtra != null)
                      <a href="{{ route('baixar.anexo.docExtra', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                    @else
                      <a>
                        <i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
                      </a>
                    @endif
                </div>
              @endif
            @else
              <div class="col-sm-4">
                      <label for="anexo_SIPAC" class="col-form-label font-tam"
                          style="font-weight: bold">{{ __('Anexo SIPAC: ') }}</label>
                      <a href="{{ route('baixar.anexo.SIPAC', ['id' => $projeto->id])}}"><img class=""
                                                                                              src="{{asset('img/icons/pdf.ico')}}"
                                                                                              style="width:40px"
                                                                                              alt=""></a>
              </div>                                
          @endif

          </div>
        </div>
      </div>
    </div>
  </div>

<!--X Anexos X-->