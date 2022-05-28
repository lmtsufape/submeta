<!-- Participantes -->
<div class="col-md-12" style="margin-top: 20px">
    <div class="card" style="border-radius: 5px">
        <div class="card-body" style="padding-top: 0.2rem;">
            <div class="container">
                <div class="form-row mt-3">
                    <div class="col-md-11"><h5 style="color: #234B8B; font-weight: bold">Dados do(s) Discente(s)</h5></div>
                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="{{ $edital->id }}" id="atribuir1" data-toggle="modal" data-target="#exampleModal0">
                            <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                        </a>
                    </div>
                </div>
                <hr style="border-top: 1px solid#1492E6">
                <div class="row-cols-sm-12 justify-content-start">
                    <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
                        <li id="item">
                            <div style="margin-bottom:15px">
                                <div id="participante" class="row">
                                    @for($i = 0; $i < $edital->numParticipantes; $i++)

                                        <div @if(!isset(old('marcado')[$i])) hidden @endif class="form-row mb-1 col-md-3" style="margin-top: 10px" id="part{{$i}}">
                                            <div class="col-sm-4" style="display: flex; align-items: center;">
                                                <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                                            </div>
                                            <div class="col-sm-8" style="display: flex; align-items: center;">
                                                <a href="" style="" class="justify-content-center" data-toggle="modal" data-target="#exampleModal{{$i}}" id="nomePart{{$i+1}}">
                                                    Discente {{$i+1}}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="exampleModal{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Dados do Discente {{$i+1}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="col-1" style="margin-top:9.3px" hidden>
                                                            {{-- <button type="button" class="btn btn-danger shadow-sm" id="buttonRemover" onclick="removerPart(this)" >X</button> --}}
                                                            <input type="checkbox" id="checkB{{$i}}" aria-label="Checkbox for following text input"  @if(isset(old('marcado')[$i])) checked @endif name="marcado[]" value="{{ $i }}">
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <input type="hidden"  name="funcaoParticipante[]" value="4">
                                                                    <div class="col-md-12 mt-3"><h5>Dados do discente</h5></div>
                                                                    <div class="col-6">
                                                                        @component('componentes.input', ['label' => 'Nome completo'])
                                                                            <input type="text" class="form-control " value="{{old('name')[$i] ?? "" }}"  name="name[{{$i}}]" placeholder="Nome Completo" maxlength="150" id="nome{{$i}}"/>
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
                                                                            <input type="email" class="form-control" value="{{old('email')[$i] ?? "" }}" name="email[{{$i}}]" placeholder="E-mail" maxlength="150" id="email{{$i}}" />
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
                                                                            <input type="date" class="form-control"  value="{{old('data_de_nascimento')[$i] ?? "" }}" name="data_de_nascimento[{{$i}}]" placeholder="Data de nascimento" />
                                                                            @error('data_de_nascimento.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @component('componentes.input', ['label' => 'CPF'])
                                                                            <input type="text" class="form-control cpf" value="{{old('cpf')[$i] ?? "" }}" name="cpf[{{$i}}]" placeholder="CPF"  />

                                                                            @error('cpf.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @component('componentes.input', ['label' => 'RG'])
                                                                            <input type="text" class="form-control rg"  min="9" maxlength="9" value="{{old('rg')[$i] ?? "" }}" name="rg[{{$i}}]"  placeholder="RG" />
                                                                            @error('rg.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @component('componentes.input', ['label' => 'Celular'])
                                                                            <input type="tel" class="form-control celular"  value="{{old('celular')[$i] ?? "" }}" name="celular[{{$i}}]"  placeholder="Celular" />
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
                                                                            <input type="text" class="form-control cep" value="{{old('cep')[$i] ?? "" }}" name="cep[{{$i}}]"  placeholder="CEP" />
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
                                                                                    <option @if(old('uf')[$i] ?? "" == $sigla ) selected @endif value="{{ $sigla }}">{{ $nome }}</option>
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
                                                                            <input type="text" class="form-control" value="{{old('cidade')[$i] ?? "" }}" name="cidade[{{$i}}]"  placeholder="Cidade" maxlength="50" id="cidade{{$i}}" />
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
                                                                            <input type="text" class="form-control" value="{{old('bairro')[$i] ?? "" }}" name="bairro[{{$i}}]"  placeholder="Bairro" maxlength="50" id="bairro{{$i}}" />
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
                                                                            <input type="text" class="form-control" value="{{old('rua')[$i] ?? "" }}" name="rua[{{$i}}]" placeholder="Rua" maxlength="100" id="rua{{$i}}" />
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
                                                                            <input type="text" class="form-control" value="{{old('numero')[$i] ?? "" }}" name="numero[{{$i}}]"  placeholder="Número" />
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
                                                                            <input type="text" class="form-control" value="{{old('complemento')[$i] ?? "" }}" name="complemento[{{$i}}]"    placeholder="Complemento" maxlength="75" id="complemento{{$i}}"/>
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
                                                                        @component('componentes.input', ['label' => 'Instituição de Ensino'])
                                                                            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao[{{$i}}]">
                                                                                <option value="" disabled selected hidden>-- Instituição --</option>
                                                                                <option @if(old('instituicao')[$i] ?? "" == 'UFAPE' ) selected @endif value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                                                                                <option @if(old('instituicao')[$i] ?? "" == 'Outra' ) selected @endif value="Outra" >Outra</option>
                                                                            </select>
                                                                            @error('instituicao.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6" id="displayinstituicao[{{$i}}]" style='display:none'>
                                                                        @component('componentes.input', ['label' => 'Digite a Instituição'])
                                                                            <input id="outrainstituicao[{{$i}}]" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="outrainstituicao[{{$i}}]" value="{{ old('outrainstituicao')[$i] ?? "" }}" placeholder="Digite o nome da Instituição" autocomplete="instituicao" autofocus>
                                                                            @error('outrainstituicao.'.$i)
                                                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6">
                                                                        @component('componentes.input', ['label' => 'Curso'])
                                                                            <select style="display: inline" class="form-control" name="curso[{{$i}}]" onchange="showCurso(this)">
                                                                                <option value="" disabled selected hidden>-- Selecione uma opção--</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Bacharelado em Agronomia' ) selected @endif value="Bacharelado em Agronomia">Bacharelado em Agronomia</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Bacharelado em Ciência da Computação' ) selected @endif value="Bacharelado em Ciência da Computação">Bacharelado em Ciência da Computação</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Bacharelado em Engenharia de Alimentos' ) selected @endif value="Bacharelado em Engenharia de Alimentos">Bacharelado em Engenharia de Alimentos</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Bacharelado em Medicina Veterinária' ) selected @endif value="Bacharelado em Medicina Veterinária">Bacharelado em Medicina Veterinária</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Bacharelado em Zootecnia' ) selected @endif value="Bacharelado em Zootecnia">Bacharelado em Zootecnia</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Licenciatura em Letras' ) selected @endif value="Licenciatura em Letras">Licenciatura em Letras</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Licenciatura em Pedagogia' ) selected @endif value="Licenciatura em Pedagogia">Licenciatura em Pedagogia</option>
                                                                                <option @if(old('curso')[$i] ?? "" == 'Outro' ) selected @endif value="Outro" >Outro</option>
                                                                            </select>
                                                                            @error('curso.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    <div class="col-6" id="displaycurso[{{$i}}]" style='display:none'>
                                                                        @component('componentes.input', ['label' => 'Digite o nome do curso'])
                                                                            <input id="outrocurso[{{$i}}]" type="text" class="form-control" name="outrocurso[{{$i}}]" value="{{ old('outrocurso')[$i] ?? "" }}" placeholder="Digite o nome do curso" autocomplete="curso" autofocus>
                                                                            @error('outrocurso.'.$i)
                                                                            <span class="invalid-feedback" role="alert">
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
                                                                                    <option @if(old('turno')[$i] ?? "" == $value ) selected @endif value="{{ $value }}">{{ $value }}</option>
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
                                                                        $options = array('3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,'8' => 8,'9' => 9,'10' => 10,'11' => 11,'12' => 12);
                                                                    @endphp
                                                                    <div class="col-6">
                                                                        @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
                                                                            <select  name="total_periodos[{{$i}}]"   class="form-control" onchange="gerarPeriodo(this)" >
                                                                                <option value=""  selected>-- Selecione uma opção --</option>
                                                                                @foreach ($options as $key => $value)
                                                                                    <option @if(old('total_periodos')[$i]  ?? "" == $key ) selected @endif value="{{ $key }}">{{ $value }}</option>
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
                                                                        @component('componentes.select', ['label' => 'Período/Ano atual'])
                                                                            <select name="periodo_atual[]"  class="form-control"  >
                                                                                <option value=""  selected>-- Selecione uma opção --</option>

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
                                                                                @for($j = 1; $j <= $edital->numParticipantes; $j++)
                                                                                    <option @if(old('total_periodos')[$i]  ?? "" == $j ) selected @endif value="{{ $j }}">{{ $j }}</option>
                                                                                @endfor

                                                                            </select>
                                                                            @error('ordem_prioridade.'.$i)
                                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                                                            @enderror
                                                                        @endcomponent
                                                                    </div>
                                                                    @if($edital->tipo != "PIBEX")

                                                                        <div class="col-6">
                                                                            @component('componentes.input', ['label' => 'Coeficiente de rendimento (média geral)'])
                                                                                <input type="number" class="form-control media" value="{{old('media_do_curso')[$i] ?? "" }}" name="media_do_curso[{{$i}}]"  min="0" max="10" step="0.01"  >
                                                                                @error('media_do_curso.'.$i)
                                                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                                                                @enderror
                                                                            @endcomponent
                                                                        </div>
                                                                    @endif
                                                                    <div class="col-md-12"><h5>Plano de trabalho</h5></div>
                                                                    <div class="col-12">
                                                                        @component('componentes.input', ['label' => 'Título'])
                                                                            <input type="text" class="form-control" value="{{old('nomePlanoTrabalho')[$i] ?? "" }}" name="nomePlanoTrabalho[{{$i}}]"  placeholder="Digite o título do plano de trabalho" maxlength="255" id="nomePlanoTrabalho{{$i}}">
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
                                                                        <button data-dismiss="modal" type="button" id="cancelar{{$i}}" class=" btn btn-danger" style="font-size: 16px" onclick="desmarcar({{$i}})">Cancelar</button>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <button data-dismiss="modal" type="button" id="guardar{{$i}}" class="btn btn-success float-right" style="font-size: 16px" onclick="marcar({{$i}})">Salvar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    @endfor

                                </div>
                            </div>

                        </li>

                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
<script>


</script>
<!--X Participantes X-->
