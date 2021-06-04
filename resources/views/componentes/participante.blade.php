<div class="form-row mt-2" style="display: none;">
  <div class="col-md-11">
    <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
      <div class="d-flex justify-content-between align-items-center">
        <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Discente<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
      </div>
    </a>
  </div>
  <div class="col-1">
    <button type="button" class="btn btn-danger" id="buttonRemover" onclick="removerPart(this)" >X</button>
  </div>
  <div class="col-md-12">
    <div class="collapse" id="collapseParticipante">
      <div class="container">
          <div class="row">
            <input type="hidden"  name="funcaoParticipante[]" value="4">
            <div class="col-md-12 mt-3"><h5>Dados do discente</h5></div>
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Nome completo'])
                    <input type="text" class="form-control "   name="nomeParticipante[]" placeholder="Nome Completo" required />
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'E-mail'])
                    <input type="email" class="form-control"  name="emailParticipante[]" placeholder="E-mail" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Data de nascimento'])
                    <input type="date" class="form-control" name="data_de_nascimento[]" placeholder="Data de nascimento" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'CPF'])
                    <input type="text" class="form-control cpf"  name="cpf[]" placeholder="CPF" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'RG'])
                    <input type="number" class="form-control"  min="1" maxlength="8" name="rg[]" placeholder="RG" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Celular'])
                    <input type="text" class="form-control celular"  name="celular[]" placeholder="Celular" required/>
                  @endcomponent
            </div>
            <div class="col-md-12"><h5>Endereço</h5></div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'CEP'])
                    <input type="text" class="form-control cep" name="cep[]" placeholder="CEP" required/>
                  @endcomponent
            </div>           
                               
            <div class="col-6">
              @component('componentes.select', ['label' => 'Estado'])
                <select name="uf[]" id="estado" class="form-control"   style="visibility: visible" required>
                  <option value="" disabled selected>-- Selecione uma opção --</option>
                  @foreach ($estados as $sigla => $nome)
                    <option @if(old('uf') == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                  @endforeach
                </select>
              @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Cidade'])
                    <input type="text" class="form-control"  name="cidade[]" placeholder="Cidade" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Bairro'])
                    <input type="text" class="form-control"  name="bairro[]" placeholder="Bairro" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Rua'])
                    <input type="text" class="form-control"  name="rua[]" placeholder="Rua" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Número'])
                    <input type="text" class="form-control"  name="numero[]" placeholder="Número" required/>
                  @endcomponent
            </div>                              
            <div class="col-12">
                  @component('componentes.input', ['label' => 'Complemento'])
                    <input type="text" class="form-control" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" required/>
                  @endcomponent
            </div>
            <div class="col-md-12"><h5>Dados do curso</h5></div>                               
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Universidade'])
                    <input type="text" class="form-control" name="universidade[]" placeholder="Universidade" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Curso'])
                    <input type="text" class="form-control" name="curso[]" placeholder="Curso" required/>
                  @endcomponent
            </div>                              
            <div class="col-6">
              @component('componentes.select', ['label' => 'Turno'])
                <select name="turno[]" class="form-control" required>
                  <option value="" disabled selected>-- Selecione uma opção --</option>
                  @foreach ($enum_turno as $key => $value)
                    <option @if(old('turno') == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                  @endforeach
                </select>
              @endcomponent
            </div>
            @php
              $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
            @endphp                              
            <div class="col-6">
              @component('componentes.select', ['label' => 'Total de períodos do curso'])
                <select name="total_periodos[]"  class="form-control" onchange="gerarPeriodo(this)" required>
                  <option value="" disabled selected>-- Selecione uma opção --</option>
                  @foreach ($options as $key => $value)
                    <option @if(old('total_periodos') == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                  @endforeach
                </select>
              @endcomponent
            </div>                              
            <div class="col-6">
              @component('componentes.select', ['label' => 'Período atual'])
                <select name="periodo_atual[]"  class="form-control" required >
                  <option value="" disabled selected>-- Selecione uma opção --</option>
                  
                </select>
              @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.select', ['label' => 'Ordem de prioridade'])
                    <select name="ordem_prioridade[]"  class="form-control" required>
                      <option value="" disabled selected>-- ORDEM --</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                  <input type="number" class="form-control media" name="media_geral_curso[]" min="0" max="10" step="0.01"  required>
                  @endcomponent
            </div>
            <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Título'])
                    <input type="text" class="form-control" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" required>
                  @endcomponent
            </div>                              
            <div class="col-6">
                  @component('componentes.input', ['label' => 'Anexo(.pdf)'])
                    <input type="file" class="input-group-text" name="anexoPlanoTrabalho[]" accept=".pdf" placeholder="Anexo do Plano de Trabalho" required/>
                  @endcomponent
            </div>                              
          </div>
      </div>
    </div>
  </div>
</div>