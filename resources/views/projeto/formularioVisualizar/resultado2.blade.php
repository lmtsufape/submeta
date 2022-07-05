<!-- projeto -->
<div class="col-md-12" style="margin-top: 20px">
  <div class="card" style="border-radius: 5px">
    <div class="card-body" style="padding-top: 0.2rem;">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Recomendação da Proposta</h5></div>
        </div>
        <hr style="border-top: 1px solid#1492E6">
          <div class="row">
            <div class="col-md-9">
              <a class="col-md-12 text-left" style="padding-left: 0px;color: #234B8B; font-weight: bold;">Comentário</a>
              <textarea class="col-md-12" id="comentario" name="comentario" style="border-radius:5px 5px 0 0;height: 71px;" required disabled
              >@if($projeto->comentario != null){{$projeto->comentario}}@endif</textarea>
            </div>
            <div class="col-md-3" style="margin-top: 15px">
              <input class="col-md-1" type="radio" id="aprovado" name="statusProp" value="aprovado" required disabled
              @if($projeto->status=="aprovado") checked @endif>
              <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Recomendada</a>
              <br>
              
              <input class="col-md-1" type="radio" id="reprovado" name="statusProp" value="reprovado" required disabled
              @if($projeto->status=="reprovado") checked @endif>
              <a style="color: #234B8B; font-weight: bold;font-size: 18px;">Não Recomendada</a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<!--X projeto X-->