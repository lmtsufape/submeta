<!-- Participantes -->
@php $cont= 0; @endphp
<!-- <div class="col-md-12" style="margin-top: 20px"> -->
<!-- <div style="border-radius: 5px"> -->
<!-- <div style="padding-top: 0.2rem;"> -->
<!-- <div class="container"> -->
<!-- <div class="form-row mt-3">
                    <div class="col-md-11">
                        <h5 style="color: #234B8B; font-weight: bold">Dados do(s) Discente(s)</h5>
                        <strong>
                            <p>O plano de trabalho deve ser anexado junto aos dados do discente.</p>
                        </strong>
                    </div>


                    <div class="col-md-1 text-sm-right">
                        <a type="button" value="{{ $edital->id }}" id="atribuir1" data-toggle="modal" data-target="#exampleModal0">
                            <img class="" src="{{ asset('img/icons/add.ico') }}" style="width:30px" alt="">
                        </a>
                    </div>
                </div> -->
<!-- <hr style="border-top: 1px solid#1492E6">
                <h6 style="color: #234B8B; font-weight: bold">Participantes</h6> -->
<div class="row-cols-sm-12 justify-content-start">
    <ol style="counter-reset: item;list-style-type: none; margin-left:-20px; margin-right:20px; margin-top:10px">
        <li id="item">
            <div style="margin-bottom:15px">
                <div id="participante" class="row">
                    <!-- @for ($i = 0; $i < $edital->numParticipantes; $i++) -->

                    <div @if (!isset(old('marcado')[$i])) hidden @endif class="form-row mb-1 col-md-6"
                        style="margin-top: 10px" id="part{{ $i }}">
                        <div class="col-sm-2" style="display: flex; align-items: center;">
                            <img src="{{ asset('img/icons/usuario.svg') }}" style="width:60px" alt="">
                        </div>
                        <div class="col-sm-10" style="display: flex; align-items: center;">
                            <div class="col-sm-12">
                                <h6>
                                    @if (isset(old('integrantes')[$i]))
                                        <input name="integrantes[{{ $i }}]"
                                            value="{{ old('integrantes')[$i] }}" type="hidden" />
                                    @endif
                                    <a id="nomePlano{{ $i + 1 }}">
                                        @if (isset(old('marcado')[$i]))
                                            @if (isset(old('name')[$i]))
                                                Nome: {{ old('name')[$i] }}
                                            @else
                                                Discente {{ $i + 1 }}
                                            @endif
                                            @if (isset(old('nomePlanoTrabalho')[$i]))
                                                <br> Plano: {{ old('nomePlanoTrabalho')[$i] }}
                                            @endif
                                            @if (isset(old('email')[$i]))
                                                <br> E-mail: {{ old('email')[$i] }}
                                            @endif
                                            @if (isset(old('cpf')[$i]))
                                                <br> CPF: {{ old('cpf')[$i] }}
                                            @endif
                                            @if (isset(old('funcaoParticipante')[$i]))
                                                <br> Função: {{ old('funcaoParticipante')[$i] }}
                                            @endif
                                        @endif
                                    </a><br>
                                    <a href="" style="" class="justify-content-center" data-toggle="modal"
                                        data-target="#exampleModal{{ $i }}"
                                        id="nomePart{{ $i + 1 }}">Mais Informações</a>
                                </h6>
                                <div class="col-sm-5 pl-0" style="margin-top: 10px; text-align: left;">
                                    <button data-dismiss="modal" type="button" id="cancelar{{ $i }}"
                                        class=" btn btn-danger btn-sm" style="font-size: 12px"
                                        onclick="desmarcar({{ $i }})"
                                        @if (isset(old('marcado')[$i + 1])) disabled @endif>Remover</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal{{ $i }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:auto;">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Dados do Integrante
                                        {{ $i + 1 }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="col-1" style="margin-top:9.3px" hidden>
                                        {{-- <button type="button" class="btn btn-danger shadow-sm" id="buttonRemover" onclick="removerPart(this)" >X</button> --}}
                                        <input type="hidden" name="estudante[{{ $i }}]"
                                            id="estudante[{{ $i }}]">
                                        <input type="checkbox" id="checkB{{ $i }}"
                                            aria-label="Checkbox for following text input"
                                            @if (isset(old('marcado')[$i])) checked @endif name="marcado[]"
                                            value="{{ $i }}">
                                    </div>


                                    <div class="col-md-12">
                                        <div class="container">
                                            <div class="row">
                                                <input type="hidden" name="funcaoParticipante[{{ $i }}]"
                                                    id="funcaoParticipante{{ $i }}"
                                                    value="{{ old('funcaoParticipante')[$i] ?? '' }}">
                                                <div class="col-md-12 mt-3">
                                                    <h5>Dados do integrante</h5>
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Nome completo'])
                                                        <input readonly type="text" class="form-control "
                                                            value="{{ old('name')[$i] ?? '' }}"
                                                            name="name[{{ $i }}]" placeholder="Nome Completo"
                                                            maxlength="150" id="nome{{ $i }}" />
                                                        <span style="color: red; font-size: 12px"
                                                            id="caracsRestantesnome{{ $i }}">
                                                        </span>
                                                        @error('name.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'E-mail'])
                                                        <input readonly type="email" class="form-control"
                                                            value="{{ old('email')[$i] ?? '' }}"
                                                            name="email[{{ $i }}]" placeholder="E-mail"
                                                            maxlength="150" id="email{{ $i }}" />
                                                        <span style="color: red; font-size: 12px"
                                                            id="caracsRestantesemail{{ $i }}">
                                                        </span>
                                                        @error('email.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Data de nascimento'])
                                                        <input readonly type="text" class="form-control"
                                                            value="{{ old('data_de_nascimento')[$i] ?? '' }}"
                                                            name="data_de_nascimento[{{ $i }}]"
                                                            placeholder="Data de nascimento"
                                                            id="data_de_nascimento{{ $i }}" />
                                                        @error('data_de_nascimento.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'CPF'])
                                                        <input readonly type="text" class="form-control cpf"
                                                            value="{{ old('cpf')[$i] ?? '' }}"
                                                            name="cpf[{{ $i }}]" placeholder="CPF"
                                                            id="cpf{{ $i }}" />

                                                        @error('cpf.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'RG'])
                                                        <input readonly type="text" class="form-control rg"
                                                            min="9" maxlength="9"
                                                            value="{{ old('rg')[$i] ?? '' }}"
                                                            name="rg[{{ $i }}]" placeholder="RG"
                                                            id="rg{{ $i }}" />
                                                        @error('rg.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Celular'])
                                                        <input readonly type="tel" class="form-control celular"
                                                            value="{{ old('celular')[$i] ?? '' }}"
                                                            name="celular[{{ $i }}]" placeholder="Celular"
                                                            id="celular{{ $i }}" />
                                                        @error('celular.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-md-12">
                                                    <h5>Endereço</h5>
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'CEP'])
                                                        <input readonly name="cep[{{ $i }}]" type="text"
                                                            id="cep{{ $i }}"
                                                            value="{{ old('cep')[$i] ?? '' }}" class="form-control cep"
                                                            onblur="pesquisacep(this.value, {{ $i }})"
                                                            id="cep{{ $i }}" />
                                                        @error('cep.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Estado'])
                                                        <input readonly name="uf[{{ $i }}]" type="text"
                                                            class="form-control" value="{{ old('uf')[$i] ?? '' }}"
                                                            id="uf{{ $i }}" />
                                                        @error('uf.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Cidade'])
                                                        <input readonly name="cidade[{{ $i }}]" type="text"
                                                            id="cidade{{ $i }}" class="form-control"
                                                            value="{{ old('cidade')[$i] ?? '' }}"
                                                            id="cidade{{ $i }}" />
                                                        @error('cidade.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Bairro'])
                                                        <input readonly name="bairro[{{ $i }}]" type="text"
                                                            id="bairro{{ $i }}" class="form-control"
                                                            value="{{ old('bairro')[$i] ?? '' }}"
                                                            id="bairro{{ $i }}" />
                                                        @error('bairro.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Rua'])
                                                        <input readonly name="rua[{{ $i }}]" type="text"
                                                            id="rua{{ $i }}" class="form-control"
                                                            value="{{ old('rua')[$i] ?? '' }}"
                                                            id="rua{{ $i }}" />
                                                        @error('rua.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Número'])
                                                        <input readonly name="numero[{{ $i }}]" type="text"
                                                            class="form-control" value="{{ old('numero')[$i] ?? '' }}"
                                                            id="numero{{ $i }}" />
                                                        @error('numero.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                                        @enderror
                                                    @endcomponent
                                                </div>





                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class=" control-label"
                                                            for="firstname">Complemento</label>
                                                        <input readonly type="text" class="form-control"
                                                            value="{{ old('complemento')[$i] ?? '' }}"
                                                            name="complemento[{{ $i }}]"
                                                            placeholder="Complemento" maxlength="75"
                                                            id="complemento{{ $i }}" />
                                                        <span style="color: red; font-size: 12px"
                                                            id="caracsRestantescomplemento{{ $i }}">
                                                        </span>
                                                        @error('complemento.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h5>Dados do curso</h5>
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Instituição de Ensino'])
                                                        <!-- <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao[{{ $i }}]" id="instituicao[{{ $i }}]">
                                                                                <option value="" disabled selected hidden>-- Instituição --</option>
                                                                                <option @if ((old('instituicao')[$i] ?? '') == 'UFAPE') ) selected @endif value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                                                                                <option @if ((old('instituicao')[$i] ?? '') == 'Outra') ) selected @endif value="Outra">Outra</option>
                                                                            </select> -->
                                                        <input readonly type="text" style="display: inline"
                                                            value="{{ old('instituicao')[$i] ?? '' }}"
                                                            class="form-control" name="instituicao[{{ $i }}]"
                                                            id="instituicao[{{ $i }}]">
                                                        @error('instituicao.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6" id="displayinstituicao[{{ $i }}]"
                                                    style='display:none'>
                                                    @component('componentes.input', ['label' => 'Digite a Instituição'])
                                                        <input readonly id="outrainstituicao[{{ $i }}]"
                                                            type="text"
                                                            class="form-control @error('instituicao') is-invalid @enderror"
                                                            name="outrainstituicao[{{ $i }}]"
                                                            value="{{ old('outrainstituicao')[$i] ?? '' }}"
                                                            placeholder="Digite o nome da Instituição"
                                                            autocomplete="instituicao" autofocus>
                                                        @error('outrainstituicao.' . $i)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Curso'])
                                                        <!-- <select style="display: inline" class="form-control" name="curso[{{ $i }}]" onchange="showCurso(this)" id="curso[{{ $i }}]">
                                                                                <option value="" disabled selected hidden>-- Selecione uma opção--</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Bacharelado em Agronomia') selected @endif value="Bacharelado em Agronomia">Bacharelado em Agronomia</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Bacharelado em Ciência da Computação') selected @endif value="Bacharelado em Ciência da Computação">Bacharelado em Ciência da Computação</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Bacharelado em Engenharia de Alimentos') selected @endif value="Bacharelado em Engenharia de Alimentos">Bacharelado em Engenharia de Alimentos</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Bacharelado em Medicina Veterinária') selected @endif value="Bacharelado em Medicina Veterinária">Bacharelado em Medicina Veterinária</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Bacharelado em Zootecnia') selected @endif value="Bacharelado em Zootecnia">Bacharelado em Zootecnia</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Licenciatura em Letras') selected @endif value="Licenciatura em Letras">Licenciatura em Letras</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Licenciatura em Pedagogia') selected @endif value="Licenciatura em Pedagogia">Licenciatura em Pedagogia</option>
                                                                                <option @if ((old('curso')[$i] ?? '') == 'Outro') selected @endif value="Outro">Outro</option>
                                                                            </select> -->
                                                        <input readonly type="text" style="display: inline"
                                                            value="{{ old('curso')[$i] ?? '' }}" class="form-control"
                                                            name="curso[{{ $i }}]"
                                                            id="curso[{{ $i }}]">
                                                        @error('curso.' . $i)
                                                            <span class="invalid-feedback" role="alert"
                                                                style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>
                                                <div class="col-6" id="displaycurso[{{ $i }}]"
                                                    style='display:none'>
                                                    @component('componentes.input', ['label' => 'Digite o nome do curso'])
                                                        <input readonly id="outrocurso[{{ $i }}]"
                                                            type="text" class="form-control"
                                                            name="outrocurso[{{ $i }}]"
                                                            value="{{ old('outrocurso')[$i] ?? '' }}"
                                                            placeholder="Digite o nome do curso" autocomplete="curso"
                                                            autofocus>
                                                        @error('outrocurso.' . $i)
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    @endcomponent
                                                </div>

                                                @if ($edital->natureza_id != 3)
                                                    <div class="col-6">
                                                        @component('componentes.select', ['label' => 'Turno'])
                                                            <select name="turno[{{ $i }}]"
                                                                class="form-control">
                                                                <option value="" selected>-- Selecione uma opção --
                                                                </option>
                                                                @foreach ($enum_turno as $key => $value)
                                                                    <option
                                                                        @if ((old('turno')[$i] ?? '') == $value) selected @endif
                                                                        value="{{ $value }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('turno.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>
                                                    @php
                                                        $options = [
                                                            '3' => 3,
                                                            '4' => 4,
                                                            '5' => 5,
                                                            '6' => 6,
                                                            '7' => 7,
                                                            '8' => 8,
                                                            '9' => 9,
                                                            '10' => 10,
                                                            '11' => 11,
                                                            '12' => 12,
                                                        ];
                                                    @endphp
                                                    <div class="col-6">
                                                        @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
                                                            <select readonly name="total_periodos[{{ $i }}]"
                                                                class="form-control" onchange="gerarPeriodo(this)">
                                                                <option value="" selected>-- Selecione uma opção --
                                                                </option>
                                                                @foreach ($options as $key => $value)
                                                                    <option
                                                                        @if ((old('total_periodos')[$i] ?? '') == $key) selected @endif
                                                                        value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('total_periodos.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-6">
                                                        @component('componentes.select', ['label' => 'Período/Ano atual'])
                                                            <select name="periodo_atual[]" class="form-control">
                                                                <option value="" selected>-- Selecione uma opção --
                                                                </option>
                                                                @if (old('periodo_atual')[$i] ?? '')
                                                                    <option selected
                                                                        value="{{ old('periodo_atual')[$i] ?? '' }}">
                                                                        {{ old('periodo_atual')[$i] ?? '' }}</option>
                                                                @endif

                                                            </select>
                                                            @error('periodo_atual.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>

                                                    @if ($edital->tipo != 'PICP')
                                                        <div class="col-6">
                                                            @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                                                <select name="ordem_prioridade[]" class="form-control">
                                                                    <option value="" selected>-- ORDEM --</option>
                                                                    @for ($j = 1; $j <= $edital->numParticipantes; $j++)
                                                                        <option
                                                                            @if ((old('ordem_prioridade')[$i] ?? '') == $j) selected @endif
                                                                            value="{{ $j }}">
                                                                            {{ $j }}</option>
                                                                    @endfor

                                                                </select>
                                                                @error('ordem_prioridade.' . $i)
                                                                    <span class="invalid-feedback" role="alert"
                                                                        style="overflow: visible; display:block">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            @endcomponent
                                                        </div>
                                                    @endif


                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'Coeficiente de rendimento (média geral)'])
                                                            <input type="number" class="form-control media"
                                                                value="{{ old('media_do_curso')[$i] ?? '' }}"
                                                                name="media_do_curso[{{ $i }}]"
                                                                min="0" max="10" step="0.01"
                                                                oninput="validarMedia(this)">
                                                            @error('media_do_curso.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>
                                                @endif

                                                <div style="display: block"
                                                    @if (old('funcaoParticipante') == null ||
                                                            !array_key_exists($i, old('funcaoParticipante')) ||
                                                            old('funcaoParticipante')[$i] == 'Bolsista') @else hidden @endif>

                                                    <div class="col-md-12" id="plano-titulo{{ $i }}">
                                                        <h5>Plano de trabalho</h5>
                                                    </div>
                                                    <div class="col-12" id="plano-nome{{ $i }}">
                                                        @component('componentes.input', ['label' => 'Título'])
                                                            <input type="text" class="form-control"
                                                                value="{{ old('nomePlanoTrabalho')[$i] ?? '' }}"
                                                                name="nomePlanoTrabalho[{{ $i }}]"
                                                                placeholder="Digite o título do plano de trabalho"
                                                                maxlength="255"
                                                                id="nomePlanoTrabalho{{ $i }}">
                                                            <span style="color: red; font-size: 12px"
                                                                id="caracsRestantesnomePlanoTrabalho{{ $i }}">
                                                            </span>
                                                            @error('nomePlanoTrabalho.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-12" id="plano-anexo{{ $i }}">
                                                        @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                                                            <input type="file" class="input-group-text"
                                                                value="{{ old('anexoPlanoTrabalho')[$i] ?? '' }}"
                                                                name="anexoPlanoTrabalho[{{ $i }}]"
                                                                accept=".pdf" placeholder="Anexo do Plano de Trabalho" />
                                                            @error('anexoPlanoTrabalho.' . $i)
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            @error('anexoPlanoTrabalho')
                                                                <span class="invalid-feedback" role="alert"
                                                                    style="overflow: visible; display:block">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        @endcomponent
                                                    </div>

                                                </div>

                                                {{-- <div class="col-6">
                                                                        <button data-dismiss="modal" type="button" id="cancelar{{$i}}" class=" btn btn-danger" style="font-size: 16px" onclick="desmarcar({{$i}})" @if (isset(old('marcado')[$i + 1])) disabled @endif>Cancelar</button>
                                                                </div> --}}
                                                <div class="col-6">
                                                    <button data-dismiss="modal" type="button"
                                                        class="btn btn-secondary float-left"
                                                        style="font-size: 16px">Sair</button>
                                                </div>
                                                <div class="col-6">
                                                    <button data-dismiss="modal" type="button"
                                                        id="guardar{{ $i }}"
                                                        class="btn btn-success float-right" style="font-size: 16px"
                                                        onclick="marcar({{ $i }})">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- @endfor -->

                </div>

        </li>

    </ol>
</div>

<!-- </div> -->
<!-- </div> -->
<!-- </div> -->
<!-- </div> -->

<!-- Adicionando Javascript -->
<script>
    function limpa_formulário_cep(id) {
        //Limpa valores do formulário de cep.
        document.getElementById(`rua${id}`).value = ("");
        document.getElementById(`bairro${id}`).value = ("");
        document.getElementById(`cidade${id}`).value = ("");
        document.getElementById(`uf${id}`).value = ("");
        //document.getElementById('ibge').value=("");
    }

    let cont = 0; //Esse cont representa a adição de cada aluno
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById(`rua${cont}`).value = (conteudo.logradouro);
            document.getElementById(`bairro${cont}`).value = (conteudo.bairro);
            document.getElementById(`cidade${cont}`).value = (conteudo.localidade);
            document.getElementById(`uf${cont}`).value = (conteudo.uf);


            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep(cont);
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor, id) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById(`rua${id}`).value = "...";
                document.getElementById(`bairro${id}`).value = "...";
                document.getElementById(`cidade${id}`).value = "...";
                document.getElementById(`uf${id}`).value = "...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                cont = id
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep(id);
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep(id);
        }
    };

    function validarMedia(input) {
        let valor = parseFloat(input.value);
        if (valor > 10) {
            input.value = 10;
        } else if (valor < 0) {
            input.value = 0;
        }
    }
</script>
