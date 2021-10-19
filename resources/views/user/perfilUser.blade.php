@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 3rem;">
    <form id="formEditUser" method="POST" action="{{ route('perfil.edit') }}">
        @csrf

        <input type="hidden" name="tipo" value="{{ $user->tipo }}">

        @if(session('mensagem'))
            <div class="col-md-12" style="margin-top: 5px;">
                <div class="alert alert-success">
                    <p>{{session('mensagem')}}</p>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8" style="margin-bottom:20px">
                <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Meus dados</h5>
                            <h6 class="card-title mb-0" style="color:red">* Campos obrigatórios</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:6px">
                                    <h5 class="card-title mb-0" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; font-family:Arial, Helvetica, sans-serif; ">Informações pessoais</h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('Nome Completo*') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf" class="col-form-label">{{ __('CPF*') }}</label>
                                    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $user->cpf }}" required autocomplete="cpf" autofocus>

                                    @error('cpf')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celular" class="col-form-label">{{ __('Celular*') }}</label>
                                    <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ $user->celular }}" required autocomplete="celular" autofocus>

                                    @error('celular')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:6px">
                                    <h5 class="card-title mb-0" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; font-family:Arial, Helvetica, sans-serif; ">Instituição</h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Instituição de Vínculo*') }}</label>
                                    <select style="display: inline" onchange="showInstituicao()" class="form-control @error('instituicaoSelect') is-invalid @enderror" name="instituicaoSelect" id="instituicaoSelect">
                                        <option value="" disabled hidden>-- Instituição --</option>
                                        @if($user->instituicao != "UFAPE")
                                            <option value="{{ $user->instituicao }}" selected>{{ $user->instituicao }}</option>
                                        @endif
                                        <option @if( $user->instituicao == "UFAPE") selected @endif value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                                        <option @if(old('instituicaoSelect') == "Outra") selected @endif value="Outra">Outra</option>
                                    </select>

                                    @error('instituicaoSelect')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" id="displayOutro" style="display: none;">
                                <div class="form-group">
                                    <label for="instituicao" class="col-form-label">{{ __('Digite a Instituição*') }}</label>
                                    <input id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" placeholder="Digite o nome da Instituição" autocomplete="instituicao" autofocus>
                                    @error('instituicao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @if(Auth()->user()->tipo == 'avaliador')
                            <div class="col-md-6">
                            <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                            <select style="display: inline"  class="form-control @error('area') is-invalid @enderror" name="area" id="area">
                                @if(Auth()->user()->avaliadors->area_id == null)
                                    <option value="" selected>Indefinida</option>
                                    @foreach (App\Area::all() as $area)
                                    @if(Auth()->user()->avaliadors->area_id == $area->id)
                                        <option value="{{ $area->id }}" selected>{{ $area->nome }}</option>
                                    @else
                                        <option value="{{ $area->id }}" >{{ $area->nome }}</option>
                                    @endif
                                    @endforeach
                                @else
                                    @foreach (App\Area::all() as $area)
                                    @if(Auth()->user()->avaliadors->area_id == $area->id)
                                        <option value="{{ $area->id }}" selected>{{ $area->nome }}</option>
                                    @else
                                        <option value="{{ $area->id }}" >{{ $area->nome }}</option>
                                    @endif
                                    @endforeach
                                @endif

                            </select>

                            @error('area')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cargo" class="col-form-label">{{ __('Cargo*') }}</label>
                                    <select id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror" onchange="">
                                        <option value="" disabled selected hidden>-- Cargo --</option>
                                        @isset($proponente)
                                            <option @if( $proponente->cargo =='Professor' ) selected @endif value="Professor">Professor</option>
                                            <option @if( $proponente->cargo =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                            <option @if( $proponente->cargo =='Outro' ) selected @endif value="Outro">Outro</option>
                                        @else 
                                            <option value="Professor">Professor</option>
                                            <option value="Técnico">Técnico</option>
                                            <option value="Outro">Outro</option>
                                        @endisset
                                    </select>

                                    @error('cargo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vinculo" class="col-form-label">{{ __('Vínculo*') }}</label>
                                    <select name="vinculo" id="vinculo" class="form-control @error('vinculo') is-invalid @enderror" onchange="outroVinculo()">
                                        <option value="" disabled selected hidden>-- Vínculo --</option>
                                        @isset($proponente)
                                            <option @if($proponente->vinculo =='Servidor na ativa' ) selected @endif value="Servidor na ativa">Servidor na ativa</option>
                                            <option @if($proponente->vinculo =='Servidor aposentado' ) selected @endif value="Servidor aposentado">Servidor aposentado</option>
                                            <option @if($proponente->vinculo =='Professor visitante' ) selected @endif value="Professor visitante">Professor visitante</option>
                                            <option @if($proponente->vinculo =='Pós-doutorando' ) selected @endif value="Pós-doutorando">Pós-doutorando</option>
                                            <option @if($proponente->vinculo =='Outro' ) selected @endif value="Outro">Outro</option>
                                            @if ($proponente->vinculo !='Servidor na ativa' && $proponente->vinculo !='Servidor aposentado' && $proponente->vinculo !='Professor visitante' && $proponente->vinculo !='Pós-doutorando' && $proponente->vinculo !='Outro')
                                                <option value="{{ $proponente->vinculo }}" selected >{{ $proponente->vinculo }}</option>
                                            @endif
                                        @else
                                            <option value="Servidor na ativa">Servidor na ativa</option>
                                            <option value="Servidor aposentado">Servidor aposentado</option>
                                            <option value="Professor visitante">Professor visitante</option>
                                            <option value="Pós-doutorando">Pós-doutorando</option>
                                            <option value="Outro">Outro</option>
                                        @endisset
                                    </select>

                                    @error('vinculo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none;" id="divOutro">
                                <div class="form-group">
                                    <label for="outro" class="col-form-label">{{ __('Qual?*') }}</label>
                                    <input id="outro" type="text" class="form-control @error('outro') is-invalid @enderror" name="outro" placeholder="Escreva aqui o seu vínculo com a instituição." value="{{ old('outro') }}">

                                    @error('outro')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" id="proponente" style="display: block;">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulacaoMaxima" class="col-form-label">{{ __('Titulação Máxima*') }}</label>
                                            <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="{{ old('titulacaoMaxima') }}" autocomplete="nome">
                                                <option value="" disabled selected hidden>-- Titulação --</option>
                                                @isset($proponente)
                                                    <option @if( $proponente->titulacaoMaxima =='Doutorado' ) selected @endif value="Doutorado">Doutorado</option>
                                                    <option @if( $proponente->titulacaoMaxima =='Mestrado' ) selected @endif value="Mestrado">Mestrado</option>
                                                    <option @if( $proponente->titulacaoMaxima =='Especialização' ) selected @endif value="Especialização">Especialização</option>
                                                    <option @if( $proponente->titulacaoMaxima =='Graduação' ) selected @endif value="Graduação">Graduação</option>
                                                    <option @if( $proponente->titulacaoMaxima =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                                @else 
                                                    <option value="Doutorado">Doutorado</option>
                                                    <option value="Mestrado">Mestrado</option>
                                                    <option value="Especialização">Especialização</option>
                                                    <option value="Graduação">Graduação</option>
                                                    <option value="Técnico">Técnico</option>
                                                @endisset
                                            </select>

                                            @error('titulacaoMaxima')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="anoTitulacao" class="col-form-label">{{ __('Ano da Titulação*') }}</label>
                                            <input id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" value="@isset($proponente){{$proponente->anoTitulacao}}@endisset" autocomplete="nome">

                                            @error('anoTitulacao')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="areaFormacao" class="col-form-label">{{ __('Área de Formação*') }}</label>
                                            <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" value="@isset($proponente){{$proponente->areaFormacao}}@endisset" autocomplete="nome">

                                            @error('areaFormacao')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="SIAPE" class="col-form-label">{{ __('SIAPE') }}</label>
                                            <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" value="@isset($proponente){{$proponente->SIAPE}}@endisset" autocomplete="nome">

                                            @error('SIAPE')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="linkLattes" class="col-form-label">{{ __('Link do currículo Lattes*') }}</label>
                                            <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" value="@isset($proponente){{$proponente->linkLattes}}@endisset" autocomplete="nome">

                                            @error('linkLattes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bolsistaProdutividade" class="col-form-label">{{ __('Bolsista de Produtividade*') }}</label><br>
                                            <select name="bolsistaProdutividade" id="bolsistaProdutividade" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" onchange="mudarNivel()">
                                                <option value="" disabled selected hidden>-- Bolsista --</option>
                                                @isset($proponente)
                                                    <option @if( $proponente->bolsistaProdutividade =='nao' ) selected @endif value="nao">Não</option>
                                                    <option @if( $proponente->bolsistaProdutividade =='sim' ) selected @endif value="sim">Sim</option>
                                                @else 
                                                    <option value="nao">Não</option>
                                                    <option value="sim">Sim</option>
                                                @endisset
                                            </select>
                                            @error('bolsistaProdutividade')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if(isset($proponente) && $proponente->bolsistaProdutividade =='sim')
                                            <div class="form-group" id="nivelInput" style="display: block;">
                                                <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                                                <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                                    <option value="" disabled selected hidden></option>
                                                    <option @if( $proponente->nivel =='1A' ) selected @endif value="1A">1A</option>
                                                    <option @if( $proponente->nivel =='1B' ) selected @endif value="1B">1B</option>
                                                    <option @if( $proponente->nivel =='1C' ) selected @endif value="1C">1C</option>
                                                    <option @if( $proponente->nivel =='1D' ) selected @endif value="1D">1D</option>
                                                    <option @if( $proponente->nivel =='2' ) selected @endif value="2">2</option>
                                                </select>
                                                @error('nivel')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group" id="nivelInput" style="display: none;">
                                                <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                                                <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                                    <option value="" disabled selected hidden></option>
                                                    <option value="1A">1A</option>
                                                    <option value="1B">1B</option>
                                                    <option value="1C">1C</option>
                                                    <option value="1D">1D</option>
                                                    <option value="2">2</option>
                                                </select>
                                                @error('nivel')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endisset
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:-0.3rem">
                                    <h5 class="card-title" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; font-family:Arial, Helvetica, sans-serif; ">Acesso ao sistema</h5>
                                    <div class="btn-group">
                                        <input type="checkbox" id="alterarSenhaCheckBox" name="alterarSenhaCheckBox" onchange="habilitando()">
                                        <label for="alterarSenhaCheckBox" style="margin-left: 10px; margin-top: -5px; color:#909090">Desejo alterar minha senha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emailFix" class="col-form-label">{{ __('E-mail*') }}</label>
                                    <input id="emailFix" type="email" class="form-control"  value="{{$user->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="senha_atual" class="col-form-label">{{ __('Senha atual*') }}</label>
                                    <input id="senha_atual" type="password" class="form-control @error('senha_atual') is-invalid @enderror" name="senha_atual" value="" disabled>

                                    @error('senha_atual')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nova_senha" class="col-form-label">{{ __('Nova senha*') }}</label>
                                    <input id="nova_senha" type="password" class="form-control @error('nova_senha') is-invalid @enderror" name="nova_senha" value="" disabled>

                                    @error('nova_senha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmar_senha" class="col-form-label">{{ __('Confirmar nova senha*') }}</label>
                                    <input id="confirmar_senha" type="password" class="form-control @error('confirmar_senha') is-invalid @enderror" name="confirmar_senha" value="" disabled>

                                    @error('confirmar_senha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div><hr></div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a class="btn btn-light botao-form" href="{{ route('home') }}" style="color:red; margin-left:5px;">Cancelar</a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success botao-form" style="" onclick="submeterForm()">
                                            {{ __('Atualizar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- 
<div class="container content">
    <div class="row titulo">
        <h1>Perfil</h1>
    </div>

    <div class="row subtitulo">
        <div class="col-sm-12">
            <p>Informações Pessoais</p>
        </div>
    </div>

    <form id="formEditUser" method="POST" action="{{ route('perfil.edit') }}">
        @csrf
        {{-- Nome | CPF 
        <div class="form-group row">
            <input type="hidden" name="tipo" value="{{ $user->tipo }}">
            @if(session('mensagem'))
                <div class="col-md-12" style="margin-top: 5px;">
                    <div class="alert alert-success">
                        <p>{{session('mensagem')}}</p>
                    </div>
                </div>
            @endif
            <div class="col-md-8">
                <label for="name" class="col-form-label">{{ __('Nome Completo*') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cpf" class="col-form-label">{{ __('CPF*') }}</label>
                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $user->cpf }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        {{-- Instituição de Ensino e Celular 
        <div class="form-group row">
            <div class="col-md-6">
                <label class="col-form-label">{{ __('Instituição de Vínculo*') }}</label>
                <select style="display: inline" onchange="showInstituicao()" class="form-control @error('instituicaoSelect') is-invalid @enderror" name="instituicaoSelect" id="instituicaoSelect">
                    <option value="" disabled hidden>-- Instituição --</option>
                    @if($user->instituicao != "UFAPE")
                        <option value="{{ $user->instituicao }}" selected>{{ $user->instituicao }}</option>
                    @endif
                    <option @if( $user->instituicao == "UFAPE") selected @endif value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                    <option @if(old('instituicaoSelect') == "Outra") selected @endif value="Outra">Outra</option>
                </select>

                @error('instituicaoSelect')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class='col-md-4' style="display: none;">
                <label for="instituicao" class="col-form-label">{{ __('Digite a Instituição*') }}</label>
                <input id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" placeholder="Digite o nome da Instituição" autocomplete="instituicao" autofocus>
                @error('instituicao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="celular" class="col-form-label">{{ __('Celular*') }}</label>
                <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ $user->celular }}" required autocomplete="celular" autofocus>

                @error('celular')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="email" class="col-form-label">{{ __('E-mail*') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" disabled>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @if(Auth()->user()->avaliadors)
              <div class="col-md-4">
                <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                <select style="display: inline"  class="form-control @error('area') is-invalid @enderror" name="area" id="area">
                      @if(Auth()->user()->avaliadors->area_id == null)
                        <option value="" selected>Indefinida</option>
                        @foreach (App\Area::all() as $area)
                          @if(Auth()->user()->avaliadors->area_id == $area->id)
                            <option value="{{ $area->id }}" selected>{{ $area->nome }}</option>
                          @else
                            <option value="{{ $area->id }}" >{{ $area->nome }}</option>
                          @endif
                        @endforeach
                      @else
                        @foreach (App\Area::all() as $area)
                          @if(Auth()->user()->avaliadors->area_id == $area->id)
                            <option value="{{ $area->id }}" selected>{{ $area->nome }}</option>
                          @else
                            <option value="{{ $area->id }}" >{{ $area->nome }}</option>
                          @endif
                        @endforeach
                      @endif

                </select>

                  @error('area')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
            @endif
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <input type="checkbox" id="alterarSenhaCheckBox" name="alterarSenhaCheckBox" onchange="habilitando()">
                <label for="alterarSenhaCheckBox">Desejo alterar minha senha</label>
            </div>
        </div>
        {{-- Email | Senha | Confirmar Senha 
        <div class="form-group row">
            <div class="col-md-4">
                <label for="senha_atual" class="col-form-label">{{ __('Senha atual*') }}</label>
                <input id="senha_atual" type="password" class="form-control @error('senha_atual') is-invalid @enderror" name="senha_atual" value="" disabled>

                @error('senha_atual')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="nova_senha" class="col-form-label">{{ __('Nova senha*') }}</label>
                <input id="nova_senha" type="password" class="form-control @error('nova_senha') is-invalid @enderror" name="nova_senha" value="" disabled>

                @error('nova_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="confirmar_senha" class="col-form-label">{{ __('Confirmar nova senha*') }}</label>
                <input id="confirmar_senha" type="password" class="form-control @error('confirmar_senha') is-invalid @enderror" name="confirmar_senha" value="" disabled>

                @error('confirmar_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        @if(isset($proponente))
        <div id="proponente" style="display: block;">

            <div>
                <h4>Dados de proponente</h4>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="cargo" class="col-form-label">{{ __('Cargo*') }}</label>
                    <select id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror" onchange="">
                        <option value="" disabled selected hidden>-- Cargo --</option>
                        <option @if( $proponente->cargo =='Professor' ) selected @endif value="Professor">Professor</option>
                        <option @if( $proponente->cargo =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                        <option @if( $proponente->cargo =='Estudante' ) selected @endif value="Estudante">Estudante</option>
                    </select>

                    @error('cargo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="vinculo" class="col-form-label">{{ __('Vínculo*') }}</label>
                    <select name="vinculo" id="vinculo" class="form-control @error('vinculo') is-invalid @enderror" onchange="outroVinculo()">
                        <option value="" disabled selected hidden>-- Vínculo --</option>
                        <option @if($proponente->vinculo =='Servidor na ativa' ) selected @endif value="Servidor na ativa">Servidor na ativa</option>
                        <option @if($proponente->vinculo =='Servidor aposentado' ) selected @endif value="Servidor aposentado">Servidor aposentado</option>
                        <option @if($proponente->vinculo =='Professor visitante' ) selected @endif value="Professor visitante">Professor visitante</option>
                        <option @if($proponente->vinculo =='Pós-doutorando' ) selected @endif value="Pós-doutorando">Pós-doutorando</option>
                        <option @if($proponente->vinculo =='Outro' ) selected @endif value="Outro">Outro</option>
                        @if ($proponente->vinculo !='Servidor na ativa' && $proponente->vinculo !='Servidor aposentado' && $proponente->vinculo !='Professor visitante' && $proponente->vinculo !='Pós-doutorando' && $proponente->vinculo !='Outro')
                            <option value="{{ $proponente->vinculo }}" selected >{{ $proponente->vinculo }}</option>
                        @endif
                    </select>

                    @error('vinculo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-4" style="display: none;" id="divOutro">
                    <label for="outro" class="col-form-label">{{ __('Qual?*') }}</label>
                    <input id="outro" type="text" class="form-control @error('outro') is-invalid @enderror" name="outro" value="{{ old('outro') }}">

                    @error('outro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div style="display: block;">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="titulacaoMaxima" class="col-form-label">{{ __('Titulação Máxima*') }}</label>
                        <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="{{ old('titulacaoMaxima') }}" autocomplete="nome">
                            <option value="" disabled selected hidden>-- Titulação --</option>
                            <option @if( $proponente->titulacaoMaxima =='Doutorado' ) selected @endif value="Doutorado">Doutorado</option>
                            <option @if( $proponente->titulacaoMaxima =='Mestrado' ) selected @endif value="Mestrado">Mestrado</option>
                            <option @if( $proponente->titulacaoMaxima =='Especialização' ) selected @endif value="Especialização">Especialização</option>
                            <option @if( $proponente->titulacaoMaxima =='Graduação' ) selected @endif value="Graduação">Graduação</option>
                            <option @if( $proponente->titulacaoMaxima =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                        </select>

                        @error('titulacaoMaxima')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="anoTitulacao" class="col-form-label">{{ __('Ano da Titulação*') }}</label>
                        <input id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" value="{{ $proponente->anoTitulacao }}" autocomplete="nome">

                        @error('anoTitulacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="areaFormacao" class="col-form-label">{{ __('Área de Formação*') }}</label>
                        <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" value="{{ $proponente->areaFormacao }}" autocomplete="nome">

                        @error('areaFormacao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label for="SIAPE" class="col-form-label">{{ __('SIAPE') }}</label>
                        <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" value="{{ $proponente->SIAPE }}" autocomplete="nome">

                        @error('SIAPE')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="linkLattes" class="col-form-label">{{ __('Link do currículo Lattes*') }}</label>
                        <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" value="{{ $proponente->linkLattes }}" autocomplete="nome">

                        @error('linkLattes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="bolsistaProdutividade" class="col-form-label">{{ __('Bolsista de Produtividade*') }}</label><br>
                        <select name="bolsistaProdutividade" id="bolsistaProdutividade" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" onchange="mudarNivel()">
                            <option value="" disabled selected hidden>-- Bolsista --</option>
                            <option @if( $proponente->bolsistaProdutividade =='nao' ) selected @endif value="nao">Não</option>
                            <option @if( $proponente->bolsistaProdutividade =='sim' ) selected @endif value="sim">Sim</option>
                        </select>
                        @error('bolsistaProdutividade')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if ($proponente->bolsistaProdutividade =='sim')
                        <div class="col-md-1" id="nivelInput" style="display: block;">
                            <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                            <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                <option value="" disabled selected hidden></option>
                                <option @if( $proponente->nivel =='1A' ) selected @endif value="1A">1A</option>
                                <option @if( $proponente->nivel =='1B' ) selected @endif value="1B">1B</option>
                                <option @if( $proponente->nivel =='1C' ) selected @endif value="1C">1C</option>
                                <option @if( $proponente->nivel =='1D' ) selected @endif value="1D">1D</option>
                                <option @if( $proponente->nivel =='2' ) selected @endif value="2">2</option>
                            </select>
                            @error('nivel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @else
                        <div class="col-md-1" id="nivelInput" style="display: none;">
                            <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                            <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                <option value="" disabled selected hidden></option>
                                <option value="1A">1A</option>
                                <option value="1B">1B</option>
                                <option value="1C">1C</option>
                                <option value="1D">1D</option>
                                <option value="2">2</option>
                            </select>
                            @error('nivel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
        @endif
    </form>

    <div class="container">
        <div class="row justify-content-center" style="margin: 20px 0 20px 0">

            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="{{ route('home') }}" style="width:100%">Cancelar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%" onclick="submeterForm()">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </div>
</div>
--}}

@endsection
@section('javascript')
  <script type="text/javascript" >
    //var emailInput = document.getElementById('email');
    //emailInput.disabled = true;

    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#celular').mask('(00) 00000-0000');
    });

    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
    function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                //Cria um elemento javascript.
                var script = document.createElement('script');
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
    function mudar() {
        var divProponente = document.getElementById('proponente');
        var comboBoxTipo = document.getElementById('tipo');

        if (comboBoxTipo.value == "proponente") {
            divProponente.style.display = "block";
        } else {
            divProponente.style.display = "none";
        }
    }


    function outroVinculo() {
        var comboBoxVinculo = document.getElementById('vinculo');
        var divOutro = document.getElementById('divOutro');

        if (comboBoxVinculo.value === "Outro") {
            divOutro.style.display = "block";
        } else {
            divOutro.style.display = "none";
        }
    }

    function mudarNivel() {
        var bolsista = document.getElementById('bolsistaProdutividade');
        var nivel = document.getElementById('nivelInput');

        if (bolsista.value === "sim") {
            nivel.style.display = "block";
        } else {
            nivel.style.display = "none";
        }
    }

    function showInstituicao(){
        var instituicao = document.getElementById('instituicao');
        var instituicaoSelect = document.getElementById('instituicaoSelect');

        // if(instituicaoSelect.value === "Outra"){
        //     instituicaoSelect.style.display = "none";
        //     instituicao.style.display = "inline";
        // }
        if(instituicaoSelect.value === "Outra"){
            document.getElementById("displayOutro").style.display = "block";
            instituicao.parentElement.style.display = '';
        }else if(instituicaoSelect.value === "UFAPE"){
            document.getElementById("displayOutro").style.display = "none";
        }
    }

    function habilitando() {
        var checkbox = document.getElementById('alterarSenhaCheckBox');
        if (checkbox.checked) {
            document.getElementById('senha_atual').disabled = false;
            document.getElementById('nova_senha').disabled = false;
            document.getElementById('confirmar_senha').disabled = false;
        } else {
            document.getElementById('senha_atual').disabled = true;
            document.getElementById('nova_senha').disabled = true;
            document.getElementById('confirmar_senha').disabled = true;
        }
    }

    function submeterForm() {
        var form = document.getElementById('formEditUser');
        var emailInput = document.getElementById('email');
        emailInput.disabled = false;
        form.submit();
    }

    window.onload = showInstituicao();
  </script>
@endsection
