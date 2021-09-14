<!-- Verificação para definir se a informação do modal será o formulário para substituição ou apenas visualização-->
@if($visualizarOnly ?? '')
<!-- Apenas visualização-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h5>Dados do discente</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Nome completo'])
            <input type="text" class="form-control " value="{{$participante->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$participante->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'E-mail'])
            <input type="email" class="form-control" value="{{$participante->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$participante->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row"> 
        <div class="col-6">
            @component('componentes.input', ['label' => 'Data de nascimento'])
            <input type="date" class="form-control" value="{{$participante->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.input', ['label' => 'CPF'])
            <input type="text" class="form-control cpf" value="{{$participante->user->cpf}}" name="cpf" placeholder="CPF" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'RG'])
            <input type="number" class="form-control" min="1" maxlength="12" value="{{$participante->rg}}" name="rg" placeholder="RG" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Celular'])
            <input type="tel" class="form-control celular" value="{{$participante->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Endereço</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'CEP'])
            <input type="text" class="form-control cep" value="{{$participante->user->endereco->cep}}" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="{{$participante->user->endereco->uf}}" selected>{{$participante->user->endereco->uf}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value="{{$participante->user->endereco->cidade}}" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$participante->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="{{$participante->user->endereco->bairro}}" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$participante->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="{{$participante->user->endereco->rua}}" name="rua" placeholder="Rua" maxlength="100" id="rua{{$participante->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="{{$participante->user->endereco->numero}}" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="{{$participante->user->endereco->complemento}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$participante->id}}" disabled />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Dados do curso</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Instituição de Ensino'])
            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$participante->id}}]" disabled>
                <option value="{{$participante->user->instituicao}}" disabled selected hidden>{{$participante->user->instituicao}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Curso'])
            <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$participante->id}}]" disabled>
                <option value="{{$participante->curso}}" disabled selected hidden>{{$participante->curso}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Turno'])
            <select name="turno" class="form-control" disabled>
                <option value="{{$participante->turno}}" selected>{{$participante->turno}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
            <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                <option value="{{$participante->total_periodos}}" selected>{{$participante->total_periodos}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Período/Ano atual'])
            <select name="periodo_atual" class="form-control" disabled>
                <option value="{{$participante->periodo_atual}}" selected>{{$participante->periodo_atual}}</option>
            </select>
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.select', ['label' => 'Ordem de prioridade'])
            <select name="ordem_prioridade" class="form-control" disabled>
                <option value="{{$participante->ordem_prioridade}}" selected>{{$participante->ordem_prioridade}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
            <input type="number" class="form-control media" value="{{$participante->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Plano de trabalho</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        @if($participante->planoTrabalho)
        <div class="col-6">
            <h6>{{$participante->planoTrabalho->titulo}}</h6>
        </div>
        <div class="col-6">
            <a href="{{ route('baixar.plano', ['id' => $participante->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-3 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
</div>







@else







<form method="POST" id="SubParticForm" action="{{route('trabalho.infoTrocaParticipante')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="editalId" value="{{$edital->id}}">
    <input type="hidden" name="participanteId" value="{{$participante->id}}">
    <input type="hidden" name="projetoId" value="{{$projeto->id}}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="check" id="apenasPlano{{$participante->id}}" name="substituirApenasPlanoCheck" onchange="substituirApenasPlano(this)">
                <label class="form-check-label" for="apenasPlano{{$participante->id}}">
                    Substituir apenas o plano de trabalho
                </label>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <h5>Dados do discente</h5>
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Nome completo'])
                <input type="text" class="form-control " @value="" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$participante->id}}" required />
                <span style="color: red; font-size: 12px" id="caracsRestantesnome{{$participante->id}}">
                </span>
                @error("name")
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'E-mail'])
                <input type="email" class="form-control" value="" name="email" placeholder="E-mail" maxlength="150" id="email{{$participante->id}}" required />
                <span style="color: red; font-size: 12px" id="caracsRestantesemail{{$participante->id}}">
                </span>
                @error('email')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Data de nascimento'])
                <input type="date" class="form-control" value="" name="data_de_nascimento" placeholder="Data de nascimento" id="nascimento{{$participante->id}}" required />
                @error('data_de_nascimento')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.input', ['label' => 'CPF'])
                <input type="text" class="form-control cpf" value="" name="cpf" placeholder="CPF" id="cpf{{$participante->id}}" required />

                @error('cpf')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'RG'])
                <input type="number" class="form-control" min="1" maxlength="12" value="" name="rg" placeholder="RG" id="rg{{$participante->id}}" required />
                @error('rg')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Celular'])
                <input type="tel" class="form-control celular" value="" name="celular" placeholder="Celular" id="celular{{$participante->id}}" required />
                @error('celular')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
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
                <input type="text" class="form-control cep" value="" name="cep" placeholder="CEP" id="cep{{$participante->id}}" required />
                @error('cep')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.select', ['label' => 'Estado'])
                <select name="uf" class="form-control" style="visibility: visible" id="estado{{$participante->id}}" required>
                    <option value="" selected>-- Selecione uma opção --</option>
                    @foreach ($estados as $sigla => $nome)
                    <option value="{{ $sigla }}">{{ $nome }}</option>
                    @endforeach
                </select>
                @error('uf')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.input', ['label' => 'Cidade'])
                <input type="text" class="form-control" value="" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$participante->id}}" required />
                <span style="color: red; font-size: 12px" id="caracsRestantescidade{{$participante->id}}">
                </span>
                @error('cidade')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Bairro'])
                <input type="text" class="form-control" value="" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$participante->id}}" required />
                <span style="color: red; font-size: 12px" id="caracsRestantesbairro{{$participante->id}}">
                </span>
                @error('bairro')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Rua'])
                <input type="text" class="form-control" value="" name="rua" placeholder="Rua" maxlength="100" id="rua{{$participante->id}}" required />
                <span style="color: red; font-size: 12px" id="caracsRestantesrua{{$participante->id}}">
                </span>
                @error('rua')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Número'])
                <input type="text" class="form-control" value="" name="numero" placeholder="Número" id="numero{{$participante->id}}" required />
                @error('numero')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class=" control-label" for="firstname">Complemento</label>
                    <input type="text" class="form-control" value="" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$participante->id}}" />
                    <span style="color: red; font-size: 12px" id="caracsRestantescomplemento{{$participante->id}}">
                    </span>
                    @error('complemento')
                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
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
                <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$participante->id}}]" required>
                    <option value="" disabled selected hidden>-- Instituição --</option>
                    <option value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                    <option value="Outra">Outra</option>
                </select>
                @error('instituicao')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6" id="displayinstituicao[{{$participante->id}}]" style='display:none'>
                @component('componentes.input', ['label' => 'Digite a Instituição'])
                <input id="outrainstituicao[{{$participante->id}}]" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="outrainstituicao" value="" placeholder="Digite o nome da Instituição" autocomplete="instituicao" autofocus>
                @error('outrainstituicao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.input', ['label' => 'Curso'])
                <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$participante->id}}]" required>
                    <option value="" disabled selected hidden>-- Selecione uma opção--</option>
                    <option value="Bacharelado em Agronomia">Bacharelado em Agronomia</option>
                    <option value="Bacharelado em Ciência da Computação">Bacharelado em Ciência da Computação</option>
                    <option value="Bacharelado em Engenharia de Alimentos">Bacharelado em Engenharia de Alimentos</option>
                    <option value="Bacharelado em Medicina Veterinária">Bacharelado em Medicina Veterinária</option>
                    <option value="Bacharelado em Zootecnia">Bacharelado em Zootecnia</option>
                    <option value="Licenciatura em Letras">Licenciatura em Letras</option>
                    <option value="Licenciatura em Pedagogia">Licenciatura em Pedagogia</option>
                    <option value="Outro">Outro</option>
                </select>
                @error('curso')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6" id="displaycurso[{{$participante->id}}]" style='display:none'>
                @component('componentes.input', ['label' => 'Digite o nome do curso'])
                <input id="outrocurso[{{$participante->id}}]" type="text" class="form-control" name="outrocurso" value="" placeholder="Digite o nome do curso" autocomplete="curso" autofocus>
                @error('outrocurso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.select', ['label' => 'Turno'])
                <select name="turno" class="form-control" id="turno{{$participante->id}}" required>
                    <option value="" selected>-- Selecione uma opção --</option>
                    @foreach ($enum_turno as $key => $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('turno')
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
                <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" id="periodosTotal{{$participante->id}}" required>
                    <option value="" selected>-- Selecione uma opção --</option>
                    @foreach ($options as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @error('total_periodos')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.select', ['label' => 'Período/Ano atual'])
                <select name="periodo_atual" class="form-control" id="periodo{{$participante->id}}" required>
                    <option value="" selected>-- Selecione uma opção --</option>

                </select>
                @error('periodo_atual')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.select', ['label' => 'Ordem de prioridade'])
                <select name="ordem_prioridade" class="form-control" id="ordem{{$participante->id}}" required>
                    <option value="" selected>-- ORDEM --</option>
                    @for($j = 1; $j <= 3; $j++) <option value="{{ $j }}">{{ $j }}</option>
                        @endfor

                </select>
                @error('ordem_prioridade')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
                <input type="number" class="form-control media" value="" name="media_do_curso" min="0" max="10" step="0.01" id="media{{$participante->id}}" required>
                @error('media_do_curso')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-md-12">
                <h5>Documentação Complementar</h5>
            </div>

            <div class="col-6">
                @component('componentes.input', ['label' => 'Termo de Compromisso (.pdf)'])
                <input type="file" class="input-group-text" value="" name="anexoTermoCompromisso" accept=".pdf" placeholder="Anexo do Termo de Compromisso" id="anexoTermoCompromisso{{$participante->id}}" required />
                @error('anexoTermoCompromisso')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Comprovante de Matrícula (.pdf)'])
                <input type="file" class="input-group-text" value="" name="anexoComprovanteMatricula" accept=".pdf" placeholder="Anexo do Comprovante de Matrícula" id="anexoComprovanteMatricula{{$participante->id}}" required />
                @error('anexoComprovanteMatrícula')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Currículo Lattes (.pdf)'])
                <input type="file" class="input-group-text" value="" name="anexoCurriculoLattes" accept=".pdf" placeholder="Anexo do Currículo Lattes" id="anexoCurriculoLattes{{$participante->id}}" required />
                @error('anexoCurriculoLattes')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-12 mb-3 mt-3">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="check" id="{{$participante->id}}" name="manterPlanoCheck" onchange="manterPlano(this)">
                <label class="form-check-label" for="{{$participante->id}}">
                    Manter o plano de trabalho
                </label>
                </div>
            </div>

            <div class="col-md-12">
                <h5>Plano de trabalho</h5>
            </div>
            <div class="col-12">
                @component('componentes.input', ['label' => 'Título'])
                <input type="text" class="form-control" value="" name="nomePlanoTrabalho" placeholder="Digite o título do plano de trabalho" maxlength="255" id="nomePlanoTrabalho{{$participante->id}}" required>
                <span style="color: red; font-size: 12px" id="caracsRestantesnomePlanoTrabalho{{$participante->id}}">
                </span>
                @error('nomePlanoTrabalho')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6">
                @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                <input type="file" class="input-group-text" value="" name="anexoPlanoTrabalho" accept=".pdf" placeholder="Anexo do Plano de Trabalho" id="anexoPlanoTrabalho{{$participante->id}}" required />
                @error('anexoPlanoTrabalho')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success" id="idButtonSubmitParticipante">Salvar</button>

            </div>

        </div>
    </div>
</form>
@endif