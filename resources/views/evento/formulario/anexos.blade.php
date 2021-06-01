<!-- Anexos -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">3º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Anexos</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px">
    <div class="card-body">
      <div class="container">
        <div class="form-row mt-3">
          <div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Anexos</h5></div>
          <div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

          <div class="form-group col-md-6" style="margin-top: 10px">
            @component('componentes.input', ['label' => 'Anexo do projeto(.pdf)'])
              <input type="file" class="input-group-text" name="anexoProjeto" placeholder="nomeProjeto" accept="application/pdf" required/>
            @endcomponent
            
          </div>

          <div class="form-group col-md-6" style="margin-top: 10px">
            @component('componentes.input', ['label' => 'Anexo do currículo Lattes do Coordenador(.pdf)'])
              <input type="file" class="input-group-text" name="anexoLattesCoordenador" placeholder="anexoPlanoTrabalho" accept=".pdf" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6">
            @component('componentes.input', ['label' => 'Anexo da Planilha de Pontuação(.xlsx,.xls,.ods)'])
              <input type="file" class="input-group-text" name="anexoPlanilha" placeholder="anexoPlanoTrabalho" accept=".xlsx, .xls, .ods" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6">
            @component('componentes.input', ['label' => 'Decisão do CONSU(.pdf)'])
              <input type="file" class="input-group-text" name="anexoConsuPreenchido" placeholder="anexoConsuPreenchido" accept=".pdf" required/>
            @endcomponent
          </div>
          <div class="form-group col-md-6" style="margin-top: 10px">
            @component('componentes.input', ['label' => 'Anexo do Grupo de Pesquisa(.pdf)'])
              <input type="file" class="input-group-text" name="anexoGrupoPesquisa" placeholder="Anexo do Grupo de Pesquisa" accept="application/pdf" required/>
            @endcomponent
            
          </div>
          <div class="col-md-6"></div>
          <div class="form-group col-md-6">
            <label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="margin-right: 15px;">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label>
            <input type="radio" checked id="radioSim" onchange="displayAutorizacoesEspeciais('sim')">
            <label for="radioSim" style="margin-right: 5px">Sim</label>
            <input type="radio" id="radioNao" onchange="displayAutorizacoesEspeciais('nao')">
            <label for="radioNao" style="margin-right: 5px">Não</label><br>
            <span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
              <strong>Selecione a autorização e envie o arquivo!</strong>
            </span>
            
            <div class="form-group" id="displaySim" style="display: block; margin-top:-1rem">
              @component('componentes.input', ['label' => 'Sim, declaro que necessito de autorizações especiais(.pdf)'])
                <input type="file" class="input-group-text" name="anexoComiteEtica" placeholder="anexoComiteEtica" accept=".pdf" required/>
              @endcomponent
              </div>

              <div class="form-group" id="displayNao" style="display: none; margin-top:-1rem">
                @component('componentes.input', ['label' => 'Declaração de que não necessito de autorização especiais(.pdf)'])
                  <input type="file" class="input-group-text" name="inputJustificativa" placeholder="inputJustificativa" accept=".pdf" required/>
                @endcomponent
            </div>
          </div>
          
          
        </div>
    </div>
    </div>
  </div>
</div>
<!--X Anexos X-->