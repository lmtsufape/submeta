@if($visualizarSubstituido ?? '')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h5>Dados do discente</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Nome completo'])
            <input type="text" class="form-control " value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'E-mail'])
            <input type="email" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Data de nascimento'])
            <input type="date" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.input', ['label' => 'CPF'])
            <input type="text" class="form-control cpf" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->cpf}}" name="cpf" placeholder="CPF" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'RG'])
            <input type="number" class="form-control" min="1" maxlength="12" value="{{$subs->participanteSubstituido()->withTrashed()->first()->rg}}" name="rg" placeholder="RG" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Celular'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Link do Currículo Lattes'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituido()->withTrashed()->first()->linkLattes}}" name="linkLattes" placeholder="Link Lattes" id="inputLinkLattes" disabled />
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
            <input type="text" class="form-control cep" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->cep}}" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->uf}}" selected>{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->uf}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->cidade}}" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->bairro}}" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->rua}}" name="rua" placeholder="Rua" maxlength="100" id="rua{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->numero}}" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->endereco->complemento}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$subs->participanteSubstituido()->withTrashed()->first()->id}}" disabled />
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
            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$subs->participanteSubstituido()->withTrashed()->first()->id}}]" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->user->instituicao}}" disabled selected hidden>{{$subs->participanteSubstituido()->withTrashed()->first()->user->instituicao}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Curso'])
            <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$subs->participanteSubstituido()->withTrashed()->first()->id}}]" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->curso}}" disabled selected hidden>{{$subs->participanteSubstituido()->withTrashed()->first()->curso}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Turno'])
            <select name="turno" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->turno}}" selected>{{$subs->participanteSubstituido()->withTrashed()->first()->turno}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
            <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->total_periodos}}" selected>{{$subs->participanteSubstituido()->withTrashed()->first()->total_periodos}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Período/Ano atual'])
            <select name="periodo_atual" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->periodo_atual}}" selected>{{$subs->participanteSubstituido()->withTrashed()->first()->periodo_atual}}</option>
            </select>
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.select', ['label' => 'Ordem de prioridade'])
            <select name="ordem_prioridade" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido()->withTrashed()->first()->ordem_prioridade}}" selected>{{$subs->participanteSubstituido()->withTrashed()->first()->ordem_prioridade}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
            <input type="number" class="form-control media" value="{{$subs->participanteSubstituido()->withTrashed()->first()->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5>Documentos Complementares</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            @component('componentes.input', ['label' => 'Termo de Compromisso (.pdf)'])

            @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoTermoCompromisso)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituido()->withTrashed()->first()->anexoTermoCompromisso]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif

        <div class="col-5">
            @component('componentes.input', ['label' => 'Comprovante de Matrícula (.pdf)'])

            @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteMatricula)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituido()->withTrashed()->first()->anexoComprovanteMatricula]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-5">
                @component('componentes.input', ['label' => 'Curriculo Lattes (.pdf)'])

                @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoLattes)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituido()->withTrashed()->first()->anexoLattes]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif

        <div class="col-5">
                @component('componentes.input', ['label' => 'Autorização dos Pais (.pdf)'])

                @endcomponent
        </div>

        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoAutorizacaoPais)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituido()->withTrashed()->first()->anexoAutorizacaoPais]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-5">
            <label class="control-label">Comprovante Bancário (.pdf, .jpg, .jpeg, .png)</label>
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteBancario)
            <div class="col-1">
                <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituido()->withTrashed()->first()->anexoComprovanteBancario]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
            </div>
        @else
            <div class="col-1 text-danger">
                <p><i class="fas fa-times-circle fa-2x"></i></p>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5>Plano de trabalho</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        @if($subs->participanteSubstituido()->withTrashed()->first()->planoTrabalho)
        <div class="col-6">
            <h6>{{$subs->participanteSubstituido()->withTrashed()->first()->planoTrabalho->titulo}}</h6>
        </div>
        <div class="col-6">
            <a href="{{ route('baixar.plano', ['id' => $subs->participanteSubstituido()->withTrashed()->first()->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-3 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
</div>





@else





<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <h5>Dados do discente</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Nome completo'])
            <input type="text" class="form-control " value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'E-mail'])
            <input type="email" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Data de nascimento'])
            <input type="date" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.input', ['label' => 'CPF'])
            <input type="text" class="form-control cpf" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->cpf}}" name="cpf" placeholder="CPF" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'RG'])
            <input type="number" class="form-control" min="1" maxlength="12" value="{{$subs->participanteSubstituto()->withTrashed()->first()->rg}}" name="rg" placeholder="RG" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Celular'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
        @component('componentes.input', ['label' => 'Link do Currículo Lattes'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituto()->withTrashed()->first()->linkLattes}}" name="linkLattes" placeholder="Link Lattes" id="inputLinkLattes" disabled />
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
            <input type="text" class="form-control cep" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->cep}}" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->uf}}" selected>{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->uf}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->cidade}}" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->bairro}}" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->rua}}" name="rua" placeholder="Rua" maxlength="100" id="rua{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->numero}}" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->endereco->complemento}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$subs->participanteSubstituto()->withTrashed()->first()->id}}" disabled />
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
            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$subs->participanteSubstituto()->withTrashed()->first()->id}}]" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->user->instituicao}}" disabled selected hidden>{{$subs->participanteSubstituto()->withTrashed()->first()->user->instituicao}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Curso'])
            <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$subs->participanteSubstituto()->withTrashed()->first()->id}}]" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->curso}}" disabled selected hidden>{{$subs->participanteSubstituto()->withTrashed()->first()->curso}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Turno'])
            <select name="turno" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->turno}}" selected>{{$subs->participanteSubstituto()->withTrashed()->first()->turno}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
            <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->total_periodos}}" selected>{{$subs->participanteSubstituto()->withTrashed()->first()->total_periodos}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Período/Ano atual'])
            <select name="periodo_atual" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->periodo_atual}}" selected>{{$subs->participanteSubstituto()->withTrashed()->first()->periodo_atual}}</option>
            </select>
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.select', ['label' => 'Ordem de prioridade'])
            <select name="ordem_prioridade" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto()->withTrashed()->first()->ordem_prioridade}}" selected>{{$subs->participanteSubstituto()->withTrashed()->first()->ordem_prioridade}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
            <input type="number" class="form-control media" value="{{$subs->participanteSubstituto()->withTrashed()->first()->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5>Documentos Complementares</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            @component('componentes.input', ['label' => 'Termo de Compromisso (.pdf)'])

            @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoTermoCompromisso)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto()->withTrashed()->first()->anexoTermoCompromisso]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif

        <div class="col-5">
            @component('componentes.input', ['label' => 'Comprovante de Matrícula (.pdf)'])

            @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteMatricula)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteMatricula]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-5">
                @component('componentes.input', ['label' => 'Curriculo Lattes (.pdf)'])

                @endcomponent
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoLattes)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto()->withTrashed()->first()->anexoLattes]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif

        <div class="col-5">
                @component('componentes.input', ['label' => 'Autorização dos Pais (.pdf)'])

                @endcomponent
        </div>

        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoAutorizacaoPais)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto()->withTrashed()->first()->anexoAutorizacaoPais]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-1 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-5">
            <label class="control-label">Comprovante Bancário (.pdf, .jpg, .jpeg, .png)</label>
        </div>
        @if($subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteBancario)
            <div class="col-1">
                <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto()->withTrashed()->first()->anexoComprovanteBancario]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
            </div>
        @else
            <div class="col-1 text-danger">
                <p><i class="fas fa-times-circle fa-2x"></i></p>
            </div>
        @endif
    </div>


    <div class="row">
        <div class="col-md-12">
            <h5>Plano de trabalho</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        @if($subs->participanteSubstituto()->withTrashed()->first()->planoTrabalho)
        <div class="col-6">
            <h6>{{$subs->participanteSubstituto()->withTrashed()->first()->planoTrabalho->titulo}}</h6>
        </div>
        <div class="col-6">
            <a href="{{ route('baixar.plano', ['id' => $subs->participanteSubstituto()->withTrashed()->first()->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-3 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5>Observações</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <label for="observacaoTextArea">Observação:</label>
            <textarea class="form-control" id="observacaoTextArea" rows="3" name="textObservacao" placeholder="{{$subs->observacao}}" disabled></textarea>
        </div>
    </div>
</div>
@endif