<!-- projeto -->
<div class="col-md-12" style="margin-top: 40px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">@if($edital->tipo == 'CONTINUO' || $edital->tipo == 'CONTINUO-AC')Informações da Atividade de Extensão: @else Informações do Projeto @endif</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6">

        <div class="row">
          <div class="form-group col-md-12" style="margin-top: 10px">
            <label for="titulo" class="col-form-label" style="font-weight: bold">@if($edital->tipo == 'CONTINUO' || $edital->tipo == 'CONTINUO-AC'){{__('Nome da Atividade de Extensão')}} 
                @else{{ __('Nome do Projeto') }}@endif <span style="color: red; font-weight:bold">*</span></label>
            <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" placeholder="Digite o nome do projeto" value="{{old('titulo') ?? $projeto->titulo}}" autocomplete="titulo" maxlength="255" >
            <span style="color: red; font-size: 12px" id="caracsRestantestitulo">
              </span>
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
                  <option @if($projeto->grande_area_id == $grandeArea->id ) selected @endif value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
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
                @foreach($areas as $area)
                  <option @if($projeto->area_id == $area->id ) selected @endif value="{{$area->id}}">{{$area->nome}}</option>
                @endforeach
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
                <@if ($projeto->subarea != null)
                  @foreach($subAreas as $subarea)
                    <option @if($projeto->sub_area_id == $subarea->id ) selected @endif value="{{$subarea->id}}">{{$subarea->nome}}</option>
                  @endforeach
                @endif
              </select>

              @error('sub_area_id')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          @endif
          @if($edital->natureza_id ==3 )
            <div class="form-group col-md-4">
              <label for="areaTematica" class="col-form-label" style="font-weight: bold">{{ __('Área Temática') }} <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control @error('area_tematica_id') is-invalid @enderror" id="areaTematica" name="area_tematica_id">
                <option value="" disabled selected hidden>-- Área Temática--</option>
                @foreach($areaTematicas as $areaTematica)
                  <option @if(old('area_tematica_id') !== null ? old('area_tematica_id') : (isset($rascunho) ? $rascunho->area_tematica_id : '')
                            == $areaTematica->id ) selected @endif @if($projeto->area_tematica_id == $areaTematica->id ) selected @endif  value="{{$areaTematica->id}}">{{$areaTematica->nome}}</option>
                @endforeach
              </select>
              @error('area_tematica_id')
              <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
              @enderror
              </div>
                  
              <div class="row col-md-12">
                <div class="form-group col-md-12">
                <label for="ods_id" class="col-form-label" style="font-weight: bold">{{ __('Objetivo de Desenvolvimento Sustentável') }} <span style="color: red; font-weight:bold">*</span></label>
                      <span>(é possível selecionar um ou mais objetivos. Para outras informações, acesse o  
                            <a href="https://brasil.un.org/pt-br/sdgs" rel='external' target='_blank'>link</a>).</span>
                  
                  <div class="row col-md-12">
                    @foreach($listaOds as $ods)
                    <div class="col-md-6">
                      <input type="checkbox" name="ods[]" id="ods{{$ods->id}}" value="{{$ods->id}}" @if((empty(old('ods')) && $projeto->ods->contains($ods->id)) || (!empty(old('ods')) && in_array($ods->id, old('ods')))) checked @endif >
                      <label class="form-check-label" for="ods{{$ods->id}}">
                        {{ $ods->nome }}
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
