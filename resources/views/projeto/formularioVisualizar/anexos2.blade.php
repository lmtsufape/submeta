<!--Anexos-->
<div style="margin-top: 20px;">
  <div class="col-md-12">
    <div class="card" style="border-radius: 5px">
      <div class="card-body" style="padding-top: 0.2rem;">
        <div class="container">
          <div class="form-row mt-3">
            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
          </div>
          <hr style="border-top: 1px solid#1492E6">

          {{-- Anexo do Projeto --}}
          <div class="row justify-content-center">
            {{-- Arquivo  --}}
            <div class="col-sm-4">
              <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }}</label>
              <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

            </div>

            <div class="col-sm-4">
              <label for="anexoLatterCoordenador" class="col-form-label font-tam" style="font-weight: bold">{{ __('Lattes do Coordenador: ') }}</label>
              <a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

            </div>

            <div class="col-sm-4">
              <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização do Comitê de Ética: ') }}</label>
              @if($projeto->anexoAutorizacaoComiteEtica != null)
                <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
              @else
                -
              @endif
            </div>

            <div class="col-sm-4">
              <label for="anexoPlanilha" class="col-form-label font-tam" style="font-weight: bold">{{ __('Planilha de Pontuação: ') }}</label>
              <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/xlsx.ico')}}" style="width:40px" alt=""></a>

            </div>

            <div class="col-sm-4">
              <label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Justificativa: ') }}</label>
              @if($projeto->justificativaAutorizacaoEtica != null)
                <a href="{{ route('baixar.anexo.justificativa', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
              @else
                -
              @endif
            </div>

            @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
              {{-- Decisão do CONSU --}}
              <div class="col-sm-4">
                <label for="anexoCONSU" class="col-form-label font-tam" style="font-weight: bold">{{ __('Decisão do CONSU: ') }}</label>
                <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--X Anexos X-->