<!--Relatórios-->
  <div class="col-md-12" style="margin-top: 20px;">
    <div class="card" style="border-radius: 5px">
      <div class="card-body" style="padding-top: 0.2rem;">
        <div class="container">
          <div class="form-row mt-3">
            <div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Relatórios</h5></div>
            <div class="col-sm-3 text-sm-right" >
              @if($flagSubstituicao == 1)
                <a href="{{route('planos.listar', ['id' => $projeto->id])}}"  class="button">Listar Relatórios</a>
              @else
                <a href="{{route('planos.listar', ['id' => $projeto->id])}}"  class="button" title="Existe uma Substituição pendente" style="color: red">Listar Relatórios</a>
              @endif

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
          <br>
          <div class="row justify-content-start">
              <div class="col-md-3"><h6 style="color: #234B8B; font-weight: bold">Avaliações dos Relatórios</h6></div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th style="color: black;">Avaliador</th>
                <th style="color: black;">Relatório</th>
                <th style="color: black;">Nota</th>
                <th style="color: black;">Visualizar</th>
              </tr>
            </thead>
            <tbody>
            @foreach($AvalRelatParcial as $aval)
              <tr>
                <th style="color: black;">{{$cont += 1}}</th>
                <td>Parcial</td>
                <td>@if($aval->nota == null) Pendente @else {{$aval->nota}} @endif</td>
                <td><a href="" data-toggle="modal" data-target="#modalVizuRelatParcial{{$aval->id}}" class="button">Visualizar</a></td>
              </tr>

              <!-- Modal visualizar informações da avaliação -->
              <div class="modal fade" id="modalVizuRelatParcial{{$aval->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                            <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                                Avaliação do relatório parcial @if($aval->nota == null)<b style="color: red">Pendente</b>@endif</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"
                                style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                            @include('avaliacaoRelatorio.avaliacao', ['avaliacao' => $aval])
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($AvalRelatFinal as $aval)
              <tr>              
                <th style="color: black;">{{$cont += 1}}</th>
                <td>Final</td>
                <td>@if($aval->nota == null) Pendente @else {{$aval->nota}} @endif</td>
                <td><a href="" data-toggle="modal" data-target="#modalVizuRelatFinal{{$aval->id}}" class="button">Visualizar</a></td>
              </tr>
              <!-- Modal visualizar informações participante -->
              <div class="modal fade" id="modalVizuRelatFinal{{$aval->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                          <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                              <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">
                                  Avaliação do relatório final @if($aval->nota == null) <b style="color: red">Pendente</b>@endif</h5>

                              <button type="button" class="close" data-dismiss="modal"
                                      aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>

                          <div class="modal-body"
                                  style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                              @include('avaliacaoRelatorio.avaliacao', ['avaliacao' => $aval])
                          </div>
                      </div>
                  </div>
              </div>       
            @endforeach       
            </tbody>
          </table>              
        </div>
      </div>
    </div>
  </div>