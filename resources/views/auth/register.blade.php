@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 3rem">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8" style="margin-bottom:20px">
                <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Cadastro</h5>
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
                                    <label for="name" class="col-form-label">{{ __('Nome Completo') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Digite seu nome completo" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cpf" class="col-form-label">{{ __('CPF') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" placeholder="Digite o número do cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

                                    @error('cpf')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rg" class="col-form-label">{{ __('RG') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="rg" type="text" class="form-control @error('rg') is-invalid @enderror" name="rg" placeholder="Digite o número do RG" value="{{ old('rg') }}" required autocomplete="rg" autofocus>

                                    @error('rg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celular" class="col-form-label">{{ __('Celular') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" placeholder="Digite o número do seu celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus>

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
                                    <label for="instituicaoSelect" class="col-form-label">{{ __('Instituição de Vínculo') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <select style="display: inline" onchange="showInstituicao()" class="form-control @error('instituicaoSelect') is-invalid @enderror" name="instituicaoSelect" id="instituicaoSelect">
                                        <option value="" disabled selected hidden>-- Instituição --</option>
                                        <option @if(old('instituicaoSelect')=='UFAPE' ) selected @endif value="UFAPE">Universidade Federal do Agreste de Pernambuco - UFAPE</option>
                                        <option @if(old('instituicaoSelect')=='Outra' ) selected @endif value="Outra">Outra</option>
                                    </select>
                                    @error('instituicaoSelect')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12" id="displayOutro" style='display:none'>
                                <div class="form-group">
                                    <label for="instituicao" class="col-form-label">{{ __('Digite a Instituição') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" placeholder="Digite o nome da Instituição" autocomplete="instituicao" autofocus>
                                    @error('instituicao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="perfil" class="col-form-label">{{ __('Perfil') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <select id="perfil" name="perfil" class="form-control @error('perfil') is-invalid @enderror" onchange="mudarPerfil()">
                                        <option value="" disabled selected hidden>-- Perfil --</option>
                                        <option @if(old('perfil')=='Professor' ) selected @endif value="Professor">Professor</option>
                                        <option @if(old('perfil')=='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                        <option @if(old('perfil')=='Estudante' ) selected @endif value="Estudante">Estudante</option>
                                        <option @if(old('perfil')=='Outro' ) selected @endif value="Outro">Outro</option>
                                    </select>
                                    @error('perfil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="outroPerfil">
                                    <label for="outroPerfil" class="col-form-label">{{ __('Qual perfil?') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="outroPerfil" type="text" class="form-control @error('outroPerfil') is-invalid @enderror" name="outroPerfil" placeholder="Digite aqui qual o seu perfil" value="{{ old('outroPerfil') }}">
                                    @error('outroPerfil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div style="display:none" id="divCursos" class="col-md-12 mb-2">
                                <label for="curso" class="col-form-label">{{ __('Cursos que Leciona') }} <span style="color: red; font-weight:bold;">*</span></label>
                                <br>
                                <div class="row col-md-12">
                                    @foreach($cursos as $curso)
                                    <div class="col-sm-6">
                                        <input type="checkbox" name="curso[]" id="curso{{$curso->id}}" value="{{$curso->id}}">
                                        <label class="form-check-label" for="curso{{$curso->id}}">
                                            {{ $curso->nome }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Proponente -->
                            <div class="col-md-6">
                                <div class="form-group" id="divVinculo">
                                    <label for="vinculo" class="col-form-label">{{ __('Vínculo') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <select name="vinculo" id="vinculo" class="form-control @error('vinculo') is-invalid @enderror" onchange="mudarPerfil()">
                                        <option value="" disabled selected hidden>-- Vínculo --</option>
                                        <option @if(old('vinculo')=='Servidor na ativa' ) selected @endif value="Servidor na ativa">Servidor na ativa</option>
                                        <option @if(old('vinculo')=='Servidor aposentado' ) selected @endif value="Servidor aposentado">Servidor aposentado</option>
                                        <option @if(old('vinculo')=='Professor visitante' ) selected @endif value="Professor visitante">Professor visitante</option>
                                        <option @if(old('vinculo')=='Pós-doutorando' ) selected @endif value="Pós-doutorando">Pós-doutorando</option>
                                        <option @if(old('vinculo')=='Outro' ) selected @endif value="Outro">Outro</option>
                                    </select>

                                    @error('vinculo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="divOutro">
                                    <label for="outro" class="col-form-label">{{ __('Qual?') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="outro" type="text" class="form-control @error('outro') is-invalid @enderror" name="outro" placeholder="Digite aqui o seu vínculo" value="{{ old('outro') }}">
                                    @error('outro')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group" id="divTitulacaoMax" style="display: none">
                                    <label for="titulacaoMaxima" class="col-form-label">{{ __('Titulação Máxima') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="{{ old('titulacaoMaxima') }}" autocomplete="nome">
                                        <option value="" disabled selected hidden>-- Titulação --</option>
                                        <option @if(old('titulacaoMaxima')=='Doutorado' ) selected @endif value="Doutorado">Doutorado</option>
                                        <option @if(old('titulacaoMaxima')=='Mestrado' ) selected @endif value="Mestrado">Mestrado</option>
                                        <option @if(old('titulacaoMaxima')=='Especialização' ) selected @endif value="Especialização">Especialização</option>
                                        <option @if(old('titulacaoMaxima')=='Graduação' ) selected @endif value="Graduação">Graduação</option>
                                        <option @if(old('titulacaoMaxima')=='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                    </select>

                                    @error('titulacaoMaxima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="anoTitulacao" style="display: none">
                                    <label for="AnoTitulacao" class="col-form-label">{{ __('Ano da Titulação Máxima') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="AnoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" placeholder="Digite o ano de titulação" value="{{ old('anoTitulacao') }}" autocomplete="nome">

                                    @error('anoTitulacao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group" id="areaFormacao" style="display: none">
                                    <label for="areaFormacao" class="col-form-label">{{ __('Área de Formação') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" placeholder="Digite a sua área de formação" value="{{ old('areaFormacao') }}" autocomplete="nome">

                                    @error('areaFormacao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="siape" style="display: none">
                                    <label for="SIAPE" class="col-form-label">{{ __('SIAPE') }}</label>
                                    <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" placeholder="Digite o SIAPE" value="{{ old('SIAPE') }}" autocomplete="nome">

                                    @error('SIAPE')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="bolsista" style="display: none">
                                    <label for="bolsistaProdutividade" class="col-form-label">{{ __('Bolsista de Produtividade') }} <span style="color: red; font-weight:bold;">*</span></label><br>
                                    <select name="bolsistaProdutividade" id="bolsistaProdutividade" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" onchange="mudarNivel()">
                                        <option value="" disabled selected hidden>-- Bolsista --</option>
                                        <option @if(old('bolsistaProdutividade')=='nao' ) selected @endif value="nao">Não</option>
                                        <option @if(old('bolsistaProdutividade')=='sim' ) selected @endif value="sim">Sim</option>
                                    </select>
                                    @error('bolsistaProdutividade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="nivelInput" style="display: block;">
                                    <label for="nivel" class="col-form-label">{{ __('Nível') }} <span style="color: red; font-weight:bold;">*</span></label>
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
                            </div>

                            <!-- Estudante -->
                            <div class="col-md-6">
                                <div class="form-group" id="dataNascimento">
                                    @component('componentes.input', ['label' => 'Data de nascimento'])
                                    <input type="date" class="form-control" value="{{old('data_de_nascimento')}}" name="data_de_nascimento" placeholder="Data de nascimento" />
                                    @error('data_de_nascimento')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @endcomponent
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="curso">
                                    @component('componentes.input', ['label' => 'Curso'])
                                    <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)">
                                        <option value="" disabled selected hidden>-- Selecione uma opção--</option>
                                        <option @if((old('curso')) == 'Bacharelado em Agronomia' ) selected @endif value="Bacharelado em Agronomia">Bacharelado em Agronomia</option>
                                        <option @if((old('curso')) == 'Bacharelado em Ciência da Computação' ) selected @endif value="Bacharelado em Ciência da Computação">Bacharelado em Ciência da Computação</option>
                                        <option @if((old('curso')) == 'Bacharelado em Engenharia de Alimentos' ) selected @endif value="Bacharelado em Engenharia de Alimentos">Bacharelado em Engenharia de Alimentos</option>
                                        <option @if((old('curso')) == 'Bacharelado em Medicina Veterinária' ) selected @endif value="Bacharelado em Medicina Veterinária">Bacharelado em Medicina Veterinária</option>
                                        <option @if((old('curso')) == 'Bacharelado em Zootecnia' ) selected @endif value="Bacharelado em Zootecnia">Bacharelado em Zootecnia</option>
                                        <option @if((old('curso')) == 'Licenciatura em Letras' ) selected @endif value="Licenciatura em Letras">Licenciatura em Letras</option>
                                        <option @if((old('curso')) == 'Licenciatura em Pedagogia' ) selected @endif value="Licenciatura em Pedagogia">Licenciatura em Pedagogia</option>
                                        <option @if((old('curso')) == 'Outro' ) selected @endif value="Outro">Outro</option>
                                    </select>
                                    @error('curso')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @endcomponent
                                </div>                                
                            </div>                                
                            <div class="col-md-12" id='endereco'>
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:6px">
                                    <h5 class="card-title mb-0" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; font-family:Arial, Helvetica, sans-serif; ">Endereço</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="divCep">
                                    @component('componentes.input', ['label' => 'CEP'])
                                    <input name="cep" type="text" id="cep" value="{{ old('cep')}}" class="form-control cep" onblur="pesquisaCep(this.value)" />
                                    @error('cep')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="divUf">
                                    @component('componentes.input', ['label' => 'Estado'])
                                    <input name="uf" type="text" class="form-control" value="{{ old('uf')}}" id="uf" />
                                    @error('uf')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="divCidade">
                                    @component('componentes.input', ['label' => 'Cidade'])
                                    <input name="cidade" type="text" id="cidade" class="form-control" value="{{ old('cidade')}}" />
                                    @error('cidade')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>                                                                        
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="divBairro">
                                    @component('componentes.input', ['label' => 'Bairro'])
                                    <input name="bairro" type="text" id="bairro" class="form-control" value="{{ old('bairro')}}" />
                                    @error('bairro')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>                                    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id='divRua'>
                                    @component('componentes.input', ['label' => 'Rua'])
                                    <input name="rua" type="text" id="rua" class="form-control" value="{{ old('rua')}}" />
                                    @error('rua')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id='numero'>
                                    @component('componentes.input', ['label' => 'Número'])
                                    <input name="numero" type="text" class="form-control" value="{{ old('numero')}}" />
                                    @error('numero')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @endcomponent
                                </div>
                            </div>
                            <div class='col-md-12'>
                                <div class="form-group" id='complemento'>
                                    <label class=" control-label" for="firstname">Complemento</label>
                                    <input type="text" class="form-control" value="{{old('complemento')}}" name="complemento" placeholder="Complemento" maxlength="75" id="complemento" />
                                    <span style="color: red; font-size: 12px" id="caracsRestantescomplemento">
                                    </span>
                                    @error('complemento')
                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="linkLattes" class="col-form-label">{{ __('Link do Currículo Lattes') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" placeholder="Digite o link do currículo Lattes" value="{{ old('linkLattes') }}" autocomplete="nome">

                                    @error('linkLattes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>  
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:6px">
                                    <h5 class="card-title mb-0" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; font-family:Arial, Helvetica, sans-serif; ">Acesso ao sistema</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="col-form-label">{{ __('E-Mail') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Digite o seu e-mail" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="col-form-label">{{ __('Senha') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Digite sua senha" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <small>Deve ter no mínimo 8 caracteres</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="col-form-label">{{ __('Confirme a Senha') }} <span style="color: red; font-weight:bold;">*</span></label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme sua senha" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="nivelInput" style="display: block; text-align:right">
                                    <hr>
                                    <button type="submit" class="btn btn-success botao-form" style="">
                                        {{ __('Finalizar Cadastro') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function($) {
        $('#cpf').mask('000.000.000-00');
        var SPMaskBehavior = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('#celular').mask(SPMaskBehavior, spOptions);
        $('#SIAPE').mask('00000000');
        $('#AnoTitulacao').mask('0000');
        $('#cep').mask('00000-000');
    });

    function mudarPerfil() {
        var divDataNascimento = document.getElementById('dataNascimento');
        var divCurso = document.getElementById('curso');
        var divEndereco = document.getElementById('endereco');    
        var divCep = document.getElementById('divCep'); 
        var divUf = document.getElementById('divUf'); 
        var divCidade = document.getElementById('divCidade'); 
        var divBairro = document.getElementById('divBairro'); 
        var divRua = document.getElementById('divRua');
        var divNumero = document.getElementById('numero'); 
        var divComplemento = document.getElementById('complemento');         

        var divCursos = document.getElementById('divCursos');
        var divVinculo = document.getElementById('divVinculo');
        var divTitulacaoMax = document.getElementById('divTitulacaoMax');
        var divAnoTitulacao = document.getElementById('anoTitulacao');
        var divAreaFormacao = document.getElementById('areaFormacao');
        var divSIAPE = document.getElementById('siape');
        var divBolsista = document.getElementById('bolsista');        
        var divNivel = document.getElementById('nivelInput');
        var divOutroVinculo = document.getElementById('divOutro');

        var comboBoxPerfil = document.getElementById('perfil');

        if(comboBoxPerfil.value === "Professor" || comboBoxPerfil.value === "Técnico" || comboBoxPerfil.value === "Outro"){
            divVinculo.style.display = "block";
            divTitulacaoMax.style.display = "block";
            divAnoTitulacao.style.display = "block";
            divAreaFormacao.style.display = "block";
            divSIAPE.style.display = "block";
            divBolsista.style.display = "block";

            if (comboBoxPerfil.value === "Professor" || comboBoxPerfil.value === "Técnico" ){
                divCursos.style.display = "block";
            } else {
                divCursos.style.display = "none";
            }


        } else {
            divVinculo.style.display = "none";
            divTitulacaoMax.style.display = "none";
            divAnoTitulacao.style.display = "none";
            divAreaFormacao.style.display = "none";
            divSIAPE.style.display = "none";
            divBolsista.style.display = "none";
            divCursos.style.display = "none";
        }
        
        if(comboBoxPerfil.value === "Estudante"){
            divDataNascimento.style.display = "block";
            divCurso.style.display = "block";
            divEndereco.style.display = "block";
            divCep.style.display = "block";
            divUf.style.display = "block";
            divCidade.style.display = "block";
            divBairro.style.display = "block";
            divRua.style.display = "block";
            divNumero.style.display = "block";
            divComplemento.style.display = "block";
            divNivel.style.display = "none";
            divOutroVinculo.style.display = "none";
            
        } else {
            divDataNascimento.style.display = "none";
            divCurso.style.display = "none";
            divEndereco.style.display = "none";
            divCep.style.display = "none";
            divUf.style.display = "none";
            divCidade.style.display = "none";
            divBairro.style.display = "none";
            divRua.style.display = "none";
            divNumero.style.display = "none";
            divComplemento.style.display = "none";
        }

        outroPerfil();
        outroVinculo();
    }

    function outroPerfil() {
        var comboBoxPerfil = document.getElementById('perfil');
        var divOutro = document.getElementById('outroPerfil');

        if (comboBoxPerfil.value === "Outro") {
            divOutro.style.display = "block";
        } else {
            divOutro.style.display = "none";
        }
    }

    function outroVinculo() {
        var comboBoxVinculo = document.getElementById('vinculo');
        var divOutro = document.getElementById('divOutro');

        if (comboBoxVinculo.value === "Outro" && document.getElementById('perfil').value !== "Estudante") {
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

    function showInstituicao() {
        var instituicao = document.getElementById('instituicao');
        var instituicaoSelect = document.getElementById('instituicaoSelect');

        if (instituicaoSelect.value === "Outra") {
            document.getElementById("displayOutro").style.display = "block";
            instituicao.parentElement.style.display = '';
            document.getElementById('instituicao').value = "";
        } else if (instituicaoSelect.value === "UFAPE") {
            document.getElementById("displayOutro").style.display = "none";
        }
    }

    function onload() {
        mudarNivel();
        outroVinculo();
        mudarPerfil();
        showInstituicao();
    }
    window.onload = onload();
</script>

<script>
//----------------------------- Scripts para auto-complete de endereço --------------------------------//

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById(`rua`).value = ("");
        document.getElementById(`bairro`).value = ("");
        document.getElementById(`cidade`).value = ("");
        document.getElementById(`uf`).value = ("");
        //document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById(`rua`).value = (conteudo.logradouro);
            document.getElementById(`bairro`).value = (conteudo.bairro);
            document.getElementById(`cidade`).value = (conteudo.localidade);
            document.getElementById(`uf`).value = (conteudo.uf);


            //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisaCep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById(`rua`).value = "...";
                document.getElementById(`bairro`).value = "...";
                document.getElementById(`cidade`).value = "...";
                document.getElementById(`uf`).value = "...";
                //document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

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
</script>


@endsection