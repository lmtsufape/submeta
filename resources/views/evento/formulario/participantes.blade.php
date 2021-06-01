<!-- Participantes -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">4º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Área do(s) participante(s)</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px; padding:15px">
    <div class="card-body" style="margin-bottom: -2rem">
      <div class="d-flex justify-content-between align-items-center">
        <div><h5 style="color: #1492E6; margin-top:0.5rem">Participante(s)</h5></div>
        <div>
          <button type="button" class="btn btn-light" id="buttonMais" >Adicionar participante</button>
          {{-- <button type="button" class="btn btn-light" id="buttonMenos" >Remover participante</button> --}}
          
        </div>
      </div>
      <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
    </div>
    <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
      <li id="item">
        <div style="margin-bottom:15px">
          <div id="participante" >
            <div class="form-row" style="display: none" id="participantePrimeiro">
              <button type="button" class="btn btn-danger" id="buttonRemover" onclick="removerPart(this)" >Remover participante</button>
              <div class="col-md-12">
                <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
                  <div class="d-flex justify-content-between align-items-center">
                    <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Participante<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
                  </div>
                </a>
              </div>
              <div class="col-md-12">
                <div class="collapse" id="collapseParticipante">
                  <div class="container">
                      <div class="row">
                        <input type="hidden"  name="funcaoParticipante[]" value="4">
                        <div class="col-md-12 mt-3"><h5>Dados do participante</h5></div>
                        <div class="col-6">
                              @component('componentes.input', ['label' => 'Nome completo'])
                                <input type="text" class="form-control " id="nomeParticipante"  name="nomeParticipante[]" placeholder="Nome Completo" required />
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
                                <input type="tel" class="form-control celular"  name="celular[]" placeholder="Celular" required/>
                              @endcomponent
                        </div>
                        <div class="col-md-12"><h5>Endereço</h5></div>                              
                        <div class="col-6">
                              @component('componentes.input', ['label' => 'CEP'])
                                <input type="number" class="form-control" name="cep[]" placeholder="CEP" required/>
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
                                <input type="text" id="complemento" class="form-control" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" required/>
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
            <div class="form-row">
              {{-- <button type="button" onload="myScript(this)" onclick="subir(this)" >Subir</button>
              <button type="button" onload="myScript(this)" onclick="descer(this)">Descer</button> --}}
              <button type="button" class="btn btn-danger" id="buttonRemover" onclick="removerPart(this)" >Remover participante</button>
              <div class="col-md-12">
                <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
                  <div class="d-flex justify-content-between align-items-center">
                    <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Participante<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
                  </div>
                </a>
              </div>
              <div class="col-md-12">
                <div class="collapse" id="collapseParticipante">
                  <div class="container">
                      <div class="row">
                        <input type="hidden"  name="funcaoParticipante[]" value="4">
                        <div class="col-md-12 mt-3"><h5>Dados do participante</h5></div>
                        <div class="col-6">
                              @component('componentes.input', ['label' => 'Nome completo'])
                                <input type="text" class="form-control " id="nomeParticipante"  name="nomeParticipante[]" placeholder="Nome Completo" required />
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
                                <input type="tel" class="form-control celular"  name="celular[]" placeholder="Celular" required/>
                              @endcomponent
                        </div>
                        <div class="col-md-12"><h5>Endereço</h5></div>                              
                        <div class="col-6">
                              @component('componentes.input', ['label' => 'CEP'])
                                <input type="number" class="form-control" name="cep[]" placeholder="CEP" required/>
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
                                <input type="text" id="complemento" class="form-control" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" required/>
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
          </div>
        </div>        
        
      </li>

    </ol>

  </div>
</div>
<!--X Participantes X-->

