@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="margin-top: 100px; ">{{ __('Editar um usuário') }}</h2>
        </div>
    </div>  
    <div class="row">
        <form method="POST" action="{{ route('admin.user.update', ['id' => $user->id])}}">
            @csrf
            <div class="col-sm-12">
                

                <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $user->name }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $user->cpf }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tipo" class="col-form-label">{{ __('Tipo') }}</label>
                
                <div>
                    <select name="tipo" id="tipo" onchange="mudar()">
                        @if(auth()->user()->tipo == 'administrador')
                            @if ($user->tipo == 'administrador')
                                <option value="administrador" selected>Administrador</option>
                            @else 
                                <option value="administrador">Administrador</option>
                            @endif
                            @if ($user->tipo == 'administradorResponsavel')
                                <option value="administradorResponsavel" selected>Administrador Responsável</option>
                            @else 
                                <option value="administradorResponsavel">Administrador Responsável</option>
                            @endif
                        @endif
                        @if ($user->tipo == 'avaliador')
                            <option value="coordenador" selected>Coordenador</option>
                        @else 
                            <option value="coordenador">Coordenador</option>
                        @endif

                        @if ($user->tipo == 'proponente')
                            <option value="proponente" selected>Proponente</option>
                        @else 
                            <option value="proponente">Proponente</option>
                        @endif

                        @if ($user->tipo == 'participante')
                            <option value="participante" selected>Participante</option>
                        @else 
                            <option value="participante">Participante</option>
                        @endif
                    </select> 
                </div>
                
                {{-- <label for="passworld" class="col-form-label">{{ __('Senha atual') }}</label>
                <input id="passworld" type="text" class="form-control @error('senha_atual') is-invalid @enderror" name="senha_atual" value="" required autocomplete="senha_atual" autofocus>

                @error('senha_atual')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="new_passworld" class="col-form-label">{{ __('Nova senha') }}</label>
                <input id="new_passworld" type="text" class="form-control @error('nova_senha') is-invalid @enderror" name="nova_senha" value="" required autocomplete="nova_senha" autofocus>

                @error('nova_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="confirm_passworld" class="col-form-label">{{ __('Confirmar nova senha') }}</label>
                <input id="confirmar_passworld" type="text" class="form-control @error('confirmar_senha') is-invalid @enderror" name="confirmar_senha" value="" required autocomplete="confirmar_senha" autofocus>

                @error('confirmar_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror --}}

                @if ($user->tipo == "proponente" && !(is_null($proponente))) 
                    <div id="proponente" style="display: none;">
                        <label class="col-form-label">{{ __('SIAPE') }}</label>
                        <input value="{{$proponente->SIAPE}}" id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" autocomplete="SIAPE">
                        
                        <label class="col-form-label">{{ __('Cargo') }}</label>
                        <input value="{{$proponente->cargo}}" id="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo" autocomplete="cargo">

                        <label class="col-form-label">{{ __('Vínculo') }}</label>
                        <input value="{{$proponente->vinculo}}" id="vinculo" type="text" class="form-control @error('vinculo') is-invalid @enderror" name="vinculo" autocomplete="vinculo">

                        <label class="col-form-label">{{ __('Titulação Máxima') }}</label>
                        <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" autocomplete="titulacaoMaxima">
                            <option value="" disabled selected hidden>-- Titulação --</option>
                            <option @if ($proponente->titulacaoMaxima == "Doutorado") selected @endif value="Doutorado">Doutorado</option>
                            <option @if ($proponente->titulacaoMaxima == "Mestrado") selected @endif value="Mestrado">Mestrado</option>
                            <option @if ($proponente->titulacaoMaxima == "Especialização") selected @endif value="Especialização">Especialização</option>
                            <option @if ($proponente->titulacaoMaxima == "Graduação") selected @endif value="Graduação">Graduação</option>
                            <option @if ($proponente->titulacaoMaxima == "Técnico") selected @endif value="Técnico">Técnico</option>                        
                        </select>

                        <label class="col-form-label">{{ __('Ano Titulação') }}</label>
                        <input value="{{$proponente->anoTitulacao}}" id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" autocomplete="anoTitulacao">

                        <label class="col-form-label">{{ __('Área Formação') }}</label>
                        <input value="{{$proponente->areaFormacao}}" id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" autocomplete="areaFormacao">

                        <label class="col-form-label">{{ __('Bolsista Produtividade') }}</label>
                        <input value="{{$proponente->bolsistaProdutividade}}" id="bolsistaProdutividade" type="text" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" name="bolsistaProdutividade" autocomplete="bolsistaProdutividade">

                        <label class="col-form-label">{{ __('Nível') }}</label>
                        <input value="{{$proponente->nivel}}" id="nivel" type="text" class="form-control @error('nivel') is-invalid @enderror" name="nivel" autocomplete="nivel">

                        <label class="col-form-label">{{ __('Link do Lattes') }}</label>
                        <input value="{{$proponente->linkLattes}}" id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" autocomplete="linkLattes">
                    </div>
                @else
                    <div id="proponente" style="display: none;">
                        <label class="col-form-label">{{ __('SIAPE') }}</label>
                        <input value="" id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" autocomplete="SIAPE">
                        
                        <label class="col-form-label">{{ __('Cargo') }}</label>
                        <input value="" id="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo" autocomplete="cargo">

                        <label class="col-form-label">{{ __('Vínculo') }}</label>
                        <input value="" id="vinculo" type="text" class="form-control @error('vinculo') is-invalid @enderror" name="vinculo" autocomplete="vinculo">

                        <label class="col-form-label">{{ __('Titulação Máxima') }}</label>
                        <input value="" id="titulacaoMaxima" type="text" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" autocomplete="titulacaoMaxima">

                        <label class="col-form-label">{{ __('Ano Titulação') }}</label>
                        <input value="" id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" autocomplete="anoTitulacao">

                        <label class="col-form-label">{{ __('Área Formação') }}</label>
                        <input value="" id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" autocomplete="areaFormacao">
                        
                        <label class="col-form-label">{{ __('Bolsista Produtividade') }}</label>
                        <input value="" id="bolsistaProdutividade" type="text" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" name="bolsistaProdutividade" autocomplete="bolsistaProdutividade">

                        <label class="col-form-label">{{ __('Nível') }}</label>
                        <input value="" id="nivel" type="text" class="form-control @error('nivel') is-invalid @enderror" name="nivel" autocomplete="nivel">

                        <label class="col-form-label">{{ __('Link do Lattes') }}</label>
                        <input value="" id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" autocomplete="linkLattes">
                    </div>
                @endif
            <br>

                <button type="submit" class="btn btn-primary" style="position:relative;top:10px;">{{ __('Salvar') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script>
    var divProponente = document.getElementById('proponente');
    var comboBoxTipo = document.getElementById('tipo');
    
    if (comboBoxTipo.value == "proponente") {
        divProponente.style.display = "inline";
    } else {
        divProponente.style.display = "none";
    }

    function mudar() {
        var divProponente = document.getElementById('proponente');
        var comboBoxTipo = document.getElementById('tipo');
        
        if (comboBoxTipo.value == "proponente") {
            divProponente.style.display = "inline";
        } else {
            divProponente.style.display = "none";
        }
    }
</script>
@endsection