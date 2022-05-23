<!-- Finalizar -->
<div class="col-md-12" style="margin-top: 20px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Finalizar</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6">
      <div class=" d-flex justify-content-between align-items-center" style="margin-top: 15px; margin-bottom:18px">
        <h6 style="font-weight: bold"><span style="color: red; font-weight:bold">*</span> Campos obrigatórios</h6>
        <button id="submeterFormProposta" type="submit" style="display: none;"></button>
        <button type="submit" class="btn btn-primary " id="idButtonSubmitRascunho" >{{ __('Salvar como rascunho') }}</button>
        <button type="submit" class="btn btn-success" id="idButtonSubmitProjeto" >{{ __('Submeter projeto') }}</button>

      </div>
      @if($errors->any())             
        <div class="alert alert-danger">
          Verifique se todos os campos obrigatórios foram preenchidos!
        </div>
      @endif
    </div>
  </div>
  </div>
</div>
<!--X Finalizar X-->