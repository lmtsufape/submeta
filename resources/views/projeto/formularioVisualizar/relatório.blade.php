<!--Relatórios-->
  <div class="col-md-12" style="margin-top: 20px;">
    <div class="card" style="border-radius: 5px">
      <div class="card-body" style="padding-top: 0.2rem;">
        <div class="container">
          <div class="form-row mt-3">
            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Relatórios</h5></div>
            <div class="col-sm-3 text-sm-right" >
              <a href="{{route('planos.listar', ['id' => $projeto->id])}}"  class="button">Listar Relatórios</a>
            </div>
          </div>
          <hr style="border-top: 1px solid#1492E6">

          <div class="row justify-content-center">
            {{-- Relatório Parcial  --}}
            <div class="col-sm-3">
              <label for="dt_inicioRelatorioParcial" class="col-form-label font-tam" style="font-weight: bold">{{ __('Início do Relatório Parcial: ') }}</label>
            </div>
            <div class="col-sm-3">
              <input id="dt_inicioRelatorioParcial{{$edital->id}}" type="date" class="form-control" name="dt_inicioRelatorioParcial" value="{{$edital->dt_inicioRelatorioParcial}}" required autocomplete="dt_inicioRelatorioParcial" disabled autofocus>
            </div>
            <div class="col-sm-3">
              <label for="dt_fimRelatorioParcial" class="col-form-label font-tam" style="font-weight: bold">{{ __('Fim do Relatório Parcial: ') }}</label>
            </div>
            <div class="col-sm-3">
              <input id="dt_fimRelatorioParcial{{$edital->id}}" type="date" class="form-control" name="dt_fimRelatorioParcial" value="{{$edital->dt_fimRelatorioParcial}}" required autocomplete="dt_fimRelatorioParcial" disabled autofocus>
            </div>
            {{-- Relatório Final --}}
            <div class="col-sm-3">
              <label for="dt_inicioRelatorioFinal" class="col-form-label font-tam" style="font-weight: bold">{{ __('Início do Relatório Final:') }}</label>
            </div>
            <div class="col-sm-3">
              <input id="dt_inicioRelatorioFinal{{$edital->id}}" type="date" class="form-control" name="dt_inicioRelatorioFinal" value="{{$edital->dt_inicioRelatorioFinal}}" required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>
            </div>
            <div class="col-sm-3">
              <label for="dt_fimRelatorioFinal" class="col-form-label font-tam" style="font-weight: bold">{{ __('Fim do Relatório Final:') }}</label>
            </div>
            <div class="col-sm-3">
              <input id="dt_fimRelatorioFinal{{$edital->id}}" type="date" class="form-control" name="dt_fimRelatorioFinal" value="{{$edital->dt_fimRelatorioFinal}}" required autocomplete="dt_fimRelatorioFinal" disabled autofocus>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--X Relatórios X-->