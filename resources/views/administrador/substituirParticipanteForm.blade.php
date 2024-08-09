<!-- Verificação para definir se a informação do modal será o formulário para substituição ou apenas visualização-->
@if($visualizarOnly ?? '')
<!-- Apenas visualização-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h5 style="font-weight: bold;">Dados do discente</h5>
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
            <input type="text" class="form-control" min="1" maxlength="12" value="{{$participante->rg}}" name="rg" placeholder="RG" disabled />
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
            <h5 style="font-weight: bold;">Endereço</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'CEP'])
            <input type="text" class="form-control cep" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->cep}} @endif" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="@if(isset($participante->user->endereco)) {{$participante->user->endereco->uf}} @endif" selected>@if(isset($participante->user->endereco)) {{$participante->user->endereco->uf}} @endif</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value=" @if(isset($participante->user->endereco)){{$participante->user->endereco->cidade}} @endif" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$participante->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->bairro}} @endif" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$participante->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="@if(isset($participante->user->endereco)) {{ $participante->user->endereco->rua}} @endif" name="rua" placeholder="Rua" maxlength="100" id="rua{{$participante->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->numero}} @endif" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{ $participante->user->endereco->complemento}} @endif" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$participante->id}}" disabled />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5 style="font-weight: bold;">Dados do curso</h5>
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
    
    @if($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC")
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento (média geral)'])
            <input type="number" class="form-control media" value="{{$participante->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
            @endcomponent
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <h5 style="font-weight: bold;">Plano de trabalho</h5>
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
    {{--Documentação complementar quando o projeto está aprovado--}}
    @if($trabalho->status =="aprovado")
        <br>
        <div class="row">
            <div class="col-md-12">
                <h5 style="font-weight: bold;">Documentação Complementar</h5>
            </div>
        </div>
        <div class="row col-md-12" >
            <div class="col-md-6 pl-0" style="margin-top: 15px">
                <label class="control-label ">Termo de Compromisso <span style="color: red">*</span>
                    @if($participante->anexoTermoCompromisso)
                        <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoTermoCompromisso]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                    @endif
                </label>
            </div>
            <div class="col-md-6 pl-0" style="margin-top: 15px">
                <label class="control-label ">Comprovante de Matrícula <span style="color: red">*</span>
                    @if($participante->anexoComprovanteMatricula)
                        <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoComprovanteMatricula]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                    @endif
                </label>
            </div>
            <div class="col-md-6 pl-0" style="margin-top: 15px">
                <label class="control-label ">Documentos Pessoais (CPF/RG ou CNH) <span style="color: red">*</span>
                    @if($participante->anexo_cpf_rg)
                        <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexo_cpf_rg]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                    @endif
                </label>
            </div>
            @if($trabalho->evento->tipo != "PIBEX" && $trabalho->evento->tipo != "PIBAC")
                <div class="col-md-6 pl-0" style="margin-top: 15px">
                    <label class="control-label ">PDF Lattes <span style="color: red">*</span>
                        @if($participante->anexoLattes)
                            <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoLattes]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                        @endif
                    </label>
                </div>
                <div class="col-md-6 pl-0" style="margin-top: 15px">
                    <div class="row">
                    <div class="col-sm-3 pr-0">
                    <label class="control-label " content="required">Link Lattes <span style="color: red">*</span> </label>
                    </div>
                    <div class="col-sm-9 pl-0">
                    <input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="text" class="input-group-text col-md-12" name="linkLattes"  placeholder="Link Lattes" id="linkLattes{{$participante->id}}"
                           required @if($participante->linkLattes) value="{{$participante->linkLattes}}" @endif maxlength="250" style="width: 322px;"/>
                    </div>
                    </div>
                </div>
            @endif
            <div class="col-md-6 pl-0" style="margin-top: 15px">
                <label class="control-label " >Comprovante Bancário (Foto do cartão)
                    @if($participante->anexoComprovanteBancario)
                        <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoComprovanteBancario]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                    @endif
                </label>
            </div>
            <div class="col-md-6 pl-0" style="margin-top: 15px">
                <label class="control-label ">Autorização dos Pais (Em caso de menor de idade)
                    @if($participante->anexoAutorizacaoPais)
                        <a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoAutorizacaoPais]) }}"><i class="ml-1 fas fa-file-pdf fa-2x"></i></a>
                    @endif
                </label>
            </div>
        </div>
    @endif
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

            <div class="col-6 {{ $errors->has('cpf') ? ' has-error' : '' }}">
                @component('componentes.input', ['label' => 'CPF'])
                    <input type="text" class="form-control cpf @error('cpf') is-invalid @enderror" value=""
                           onchange="checarCPFdoCampo(this)"
                           name="cpf" placeholder="CPF" id="cpf{{$participante->id}}" required autofocus autocomplete="cpf"/>

                    @error('cpf')
                    <span class="help-block">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'RG'])
                <input type="text" class="form-control rg" value="" name="rg" placeholder="RG" id="rg{{$participante->id}}" required />
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
            <div class="col-6">
                @component('componentes.input', ['label' => 'Data de Entrada'])
                    <input type="date" class="form-control" value="" name="data_entrada" placeholder="Data de Entrada" id="dt_entrada{{$participante->id}}" required />
                    @error('data_entrada')
                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                @endcomponent
            </div>
            <div class="form-group col-md-6">
                @component('componentes.input', ['label' => 'Link do currículo Lattes'])
                <input class="form-control @error('linkLattes') is-invalid @enderror" type="text" name="linkLattes" placeholder="Link do currículo Lattes do estudante" id="linkLattes{{$participante->id}}" required >
                <small>Ex.: http://lattes.cnpq.br/8363536830656923</small>
                @error('linkLattes')
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
                    @for($j = 1; $j <= $edital->numParticipantes; $j++) <option value="{{ $j }}">{{ $j }}</option>
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
                @component('componentes.input', ['label' => 'Coeficiente de rendimento (média geral)'])
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
                <input type="file" class="input-group-text pdf" value="" name="anexoTermoCompromisso" accept=".pdf" placeholder="Anexo do Termo de Compromisso" id="anexoTermoCompromisso{{$participante->id}}" required />
                @error('anexoTermoCompromisso')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Comprovante de Matrícula (.pdf)'])
                <input type="file" class="input-group-text pdf" value="" name="anexoComprovanteMatricula" accept=".pdf" placeholder="Anexo do Comprovante de Matrícula" id="anexoComprovanteMatricula{{$participante->id}}" required />
                @error('anexoComprovanteMatrícula')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                @component('componentes.input', ['label' => 'Currículo Lattes (.pdf)'])
                <input type="file" class="input-group-text pdf" value="" name="anexoCurriculoLattes" accept=".pdf" placeholder="Anexo do Currículo Lattes" id="anexoCurriculoLattes{{$participante->id}}" required />
                @error('anexoCurriculoLattes')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6">
                <label class="control-label">Autorização dos Pais (.pdf)</label>
                <input type="file" class="input-group-text pdf" value="" name="anexoAutorizacaoPais" accept=".pdf" placeholder="Anexo da Autorização dos Pais" id="anexoAutorizacaoPais{{$participante->id}}" />
                @error('anexoAutorizacaoPais')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span style="font-size:small">Anexo obrigatório para discentes menores de 18 anos</span>
            </div>
            <div class="col-6">
                <label class="control-label">Comprovante Bancário (.pdf, .jpg, .jpeg, .png)</label>
                <input type="file" class="input-group-text" value="" name="anexoComprovanteBancario" accept=".jpeg,.jpg,.png,.pdf" placeholder="Anexo do Comprovante Bancário" id="anexoComprovanteBancario{{$participante->id}}"/>
                <small>Anexo obrigatório para bolsistas, mas não obrigatório para voluntários</small>
                @error('anexoComprovanteBancario')
                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

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
            <div class="col-12" id="arqParticipante">
                @component('componentes.input', ['label' => 'Título'])
                <input type="text" class="form-control" value="" name="nomePlanoTrabalho" placeholder="Digite o título do plano de trabalho" maxlength="255" id="nomePlanoTrabalho{{$participante->id}}" required>
                
                @error('nomePlanoTrabalho')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>

            <div class="col-6" id="arqParticipantes">
                @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                <input type="file" class="input-group-text" value="" name="anexoPlanoTrabalho" accept=".pdf" placeholder="Anexo do Plano de Trabalho" id="anexoPlanoTrabalho{{$participante->id}}" required />
                @error('anexoPlanoTrabalho')
                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                @endcomponent
            </div>
            <div class="col-6" id="arqAtual" hidden>
                @component('componentes.input', ['label' => 'Anexo (.pdf)'])
                    <a href="" id="arquivo{{$participante->id}}" style="padding-left: 20px"><i class="fas fa-file-pdf fa-2x"></i></a>
                @endcomponent
            </div>
            <h1 id="teste"></h1>
            <div class="col-md-12">
                <h5>Observações</h5>
            </div>
            <div class="col-12">
                <textarea class="form-control" id="observacaoTextArea" rows="3" name="textObservacao" ></textarea>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success" id="idButtonSubmitParticipante">Salvar</button>

            </div>

        </div>
    </div>
</form>
@endif
