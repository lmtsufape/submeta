<!-- projeto -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">Situação Atual</h4></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px">
    
    <div class="card-body">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Resultado</h5></div>
          <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

          <div class="form-group col-md-12" style="margin-top: 10px">
            <label for="statusProjeto" class="col-form-label">{{ __('Status') }}</label>
            <input id="statusProjeto" type="text" class="form-control" name="statusProjeto" value="{{ $projeto->status }}" autocomplete="statusProjeto" disabled >
          </div>
          <div class="form-group col-md-12" style="margin-top: 10px">
            <label for="comentarioProjeto" class="col-form-label">{{ __('Comentário') }}</label>
              <textarea id="comentarioProjeto" type="text" class="form-control" name="comentarioProjeto" disabled
              >{{ $projeto->comentario }}</textarea>
          </div>

          </div>
          
        </div>
    </div>
  </div>
</div>

<!--X projeto X-->