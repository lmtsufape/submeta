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
            <input type="text" class="form-control " value="{{$subs->participanteSubstituido->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$subs->participanteSubstituido->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'E-mail'])
            <input type="email" class="form-control" value="{{$subs->participanteSubstituido->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$subs->participanteSubstituido->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row"> 
        <div class="col-6">
            @component('componentes.input', ['label' => 'Data de nascimento'])
            <input type="date" class="form-control" value="{{$subs->participanteSubstituido->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.input', ['label' => 'CPF'])
            <input type="text" class="form-control cpf" value="{{$subs->participanteSubstituido->user->cpf}}" name="cpf" placeholder="CPF" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'RG'])
            <input type="number" class="form-control" min="1" maxlength="12" value="{{$subs->participanteSubstituido->rg}}" name="rg" placeholder="RG" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Celular'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituido->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
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
            <input type="text" class="form-control cep" value="{{$subs->participanteSubstituido->user->endereco->cep}}" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="{{$subs->participanteSubstituido->user->endereco->uf}}" selected>{{$subs->participanteSubstituido->user->endereco->uf}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido->user->endereco->cidade}}" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$subs->participanteSubstituido->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido->user->endereco->bairro}}" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$subs->participanteSubstituido->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido->user->endereco->rua}}" name="rua" placeholder="Rua" maxlength="100" id="rua{{$subs->participanteSubstituido->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituido->user->endereco->numero}}" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="{{$subs->participanteSubstituido->user->endereco->complemento}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$subs->participanteSubstituido->id}}" disabled />
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
            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$subs->participanteSubstituido->id}}]" disabled>
                <option value="{{$subs->participanteSubstituido->user->instituicao}}" disabled selected hidden>{{$subs->participanteSubstituido->user->instituicao}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Curso'])
            <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$subs->participanteSubstituido->id}}]" disabled>
                <option value="{{$subs->participanteSubstituido->curso}}" disabled selected hidden>{{$subs->participanteSubstituido->curso}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Turno'])
            <select name="turno" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido->turno}}" selected>{{$subs->participanteSubstituido->turno}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
            <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                <option value="{{$subs->participanteSubstituido->total_periodos}}" selected>{{$subs->participanteSubstituido->total_periodos}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Período/Ano atual'])
            <select name="periodo_atual" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido->periodo_atual}}" selected>{{$subs->participanteSubstituido->periodo_atual}}</option>
            </select>
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.select', ['label' => 'Ordem de prioridade'])
            <select name="ordem_prioridade" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituido->ordem_prioridade}}" selected>{{$subs->participanteSubstituido->ordem_prioridade}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
            <input type="number" class="form-control media" value="{{$subs->participanteSubstituido->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h5>Plano de trabalho</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        @if($subs->participanteSubstituido->planoTrabalho)
        <div class="col-6">
            <h6>{{$subs->participanteSubstituido->planoTrabalho->titulo}}</h6>
        </div>
        <div class="col-6">
            <a href="{{ route('baixar.plano', ['id' => $subs->participanteSubstituido->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
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
            <input type="text" class="form-control " value="{{$subs->participanteSubstituto->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$subs->participanteSubstituto->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'E-mail'])
            <input type="email" class="form-control" value="{{$subs->participanteSubstituto->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$subs->participanteSubstituto->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row"> 
        <div class="col-6">
            @component('componentes.input', ['label' => 'Data de nascimento'])
            <input type="date" class="form-control" value="{{$subs->participanteSubstituto->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.input', ['label' => 'CPF'])
            <input type="text" class="form-control cpf" value="{{$subs->participanteSubstituto->user->cpf}}" name="cpf" placeholder="CPF" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'RG'])
            <input type="number" class="form-control" min="1" maxlength="12" value="{{$subs->participanteSubstituto->rg}}" name="rg" placeholder="RG" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Celular'])
            <input type="tel" class="form-control celular" value="{{$subs->participanteSubstituto->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
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
            <input type="text" class="form-control cep" value="{{$subs->participanteSubstituto->user->endereco->cep}}" name="cep" placeholder="CEP" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Estado'])
            <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                <option value="{{$subs->participanteSubstituto->user->endereco->uf}}" selected>{{$subs->participanteSubstituto->user->endereco->uf}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Cidade'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto->user->endereco->cidade}}" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$subs->participanteSubstituto->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Bairro'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto->user->endereco->bairro}}" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$subs->participanteSubstituto->id}}" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Rua'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto->user->endereco->rua}}" name="rua" placeholder="Rua" maxlength="100" id="rua{{$subs->participanteSubstituto->id}}" disabled />
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Número'])
            <input type="text" class="form-control" value="{{$subs->participanteSubstituto->user->endereco->numero}}" name="numero" placeholder="Número" disabled />
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class=" control-label" for="firstname">Complemento</label>
                <input type="text" class="form-control" value="{{$subs->participanteSubstituto->user->endereco->complemento}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$subs->participanteSubstituto->id}}" disabled />
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
            <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$subs->participanteSubstituto->id}}]" disabled>
                <option value="{{$subs->participanteSubstituto->user->instituicao}}" disabled selected hidden>{{$subs->participanteSubstituto->user->instituicao}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.input', ['label' => 'Curso'])
            <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$subs->participanteSubstituto->id}}]" disabled>
                <option value="{{$subs->participanteSubstituto->curso}}" disabled selected hidden>{{$subs->participanteSubstituto->curso}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Turno'])
            <select name="turno" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto->turno}}" selected>{{$subs->participanteSubstituto->turno}}</option>
            </select>
            @endcomponent
        </div>
        <div class="col-6">
            @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
            <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                <option value="{{$subs->participanteSubstituto->total_periodos}}" selected>{{$subs->participanteSubstituto->total_periodos}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.select', ['label' => 'Período/Ano atual'])
            <select name="periodo_atual" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto->periodo_atual}}" selected>{{$subs->participanteSubstituto->periodo_atual}}</option>
            </select>
            @endcomponent
        </div>

        <div class="col-6">
            @component('componentes.select', ['label' => 'Ordem de prioridade'])
            <select name="ordem_prioridade" class="form-control" disabled>
                <option value="{{$subs->participanteSubstituto->ordem_prioridade}}" selected>{{$subs->participanteSubstituto->ordem_prioridade}}</option>
            </select>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            @component('componentes.input', ['label' => 'Coeficiente de rendimento'])
            <input type="number" class="form-control media" value="{{$subs->participanteSubstituto->media_do_curso}}" name="media_do_curso" min="0" max="10" step="0.01" disabled>
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
        @if($subs->participanteSubstituto->anexoTermoCompromisso)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto->anexoTermoCompromisso]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
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
        @if($subs->participanteSubstituto->anexoComprovanteMatricula)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto->anexoComprovanteMatricula]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
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
        @if($subs->participanteSubstituto->anexoLattes)
        <div class="col-1">
            <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $subs->participanteSubstituto->anexoLattes]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
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
        @if($subs->participanteSubstituto->planoTrabalho)
        <div class="col-6">
            <h6>{{$subs->participanteSubstituto->planoTrabalho->titulo}}</h6>
        </div>
        <div class="col-6">
            <a href="{{ route('baixar.plano', ['id' => $subs->participanteSubstituto->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
        </div>
        @else
        <div class="col-3 text-danger">
            <p><i class="fas fa-times-circle fa-2x"></i></p>
        </div>
        @endif
    </div>
</div>
@endif