<!-- Participantes -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">4º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Área do(s) discente(s)</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px; padding:15px">
    <div class="card-body" style="margin-bottom: -2rem">
      <div class="d-flex justify-content-between align-items-center">
        <div><h5 style="color: #1492E6; margin-top:0.5rem">Discente(s)</h5></div>
        <div>
          
          
        </div>
      </div>
      <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
    </div>
    <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
      <li id="item">
        <div style="margin-bottom:15px">
          <div id="participante" >
            @foreach ($participantes as $key => $p)
            <div class="form-row mt-2">
                <div class="col-md-11">
                  <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante{{ $p->id }}" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
                    <div class="d-flex justify-content-between align-items-center">
                      <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Discente<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
                    </div>
                  </a>
                </div>
                {{-- <div class="col-1" style="margin-top:4.3px">
                  <button type="button" class="btn btn-danger shadow-sm" id="buttonRemover" onclick="removerPart(this)" >X</button>
                </div> --}}
                <div class="col-md-12">
                  <div class="collapse" id="collapseParticipante{{ $p->id }}">
                    <div class="container">
                        <div class="row">
                          <input type="hidden" name="participante_id[]" value="{{ $p->id }}">
                          <input type="hidden"  name="funcaoParticipante[]" value="4">
                          <div class="col-md-12 mt-3"><h5>Dados do discente</h5></div>
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Nome completo'])
                                  <input type="text" class="form-control " value="{{ $p->user->name }}"   name="nomeParticipante[]" placeholder="Nome Completo" disabled />
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'E-mail'])
                                  <input type="email" class="form-control" value="{{ $p->user->email }}" name="emailParticipante[]" placeholder="E-mail" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Data de nascimento'])
                                  <input type="date" class="form-control" value="{{ $p->data_de_nascimento }}" name="data_de_nascimento[]" placeholder="Data de nascimento" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'CPF'])
                                  <input type="text" class="form-control cpf" value="{{ $p->user->cpf }}"  name="cpf[]" placeholder="CPF" disabled />
                                  <span id="cpf-invalido-1" class="invalid-feedback cpf-invalido" role="alert" style="overflow: visible; display:none">
                                    <span style="font-style: italic;">CPF inválido.</span>
                                  </span>
                                  <span id="cpf-valido-1" class="valid-feedback" role="alert" style="overflow: visible; display:none">
                                    <span style="font-style: italic;">CPF válido.</span>
                                  </span>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'RG'])
                                  <input type="number" class="form-control" value="{{ $p->rg }}" min="1" maxlength="12" name="rg[]" placeholder="RG" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Celular'])
                                  <input type="tel" class="form-control celular" value="{{ $p->user->celular }}" name="celular[]" placeholder="Celular" disabled/>
                                @endcomponent
                          </div>
                          <div class="col-md-12"><h5>Endereço</h5></div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'CEP'])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->cep }}" name="cep[]" placeholder="CEP" disabled/>
                                @endcomponent
                          </div>           
                                            
                          <div class="col-6">
                            @component('componentes.select', ['label' => 'Estado'])
                              <select name="uf[]" id="estado" class="form-control"   style="visibility: visible" disabled>
                                <option value="" disabled selected>-- Selecione uma opção --</option>
                                @foreach ($estados as $sigla => $nome)
                                  <option @if( $p->user->endereco->uf == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                                @endforeach
                              </select>
                            @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Cidade'])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->cidade }}" name="cidade[]" placeholder="Cidade" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Bairro'])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->bairro }}" name="bairro[]" placeholder="Bairro" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Rua'])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->rua }}" name="rua[]" placeholder="Rua" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Número'])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->numero }}" name="numero[]" placeholder="Número" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-12">
                                @component('componentes.input', ['label' => 'Complemento', 'obrigatorio' => ''])
                                  <input type="text" class="form-control" value="{{ $p->user->endereco->complemento }}" name="complemento[]"  pattern="[A-Za-z]+" placeholder="Complemento" disabled/>
                                @endcomponent
                          </div>
                          <div class="col-md-12"><h5>Dados do curso</h5></div>                               
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Universidade'])
                                  <input type="text" class="form-control" value="{{ $p->user->instituicao }}" name="universidade[]" placeholder="Universidade" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Curso'])
                                  <input type="text" class="form-control" value="{{ $p->curso }}" name="curso[]" placeholder="Curso" disabled/>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                            @component('componentes.select', ['label' => 'Turno'])
                              <select name="turno[]" class="form-control" disabled>
                                <option value="" disabled selected>-- Selecione uma opção --</option>
                                @foreach ($enum_turno as $key => $value)
                                  <option @if($p->turno == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                              </select>
                            @endcomponent
                          </div>
                          @php
                            $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
                          @endphp                              
                          <div class="col-6">
                            @component('componentes.select', ['label' => 'Total de períodos do curso'])
                              <select name="total_periodos[]"  class="form-control" onchange="gerarPeriodo(this)" disabled>
                                <option value="" disabled selected>-- Selecione uma opção --</option>
                                @foreach ($options as $key => $value)
                                  <option @if($p->total_periodos == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                              </select>
                            @endcomponent
                          </div>                              
                          <div class="col-6">
                            @component('componentes.select', ['label' => 'Período atual'])
                              <select name="periodo_atual[]"  class="form-control" disabled >
                                <option value="" disabled selected>-- Selecione uma opção --</option>
                                <option selected  value="{{ $p->periodo_atual }}">{{ $p->periodo_atual }}</option>
                              </select>
                            @endcomponent
                          </div>                              
                          <div class="col-6">
                                @php
                                  $ordens = array('1' => 1, '2' => 2,'3' => 3,); 
                                @endphp 
                                @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                  <select name="ordem_prioridade[]"  class="form-control" disabled>
                                    <option value="" disabled selected>-- ORDEM --</option>
                                    @foreach ($ordens as $ordem)
                                      <option @if($p->ordem_prioridade == $ordem) @endif selected  value="{{ $p->ordem_prioridade }}">{{ $p->ordem_prioridade }}</option>
                                    @endforeach
                                  </select>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                                @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                                <input type="number" class="form-control media" value="{{ $p->media_do_curso }}" name="media_geral_curso[]" min="0" max="10" step="0.01"  disabled>
                                @endcomponent
                          </div>
                          <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
                          <div class="col-12">
                            {{-- @dd($arquivos) --}}
                                @component('componentes.input', ['label' => 'Título'])
                                  <input type="text" class="form-control" value="{{$p->planoTrabalho ? $p->planoTrabalho->titulo : "  " }}" name="nomePlanoTrabalho[]" placeholder="Digite o título do plano de trabalho" disabled>
                                @endcomponent
                          </div>                              
                          <div class="col-6">
                            <div class="row justify-content-start">
                              <div class="col-4">
                                  @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                                  @endcomponent
                                </div>
                              </div>
                              <div class="row justify-content-center">
                                
                                @if($p->planoTrabalho) 
                                  <div class="col-3 ">
                                      <a href="{{ route('baixar.plano', ['id' => $p->planoTrabalho->id]) }}">
                                      <i class="fas fa-file-pdf fa-2x"></i></a>
                                    </div>
                                  </div>
                                @else
                                  <div class="col-3 text-danger">
                                    <p><i class="fas fa-times-circle fa-2x"></i></p>
                                  </div>
                                @endif
                          </div>                              
                        </div>
                    </div>
                  </div>
                </div>
                  
              </div>
            @endforeach
          </div>
        </div>        
        
      </li>

    </ol>

  </div>
</div>
<!--X Participantes X-->

