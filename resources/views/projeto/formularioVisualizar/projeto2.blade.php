<!-- projeto -->
<div class="col-md-12">
  @if (session('sucesso'))
    <div class="alert alert-success">
      <strong>{{ session('sucesso') }}</strong>
    </div>
  @endif
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #1492E6;">{{$projeto->titulo}}</h5></div>
          <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold">{{$edital->nome}}</h6></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Areas-->
<div class="col-md-12">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Área de Ensino</h5></div>
          <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem">
              {{App\GrandeArea::where('id', $projeto->grande_area_id)->first()->nome}} >
              {{App\Area::where('id', $projeto->area_id)->first()->nome}}
              @if(App\SubArea::where('id', $projeto->sub_area_id)->first() != null)> {{App\SubArea::where('id', $projeto->sub_area_id)->first()->nome}}@endif

            </h6></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--X projeto X-->