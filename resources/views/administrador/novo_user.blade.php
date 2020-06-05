@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="margin-top: 100px; ">{{ __('Criar um usuário') }}</h2>
        </div>
        
    </div>  
    <br>
    <form method="POST" action="{{ route('admin.user.store') }}">
        @csrf
        <div class="col-sm-11">
            <div>
                <div>
                    <h4>Dados do usuário</h4>
                </div>
                <div>
                    <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                    <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value=""  autocomplete="nome" autofocus>

                    @error('nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="email" class="col-form-label">{{ __('Email') }}</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value=""   autocomplete="nome">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value=""  autocomplete="nome">

                    @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div>
                        <label for="tipo" class="col-form-label">{{ __('Tipo') }}</label>
                        <select name="tipo" id="tipo" onchange="mudar()">
                            @if(auth()->user()->tipo == 'administrador')
                                <option value="administrador">Administrador</option>
                                <option value="administradorResponsavel">Administrador responsavel</option>
                            @endif
                            <option value="avaliador">Avaliador</option>
                            <option value="proponente">Proponente</option>
                            <option value="participante">Participante</option>
                        </select>
                    </div>

                    <label for="passworld" class="col-form-label">{{ __('Senha') }}</label>
                    <input id="passworld" type="text" class="form-control @error('senha') is-invalid @enderror" name="senha" value=""  autocomplete="nome">

                    @error('senha')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="passworld" class="col-form-label">{{ __('Confirmar senha') }}</label>
                    <input id="passworld" type="text" class="form-control @error('confirmar_senha') is-invalid @enderror" name="confirmar_senha" value=""  autocomplete="nome">
                </div>
            </div>
            <br>
            <div id="proponente" style="display: none;">
                <div>
                    <h4>Dados do proponente</h4>
                </div>
                <div>
                    <label for="SIAPE" class="col-form-label">{{ __('SIAPE') }}</label>
                    <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" value="" autocomplete="nome">

                    @error('SIAPE')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="cargo" class="col-form-label">{{ __('Cargo') }}</label>
                    <input id="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror" name="cargo" value="" autocomplete="nome">

                    @error('cargo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    
                    <div>
                        <label for="vinculo" class="col-form-label">{{ __('Vinculo') }}</label>
                        <select name="vinculo" id="">
                            <option value="Servidor na ativa">Servidor na ativa</option>
                            <option value="Servidor aposentado">Servidor aposentado</option>
                            <option value="Professor visitante">Professor visitante</option>
                            <option value="Pós-doutorando">Pós-doutorando</option>
                        </select> 
                    </div>
                    
                    <label for="titulacaoMaxima" class="col-form-label">{{ __('Titulação Maxima') }}</label>
                    <input id="titulacaoMaxima" type="text" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="" autocomplete="nome">

                    @error('titulacaoMaxima')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="anoTitulacao" class="col-form-label">{{ __('Ano da Titulação') }}</label>
                    <input id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" value="" autocomplete="nome">

                    @error('anoTitulacao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <label for="areaFormacao" class="col-form-label">{{ __('Area de Formação') }}</label>
                    <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" value="" autocomplete="nome">

                    @error('areaFormacao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    
                    <div>
                        <label for="area" class="col-form-label">{{ __('Área') }}</label>
                        <select name="area" id="">
                            @foreach ($grandeAreas as $area)
                                <option value="{{$area->nome}}">{{$area->nome}}</option>
                            @endforeach
                        </select> 
                    </div>

                    
                    <div>
                        <label for="bolsistaProdutividade" class="col-form-label">{{ __('Bolsista de Produtividade') }}</label><br>
                        <select name="bolsistaProdutividade" id="">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select> 
                    </div>

                    
                    <div>
                        <label for="nivel" class="col-form-label">{{ __('Nivel') }}</label>
                        <select name="nivel" id="">
                            <option value="2">2</option>
                            <option value="1D">1D</option>
                            <option value="1D">1B</option>
                            <option value="1D">1C</option>
                            <option value="1D">1A</option>
                        </select> 
                    </div>

                    <label for="linkLattes" class="col-form-label">{{ __('Link do curriculum lattes') }}</label>
                    <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" value="" autocomplete="nome">

                    @error('linkLattes')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

            </div>
            <button type="submit" class="btn btn-primary" style="position:relative;top:10px;">{{ __('Salvar') }}</button>
        </div>
    </form>
</div>

@endsection

@section('javascript')
<script>
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