<!-- Participantes -->
<div class="col-md-10" style="text-align: center; margin-top:2rem"><h4 style="margin-top: 1rem;">4º Passo</h4></div>
<div class="col-md-10" style="text-align: center;"><h5 style="margin-bottom:1rem;color:#909090">Área do(s) discente(s)</h5></div>
<div class="col-md-10">
  <div class="card" style="border-radius: 12px; padding:15px">
    <div class="card-body" style="margin-bottom: -2rem">
      <div class="d-flex justify-content-between align-items-center">
        <div><h5 style="color: #1492E6; margin-top:0.5rem">Discente(s)</h5></div>
        <div>
          <button type="button" class="btn btn-light" id="buttonMais" >Adicionar discente </button>
          {{-- <button type="button" class="btn btn-light" id="buttonMenos" >Remover participante</button> --}}
          
        </div>
      </div>
      <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
    </div>
    <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
      <li id="item">
        <div style="margin-bottom:15px">
          <div id="participante" >
            @for($i = 0; $i < $edital->numParticipantes; $i++)
              @php
                $p = null;
                if ($projeto->participantes->keys()->contains($i)) {
                  $p = $projeto->participantes[$i];
                }
                
              @endphp

                @if($p)
                  <div class="form-row mb-1">
                    <div class="col-md-11">
                      <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante{{$i}}" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
                        <div class="d-flex justify-content-between align-items-center">
                          <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Discente<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
                        </div>
                      </a>
                    </div>
                    <div class="col-1" style="margin-top:9.3px">
                      {{-- <button type="button" class="btn btn-danger shadow-sm" id="buttonRemover" onclick="removerPart(this)" >X</button> --}}
                      <input type="checkbox" aria-label="Checkbox for following text input" @if(old('name')[$i] ?? $p) checked @endif name="marcado[]" value="{{ $i }}">
                    </div>
                    <div class="col-md-12">
                      <div class="collapse" id="collapseParticipante{{$i}}">
                        <div class="container">
                            <div class="row">
                              <input type="hidden" name="participante_id[]" value="{{ $p->id ?? "" }}">
                              <input type="hidden"  name="funcaoParticipante[]" value="4">
                              <div class="col-md-12 mt-3"><h5>Dados do discente</h5></div>
                              <div class="col-6">
                                @component('componentes.input', ['label' => 'Nome completo'])
                                  <input type="text" class="form-control " value="{{old('name')[$i] ?? $p->user->name }}"  name="name[{{$i}}]" placeholder="Nome Completo"  />
                                  
                                  @error("name.".$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'E-mail'])
                                      <input type="email" class="form-control" value="{{old('email')[$i] ?? $p->user->email }}" name="email[{{$i}}]" placeholder="E-mail" />
                                      @error('email.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Data de nascimento'])
                                      <input type="date" class="form-control"  value="{{old('data_de_nascimento')[$i] ?? $p->data_de_nascimento }}" name="data_de_nascimento[{{$i}}]" placeholder="Data de nascimento" />
                                      @error('data_de_nascimento.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'CPF'])
                                      <input type="text" class="form-control cpf" value="{{old('cpf')[$i] ?? $p->user->cpf }}" name="cpf[{{$i}}]" placeholder="CPF" />
                                      
                                      @error('cpf.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'RG'])
                                      <input type="number" class="form-control"  min="1" maxlength="12" value="{{old('rg')[$i] ?? $p->rg  }}" name="rg[{{$i}}]"  placeholder="RG" />
                                      @error('rg.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Celular'])
                                      <input type="tel" class="form-control celular"  value="{{old('celular')[$i] ?? $p->user->celular }}" name="celular[{{$i}}]"  placeholder="Celular" />
                                      @error('celular.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>
                              <div class="col-md-12"><h5>Endereço</h5></div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'CEP'])
                                      <input type="text" class="form-control" value="{{old('cep')[$i] ?? $p->user->endereco->cep }}" name="cep[{{$i}}]"  placeholder="CEP" />
                                      @error('cep.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>           
                                                  
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Estado'])
                                  <select name="uf[{{$i}}]"  id="estado" class="form-control"   style="visibility: visible" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($estados as $sigla => $nome)
                                      <option @if(old('uf')[$i] ?? $p->user->endereco->uf == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                                    @endforeach
                                  </select>
                                  @error('uf.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Cidade'])
                                      <input type="text" class="form-control" value="{{old('cidade')[$i] ?? $p->user->endereco->cidade }}" name="cidade[{{$i}}]"  placeholder="Cidade" />
                                      @error('cidade.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Bairro'])
                                      <input type="text" class="form-control" value="{{old('bairro')[$i] ?? $p->user->endereco->bairro }}" name="bairro[{{$i}}]"  placeholder="Bairro" />
                                      @error('bairro.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Rua'])
                                      <input type="text" class="form-control" value="{{old('rua')[$i] ?? $p->user->endereco->rua }}" name="rua[{{$i}}]" placeholder="Rua" />
                                      @error('rua.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Número'])
                                      <input type="text" class="form-control" value="{{old('numero')[$i] ??  $p->user->endereco->numero }}" name="numero[{{$i}}]"  placeholder="Número" />
                                      @error('numero.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-12">
                                <div class="form-group">
                                  <label class=" control-label" for="firstname">Complemento</label>
                                  <input type="text" class="form-control" value="{{old('complemento')[$i] ?? $p->user->endereco->complemento }}" name="complemento[{{$i}}]"    placeholder="Complemento" />
                                    @error('complemento.'.$i)
                                      <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>
                                    
                              </div>
                              <div class="col-md-12"><h5>Dados do curso</h5></div>                               
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Universidade'])
                                      <input type="text" class="form-control" value="{{old('instituicao')[$i] ?? $p->user->instituicao }}" name="instituicao[{{$i}}]"  placeholder="Universidade" />
                                      @error('instituicao.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Curso'])
                                      <input type="text" class="form-control" value="{{old('curso')[$i] ?? $p->curso }}" name="curso[{{$i}}]"  placeholder="Curso" />
                                      @error('curso.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Turno'])
                                  <select  name="turno[{{$i}}]"  class="form-control" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($enum_turno as $key => $value)
                                      <option @if(old('turno')[$i] ?? $p->turno == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                  </select>
                                  @error('turno.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>
                              @php
                                $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
                              @endphp                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Total de períodos do curso'])
                                  <select  name="total_periodos[{{$i}}]"   class="form-control" onchange="gerarPeriodo(this)" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($options as $key => $value)
                                      <option @if(old('total_periodos')[$i]  ?? $p->total_periodos == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                  </select>
                                  @error('total_periodos.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Período atual'])
                                  <select name="periodo_atual[]"  class="form-control"  >
                                    <option selected value="{{ old('periodo_atual')[$i]  ?? $p->periodo_atual }}">{{ old('periodo_atual')[$i]  ?? $p->periodo_atual }}</option>
                                  </select>
                                  @error('periodo_atual.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                  <select name="ordem_prioridade[]"  class="form-control" >
                                    <option value=""  selected>-- ORDEM --</option>
                                    @for($j = 1; $j <= 3; $j++)
                                      <option @if(old('ordem_prioridade')[$i]  ?? $p->ordem_prioridade == $j ) selected @endif value="{{ $j }}">{{ $j }}</option>  
                                    @endfor
    
                                  </select>
                                  @error('ordem_prioridade.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                                    <input type="number" class="form-control media" value="{{old('media_do_curso')[$i] ?? $p->media_do_curso }}" name="media_do_curso[{{$i}}]"  min="0" max="10" step="0.01"  >
                                    @error('media_do_curso.'.$i)
                                      <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    @endcomponent
                              </div>
                              <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
                              <div class="col-12">
                                    @component('componentes.input', ['label' => 'Título'])
                                      <input type="text" class="form-control" value="{{$p->planoTrabalho ? $p->planoTrabalho->titulo : "" }}" name="nomePlanoTrabalho[{{$i}}]"  placeholder="Digite o título do plano de trabalho" >
                                      @error('nomePlanoTrabalho.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Anexo(.pdf)'])
                                      <input type="file" class="input-group-text" value="{{old('anexoPlanoTrabalho')[$i] ?? "" }}" name="anexoPlanoTrabalho[{{$i}}]"  accept=".pdf" placeholder="Anexo do Plano de Trabalho" />
                                      @error('anexoPlanoTrabalho.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                      @error('anexoPlanoTrabalho')
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                                    @if($p->planoTrabalho)
                                    <div class="row justify-content-center">
                                      <div class="col-3 ">
                                        <a href="{{ route('baixar.plano', ['id' => $p->planoTrabalho->id]) }}">
                                        <i class="fas fa-file-pdf fa-2x"></i></a>
                                      </div>
                                    </div>

                                    @endif
                              </div>                              
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="form-row mb-1">
                    <div class="col-md-11">
                      <a class="btn btn-light" data-toggle="collapse" id="idCollapseParticipante" href="#collapseParticipante{{$i}}" role="button" aria-expanded="false" aria-controls="collapseParticipante" style="width: 100%; text-align:left">
                        <div class="d-flex justify-content-between align-items-center">
                          <h4 id="tituloParticipante" style="color: #01487E; font-size:17px; margin-top:5px">Discente<span id="pontos" style="display: none;">:</span> <span style="display: none;" id="display"></span>  </h4>
                        </div>
                      </a>
                    </div>
                    <div class="col-1" style="margin-top:9.3px">
                      {{-- <button type="button" class="btn btn-danger shadow-sm" id="buttonRemover" onclick="removerPart(this)" >X</button> --}}
                      <input type="checkbox" aria-label="Checkbox for following text input" @if(old('name')[$i] ?? "") checked @endif name="marcado[]" value="{{ $i }}">
                    </div>
                    <div class="col-md-12">
                      <div class="collapse" id="collapseParticipante{{$i}}">
                        <div class="container">
                            <div class="row">
                              <input type="hidden" name="participante_id[]" value="">
                              <input type="hidden"  name="funcaoParticipante[]" value="4">
                              <div class="col-md-12 mt-3"><h5>Dados do discente</h5></div>
                              <div class="col-6">
                                @component('componentes.input', ['label' => 'Nome completo'])
                                  <input type="text" class="form-control " value="{{old('name')[$i] ?? "" }}"  name="name[{{$i}}]" placeholder="Nome Completo" maxlength="150" id="nome{{$i}}"  />
                                  <span style="color: red; font-size: 12px" id="caracsRestantesnome{{$i}}">
                                  </span>
                                  @error("name.".$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'E-mail'])
                                      <input type="email" class="form-control" value="{{old('email')[$i] ??  "" }}" name="email[{{$i}}]" placeholder="E-mail" maxlength="150" id="email{{$i}}" />
                                      <span style="color: red; font-size: 12px" id="caracsRestantesemail{{$i}}">
                                      </span>
                                      @error('email.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Data de nascimento'])
                                      <input type="date" class="form-control"  value="{{old('data_de_nascimento')[$i] ??  "" }}" name="data_de_nascimento[{{$i}}]" placeholder="Data de nascimento" />
                                      @error('data_de_nascimento.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'CPF'])
                                      <input type="text" class="form-control cpf" value="{{old('cpf')[$i] ??  "" }}" name="cpf[{{$i}}]" placeholder="CPF"  />
                                      
                                      @error('cpf.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'RG'])
                                      <input type="number" class="form-control"  min="1" maxlength="12" value="{{old('rg')[$i] ??  ""  }}" name="rg[{{$i}}]"  placeholder="RG" />
                                      @error('rg.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Celular'])
                                      <input type="tel" class="form-control celular"  value="{{old('celular')[$i] ??  "" }}" name="celular[{{$i}}]"  placeholder="Celular" />
                                      @error('celular.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>
                              <div class="col-md-12"><h5>Endereço</h5></div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'CEP'])
                                      <input type="text" class="form-control cep" value="{{old('cep')[$i] ??  "" }}" name="cep[{{$i}}]"  placeholder="CEP" />
                                      @error('cep.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>           
                                                  
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Estado'])
                                  <select name="uf[{{$i}}]"  id="estado" class="form-control"   style="visibility: visible" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($estados as $sigla => $nome)
                                      <option @if(old('uf')[$i] ??  "" == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
                                    @endforeach
                                  </select>
                                  @error('uf.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Cidade'])
                                      <input type="text" class="form-control" value="{{old('cidade')[$i] ??  "" }}" name="cidade[{{$i}}]"  placeholder="Cidade" maxlength="50" id="cidade{{$i}}" />
                                      <span style="color: red; font-size: 12px" id="caracsRestantescidade{{$i}}">
                                      </span>
                                      @error('cidade.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Bairro'])
                                      <input type="text" class="form-control" value="{{old('bairro')[$i] ??  "" }}" name="bairro[{{$i}}]"  placeholder="Bairro" maxlength="50" id="bairro{{$i}}"/>
                                      <span style="color: red; font-size: 12px" id="caracsRestantesbairro{{$i}}">
                                      </span>
                                      @error('bairro.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Rua'])
                                      <input type="text" class="form-control" value="{{old('rua')[$i] ??  "" }}" name="rua[{{$i}}]" placeholder="Rua" maxlength="100" id="rua{{$i}}" />
                                      <span style="color: red; font-size: 12px" id="caracsRestantesrua{{$i}}">
                                      </span>
                                      @error('rua.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Número'])
                                      <input type="text" class="form-control" value="{{old('numero')[$i] ??   "" }}" name="numero[{{$i}}]"  placeholder="Número" />
                                      @error('numero.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-12">
                                <div class="form-group">
                                  <label class=" control-label" for="firstname">Complemento</label>
                                  <input type="text" class="form-control" value="{{old('complemento')[$i] ??  "" }}" name="complemento[{{$i}}]" placeholder="Complemento" maxlength="75" id="complemento{{$i}}" />
                                  <span style="color: red; font-size: 12px" id="caracsRestantescomplemento{{$i}}">
                                  </span>  
                                  @error('complemento.'.$i)
                                      <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>
                              </div>
                              <div class="col-md-12"><h5>Dados do curso</h5></div>                               
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Universidade'])
                                      <input type="text" class="form-control" value="{{old('instituicao')[$i] ??  "" }}" name="instituicao[{{$i}}]"  placeholder="Universidade" />
                                      @error('instituicao.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Curso'])
                                      <input type="text" class="form-control" value="{{old('curso')[$i] ??  "" }}" name="curso[{{$i}}]"  placeholder="Curso" />
                                      @error('curso.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Turno'])
                                  <select  name="turno[{{$i}}]"  class="form-control" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($enum_turno as $key => $value)
                                      <option @if(old('turno')[$i] ??  "" == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                  </select>
                                  @error('turno.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>
                              @php
                                $options = array('6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12); 
                              @endphp                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Total de períodos do curso'])
                                  <select  name="total_periodos[{{$i}}]"   class="form-control" onchange="gerarPeriodo(this)" >
                                    <option value=""  selected>-- Selecione uma opção --</option>
                                    @foreach ($options as $key => $value)
                                      <option @if(old('total_periodos')[$i]  ??  "" == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                  </select>
                                  @error('total_periodos.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Período atual'])
                                  <select name="periodo_atual[]"  class="form-control"  >
                                    <option selected value="{{ old('periodo_atual')[$i]  ?? "" }}">{{ old('periodo_atual')[$i]  ??  "" }}</option>
                                  </select>
                                  @error('periodo_atual.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                  <select name="ordem_prioridade[]"  class="form-control" >
                                    <option value=""  selected>-- ORDEM --</option>
                                    @for($j = 1; $j <= 3; $j++)
                                      <option @if(old('ordem_prioridade')[$i]  ??  "" == $j ) selected @endif value="{{ $j }}">{{ $j }}</option>  
                                    @endfor
    
                                  </select>
                                  @error('ordem_prioridade.'.$i)
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                                    <input type="number" class="form-control media" value="{{old('media_do_curso')[$i] ??  "" }}" name="media_do_curso[{{$i}}]"  min="0" max="10" step="0.01"  >
                                    @error('media_do_curso.'.$i)
                                      <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    @endcomponent
                              </div>
                              <div class="col-md-12"><h5>Plano de trabalho</h5></div>                              
                              <div class="col-12">
                                    @component('componentes.input', ['label' => 'Título'])
                                      <input type="text" class="form-control" value="{{old('nomePlanoTrabalho')[$i] ??  "" }}" name="nomePlanoTrabalho[{{$i}}]"  placeholder="Digite o título do plano de trabalho" maxlength="255" id="nomePlanoTrabalho{{$i}}">
                                      <span style="color: red; font-size: 12px" id="caracsRestantesnomePlanoTrabalho{{$i}}">
                                    </span>
                                      @error('nomePlanoTrabalho.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                              </div>                              
                              <div class="col-6">
                                    @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                                      <input type="file" class="input-group-text" value="{{old('anexoPlanoTrabalho')[$i] ?? "" }}" name="anexoPlanoTrabalho[{{$i}}]"  accept=".pdf" placeholder="Anexo do Plano de Trabalho" />
                                      @error('anexoPlanoTrabalho.'.$i)
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                      @error('anexoPlanoTrabalho')
                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    @endcomponent
                                    {{-- <div class="row justify-content-center">
                                      <div class="col-3 ">
                                        <a href="{{ route('baixar.plano', ['id' => $p->planoTrabalho->id]) }}">
                                        <i class="fas fa-file-pdf fa-2x"></i></a>
                                      </div>
                                    </div> --}}
                              </div>                              
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              
            @endfor
            
          </div>
        </div>        
        
      </li>

    </ol>

  </div>
</div>
<!--X Participantes X-->

