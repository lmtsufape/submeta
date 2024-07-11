<!-- projeto -->
<div class="col-md-12" style="margin-top: 20px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">

          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">@if($edital->tipo == 'CONTINUO')Informações da Atividade de Extensão: @else Informações do Projeto @endif</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6">

      <div class="row">
          <div class="form-group col-md-12" style="margin-top: 10px">
              <label for="titulo" class="col-form-label" style="font-weight: bold">@if($edital->tipo == 'CONTINUO'){{__('Nome da Atividade de Extensão')}}
                @else{{ __('Nome do Projeto') }}@endif <span style="color: red; font-weight:bold">*</span></label>
              <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" placeholder="Digite o nome do projeto" value="{{old('titulo')}}" autocomplete="titulo" maxlength="255" >

              @error('titulo')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
    </div>

        <div class="row">

          @if($edital->natureza_id != 3)
            <div class="form-group col-md-4">
              <label for="grandeArea" class="col-form-label" style="font-weight: bold">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
                <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grande_area_id" onchange="areas()" >
                  <option value="" disabled selected hidden>-- Grande Área --</option>
                  @foreach($grandeAreas as $grandeArea)
                  <option @if(old('grandeArea') !== null ? old('grandeArea') : (isset($rascunho) ? $rascunho->grande_area_id : '')
                          == $grandeArea->id ) selected @endif value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                  @endforeach
                </select>
                @error('grande_area_id')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="area" class="col-form-label" style="font-weight: bold">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
                <input type="hidden" id="oldArea" value="{{ old('area') }}" >
                <select class="form-control @error('area') is-invalid @enderror" id="area" name="area_id" onchange="subareas()" >
                  <option value="" disabled selected hidden>-- Área --</option>
                </select>
                @error('area_id')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="subArea" class="col-form-label" style="font-weight: bold">{{ __('Subárea') }} </label>
                <input type="hidden" id="oldSubArea" value="{{ old('subArea') }}" >
                <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="sub_area_id" >
                  <option value="" disabled selected hidden>-- Subárea --</option>
                  @foreach($subAreas as $subArea)
                    <option @if(old('subArea') !== null ? old('subArea') : (isset($rascunho) ? $rascunho->sub_area_id : '')
                            ==$subArea->id ) selected @endif value="{{$subArea->id}}">{{$subArea->nome}}</option>
                  @endforeach
                </select>

                @error('sub_area_id')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          @endif

            @if($edital->natureza_id ==3 )
                @if($edital->tipo == "PIBAC")
                    <div class="form-group col-md-12">
                        <label for="areaTematica" class="col-form-label" style="font-weight: bold">{{ __('Área(s) temática(s) principal(is) da atividade, de acordo com a Política de Arte e Cultura da UFAPE') }} <span style="color: red; font-weight:bold">*</span></label>
                        <span>(é possível selecionar uma ou mais áreas).</span>
                        <div class="row col-md-12">
                          @foreach($areasTematicasPibac as $areaTematica)
                              <div class="col-md-6">
                                  <input type="checkbox" name="area_tematica_id[]" id="areaTematica{{$areaTematica->id}}" value="{{$areaTematica->id}}" @if(!empty(old('areaTematica')) && in_array($areaTematica->id, old('areaTematica'))) checked @endif>
                                  <label class="form-check-label" for="areaTematica{{$areaTematica->id}}">
                                      {{ $areaTematica->nome }}
                                  </label>
                              </div>
                          @endforeach
                        </div>
                    </div>
                @else
                    <div class="form-group col-md-4">
                        <label for="areaTematica" class="col-form-label" style="font-weight: bold">{{ __('Área Temática') }} <span style="color: red; font-weight:bold">*</span></label>
                        <select class="form-control @error('area_tematica_id') is-invalid @enderror" id="areaTematica" name="area_tematica_id">
                            <option value="" disabled selected hidden>-- Área Temática--</option>
                                @if($edital->tipo == "PIBAC")
                                  @foreach($areasTematicasPibac as $areaTematica)
                                      <option @if((old('area_tematica_id') ?? "") == $areaTematica->id) selected @endif value="{{$areaTematica->id}}">{{$areaTematica->nome}}</option>
                                  @endforeach
                                @else
                                  @foreach($areaTematicas as $areaTematica)
                                      <option @if((old('area_tematica_id') ?? "") == $areaTematica->id) selected @endif value="{{$areaTematica->id}}">{{$areaTematica->nome}}</option>
                                  @endforeach
                                @endif
                        </select>

                        @error('area_tematica_id')
                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
                  <div class="row col-md-12">
                    <div class="form-group col-md-12">
                        <label for="ods_id" class="col-form-label" style="font-weight: bold">
                          {{ __('Identifique quais Objetivos de Desenvolvimento Sustentáveis (ODS) da Agenda 2030 da ONU') }}

                            <a href="https://brasil.un.org/pt-br/sdgs" rel='external' target='_blank' style="font-size: smaller"> (saiba mais sobre os ODS da agenda 2030 da ONU) </a>

                            {{ __('e/ou dos ODS nacionais propostos pela UNB e UNESP') }}

                            D<a href="https://www.guiaagenda2030.org/" rel='external' target='_blank' style="font-size: smaller"> (para maiores esclarecimentos sobre ODS nacionais acesse o link) </a>

                            {{ __('estão presentes na proposta') }}
                          <span style="color: red; font-weight:bold">*</span>
                        </label>

                      <div class="row col-md-12">
                        @foreach($ods as $od)
                        <div class="col-md-6">
                          <input type="checkbox" name="ods[]" id="ods{{$od->id}}" class="@error('ods_id') is-invalid @enderror" value="{{$od->id}}" @if(!empty(old('ods')) && in_array($od->id, old('ods'))) checked @endif>
                          <label class="form-check-label" for="ods{{$od->id}}">
                            {{ $od->nome }}
                          </label>
                        </div>
                        @endforeach
                      </div>
                      @error('ods')
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
<!--X projeto X-->