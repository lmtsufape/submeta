@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="margin-top: 100px; ">{{ __('Editar um usuário') }}</h2>
        </div>
    </div>  
    <div class="row">
        <form method="POST" action="{{ route('admin.user.update', ['id' => $user->id]) }}">
            @csrf
            {{-- Nome | CPF --}}
            <div class="form-group row">
    
                <div class="col-md-8">
                    <label for="name" class="col-form-label">{{ __('Nome Completo*') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') != null ? old('name') : $user->name }}" required autocomplete="name" autofocus>
    
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
    
                <div class="col-md-4">
                    <label for="cpf" class="col-form-label">{{ __('CPF*') }}</label>
                    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') != null ? old('cpf') : $user->cpf }}" required autocomplete="cpf" autofocus>
    
                    @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            {{-- Instituição de Ensino e Celular --}}
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
                <div class="col-md-4">
                    <label for="tipo" class="col-form-label">{{ __('Tipo*') }}</label>
                    <select name="tipo" id="tipo" onchange="mudar()" class="form-control @error('tipo') is-invalid @enderror">
                        @if (old('tipo') != null) 
                            @if(auth()->user()->tipo == 'administrador')
                                <option @if ( old('tipo') == 'administradorResponsavel') selected @endif value="administradorResponsavel">Administrador responsável</option>
                            @endif
                            <option @if ( old('tipo') == 'coordenador') selected @endif value="coordenador">Coordenador</option>
                            <option @if ( old('tipo') == 'avaliador') selected @endif value="avaliador">Avaliador</option>
                            <option @if ( old('tipo') == 'proponente') selected @endif value="proponente">Proponente</option>
                            <option @if ( old('tipo') == 'participante') selected @endif value="participante">Participante</option>
                        @else 
                            @if(auth()->user()->tipo == 'administrador')
                                <option @if($user->tipo == 'administradorResponsavel') selected @endif value="administradorResponsavel">Administrador responsável</option>
                            @endif
                            <option @if($user->tipo == 'coordenador') selected @endif  value="coordenador">Coordenador</option>
                            <option @if($user->tipo == 'avaliador') selected @endif value="avaliador">Avaliador</option>
                            <option @if($user->tipo == 'proponente') selected @endif value="proponente">Proponente</option>
                            <option @if($user->tipo == 'participante') selected @endif value="participante">Participante</option>
                        @endif
                    </select>

                    @error('tipo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <input type="checkbox" id="confirmarMudançaDeTipo" name="confirmarMudançaDeTipo" @error('tipo') @else style="display: none;" @enderror>
                    <label for="confirmarMudançaDeTipo" @error('tipo') @else style="display: none;" @enderror>Desejo alterar o tipo do usuário mesmo assim</label>
                </div>        
                <div class="col-md-2">
                    <label for="celular" class="col-form-label">{{ __('Celular*') }}</label>
                    <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') != null ? old('celular') : $user->celular }}" required autocomplete="celular" autofocus>
    
                    @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
    
            </div>
    
            {{-- Email --}}
            <div class="form-group row">
    
                <div class="col-md-3">
                    <label for="email" class="col-form-label">{{ __('E-Mail*') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
    
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div id="divEditais" class="col-md-3" @if($participante != null) style="display: block; border: none;" @else style="display: none; border: none;" @endif>
                    <label for="edital" class="col-form-label">{{ __('Edital*') }}</label>
                    <select id="edital" name="edital" class="form-control @error('edital') is-invalid @enderror" onchange="projetosTeste()">
                        <option value="" disabled selected hidden>-- Edital --</option>
                        @if ($participante != null) 
                            {{-- Se já for do do tipo participante --}}
                            @if (old('edital') != null)
                                @foreach ($editais as $edital)
                                    <option @if( old('edital') == $edital->id ) selected @endif value="{{ $edital->id }}">{{ $edital->nome }}</option>
                                @endforeach
                            @else 
                                @foreach ($editais as $edital)
                                    <option @if( $editalParticipante->id == $edital->id ) selected @endif value="{{ $edital->id }}">{{ $edital->nome }}</option>
                                @endforeach
                            @endif
                        @elseif(old('edital') != null)
                            @foreach ($editais as $edital)
                                <option @if( old('edital') == $edital->id ) selected @endif value="{{ $edital->id }}">{{ $edital->nome }}</option>
                            @endforeach
                        @else
                            @foreach ($editais as $edital)
                                <option @if( old('edital') == $edital->id ) selected @endif value="{{ $edital->id }}">{{ $edital->nome }}</option>
                            @endforeach
                        @endif
                    </select>

                    @error('edital')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div id="divProjetos" class="col-md-3" @if($participante != null) style="display: block; border: none;" @else style="display: none; border: none;" @endif>
                    <label for="projeto" class="col-form-label">{{ __('Projeto*') }}</label>
                    <select id="projeto" name="projeto" class="form-control @error('projeto') is-invalid @enderror" onchange="">
                        @if($participante != null)
                            @foreach ($projetos as $projeto)
                                <option @if($participante->trabalho_id == $projeto->id) selected @endif value="{{ $projeto->id }}">{{ $projeto->titulo }}</option>
                            @endforeach
                        @else
                            <option value="" disabled selected>-- Projeto --</option>
                        @endif
                    </select>

                    @error('projeto')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div id="divAreas" class="col-md-3" @if($avaliador != null) style="display: block; border: none;" @else style="display: none; border: none;" @endif>
                    <label for="area" class="col-form-label">{{ __('Área*') }}</label>
                    <select id="area" name="area" class="form-control @error('area') is-invalid @enderror" onchange="">
                        <option disabled selected hidden value="">-- Área --</option> 
                        @if(old('area') != null)
                            @foreach ($areas as $area)
                                <option @if(old('area') == $area->id) selected @endif value="{{ $area->id }}">{{ $area->nome }}</option>
                            @endforeach
                        @elseif ($avaliador != null)
                            @foreach ($areas as $area)
                                <option @if($avaliador->area_id == $area->id) selected @endif value="{{ $area->id }}">{{ $area->nome }}</option>
                            @endforeach
                        @else 
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nome }}</option>
                            @endforeach
                        @endif
                    </select>

                    @error('area')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div id="divFuncaoParticipante" class="col-md-3" @if($participante != null) style="display: block; border: none;" @else style="display: none; border: none;" @endif>
                    <label for="funcaoParticipante" class="col-form-label">{{ __('Função de participante*') }}</label>
                    <select id="funcaoParticipante" name="funcaoParticipante" class="form-control @error('funcaoParticipante') is-invalid @enderror" onchange="">
                        <option value="" disabled selected hidden>-- Função de Participante --</option>
                        @if ($participante != null)
                            @foreach($funcaoParticipantes as $funcaoParticipante)
                                <option  @if ($participante->funcao_participante_id == $funcaoParticipante->id) selected @endif value="{{ $funcaoParticipante->id }}">{{ $funcaoParticipante->nome }}</option>
                            @endforeach
                        @else
                            @foreach($funcaoParticipantes as $funcaoParticipante)
                                <option  @if (old('funcaoParticipante') == $funcaoParticipante->id) selected @endif value="{{ $funcaoParticipante->id }}">{{ $funcaoParticipante->nome }}</option>
                            @endforeach
                        @endif
                    </select>

                    @error('funcaoParticipante')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            @if(!(is_null($proponente)))
            <div id="proponente" style="display: block;">
    
                <div>
                    <h4>Dados do proponente</h4>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="cargo" class="col-form-label">{{ __('Cargo*') }}</label>
                        <select id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror" onchange="">
                            <option value="" disabled selected hidden>-- Cargo --</option>
                            @if (old('cargo') != null) 
                                <option @if( old('cargo') =='Professor' ) selected @endif value="Professor">Professor</option>
                                <option @if( old('cargo') =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                <option @if( old('cargo') =='Estudante' ) selected @endif value="Estudante">Estudante</option>
                            @else
                                <option @if( $proponente->cargo =='Professor' ) selected @endif value="Professor">Professor</option>
                                <option @if( $proponente->cargo =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                <option @if( $proponente->cargo =='Estudante' ) selected @endif value="Estudante">Estudante</option>
                            @endif
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
                            @if (old('vinculo') != null)
                                <option value="" disabled selected hidden>-- Vínculo --</option>
                                <option @if(old('vinculo') =='Servidor na ativa' ) selected @endif value="Servidor na ativa">Servidor na ativa</option>
                                <option @if(old('vinculo') =='Servidor aposentado' ) selected @endif value="Servidor aposentado">Servidor aposentado</option>
                                <option @if(old('vinculo') =='Professor visitante' ) selected @endif value="Professor visitante">Professor visitante</option>
                                <option @if(old('vinculo') =='Pós-doutorando' ) selected @endif value="Pós-doutorando">Pós-doutorando</option>
                                <option @if(old('vinculo') =='Outro' ) selected @endif value="Outro">Outro</option>
                                @if (old('vinculo') !='Servidor na ativa' && old('vinculo') !='Servidor aposentado' && old('vinculo') !='Professor visitante' && old('vinculo') !='Pós-doutorando' && old('vinculo') !='Outro')
                                    <option value="{{ old('vinculo') }}" selected >{{ old('vinculo') }}</option>
                                @endif
                            @else 
                                <option value="" disabled selected hidden>-- Vínculo --</option>
                                <option @if($proponente->vinculo =='Servidor na ativa' ) selected @endif value="Servidor na ativa">Servidor na ativa</option>
                                <option @if($proponente->vinculo =='Servidor aposentado' ) selected @endif value="Servidor aposentado">Servidor aposentado</option>
                                <option @if($proponente->vinculo =='Professor visitante' ) selected @endif value="Professor visitante">Professor visitante</option>
                                <option @if($proponente->vinculo =='Pós-doutorando' ) selected @endif value="Pós-doutorando">Pós-doutorando</option>
                                <option @if($proponente->vinculo =='Outro' ) selected @endif value="Outro">Outro</option>
                                @if ($proponente->vinculo !='Servidor na ativa' && $proponente->vinculo !='Servidor aposentado' && $proponente->vinculo !='Professor visitante' && $proponente->vinculo !='Pós-doutorando' && $proponente->vinculo !='Outro')
                                    <option value="{{ $proponente->vinculo }}" selected >{{ $proponente->vinculo }}</option>
                                @endif
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
                            <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="{{ old('titulacaoMaxima') }}" autocomplete="titulacaoMaxima">
                                @if (old('titulacaoMaxima') != null) 
                                    <option value="" disabled selected hidden>-- Titulação --</option>
                                    <option @if( old('titulacaoMaxima') =='Doutorado' ) selected @endif value="Doutorado">Doutorado</option>
                                    <option @if( old('titulacaoMaxima') =='Mestrado' ) selected @endif value="Mestrado">Mestrado</option>
                                    <option @if( old('titulacaoMaxima') =='Especialização' ) selected @endif value="Especialização">Especialização</option>
                                    <option @if( old('titulacaoMaxima') =='Graduação' ) selected @endif value="Graduação">Graduação</option>
                                    <option @if( old('titulacaoMaxima') =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                @else
                                    <option value="" disabled selected hidden>-- Titulação --</option>
                                    <option @if( $proponente->titulacaoMaxima =='Doutorado' ) selected @endif value="Doutorado">Doutorado</option>
                                    <option @if( $proponente->titulacaoMaxima =='Mestrado' ) selected @endif value="Mestrado">Mestrado</option>
                                    <option @if( $proponente->titulacaoMaxima =='Especialização' ) selected @endif value="Especialização">Especialização</option>
                                    <option @if( $proponente->titulacaoMaxima =='Graduação' ) selected @endif value="Graduação">Graduação</option>
                                    <option @if( $proponente->titulacaoMaxima =='Técnico' ) selected @endif value="Técnico">Técnico</option>
                                @endif
                            </select>
        
                            @error('titulacaoMaxima')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        <div class="col-md-4">
                            <label for="anoTitulacao" class="col-form-label">{{ __('Ano da Titulação*') }}</label>
                            <input id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" value="{{ old('anoTitulacao') != null ? old('anoTitulacao') : $proponente->anoTitulacao }}" autocomplete="anoTitulacao">
        
                            @error('anoTitulacao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="areaFormacao" class="col-form-label">{{ __('Área de Formação*') }}</label>
                            <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" value="{{ old('areaFormacao') != null ? old('areaFormacao') : $proponente->areaFormacao }}" autocomplete="areaFormacao">
        
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
                            <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" value="{{ old('SIAPE') != null ? old('SIAPE') : $proponente->SIAPE }}" autocomplete="SIAPE">
        
                            @error('SIAPE')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        <div class="col-md-4">
                            <label for="linkLattes" class="col-form-label">{{ __('Link do currículo Lattes*') }}</label>
                            <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" value="{{ old('linkLattes') != null ? old('linkLattes') : $proponente->linkLattes }}" autocomplete="linkLattes">
        
                            @error('linkLattes')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        <div class="col-md-3">
                            <label for="bolsistaProdutividade" class="col-form-label">{{ __('Bolsista de Produtividade*') }}</label><br>
                            <select name="bolsistaProdutividade" id="bolsistaProdutividade" class="form-control @error('bolsistaProdutividade') is-invalid @enderror" onchange="mudarNivel()">
                                @if (old('bolsistaProdutividade') != null)
                                    <option value="" disabled selected hidden>-- Bolsista --</option>
                                    <option @if( old('bolsistaProdutividade') =='nao' ) selected @endif value="nao">Não</option>
                                    <option @if( old('bolsistaProdutividade') =='sim' ) selected @endif value="sim">Sim</option>
                                @else
                                    <option value="" disabled selected hidden>-- Bolsista --</option>
                                    <option @if( $proponente->bolsistaProdutividade =='nao' ) selected @endif value="nao">Não</option>
                                    <option @if( $proponente->bolsistaProdutividade =='sim' ) selected @endif value="sim">Sim</option>
                                @endif
                            </select>
                            @error('bolsistaProdutividade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        @if (old('nivel') == null)
                            <div class="col-md-1" id="nivelInput" @if ($proponente->bolsistaProdutividade =='sim') style="display: block;" @else style="display: none;" @endif>
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
                            <div class="col-md-1" id="nivelInput" @if (old('bolsistaProdutividade') =='sim') style="display: block;" @else style="display: none;" @endif>
                                <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                                <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                    <option value="" disabled selected hidden></option>                     
                                    <option @if( old('nivel') == '1A') selected @endif value="1A">1A</option>
                                    <option @if( old('nivel') == '1B') selected @endif value="1B">1B</option>
                                    <option @if( old('nivel') == '1C') selected @endif value="1C">1C</option>
                                    <option @if( old('nivel') == '1D') selected @endif value="1D">1D</option>
                                    <option @if( old('nivel') == '2') selected @endif value="2">2</option>
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
                <div class="row justify-content-center" style="margin: 20px 0 20px 0">
        
                    <div class="col-md-6" style="padding-left:0">
                        <a class="btn btn-secondary botao-form" href="/" style="width:100%">Cancelar</a>
                    </div>
                    <div class="col-md-6" style="padding-right:0">
                        <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                            {{ __('Salvar') }}
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div id="proponente" style="display: none;">
    
                <div>
                    <h4>Dados do proponente</h4>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="cargo" class="col-form-label">{{ __('Cargo*') }}</label>
                        <select id="cargo" name="cargo" class="form-control @error('cargo') is-invalid @enderror" onchange="">
                            <option value="" disabled selected hidden>-- Cargo --</option>
                            <option @if(old('cargo')=='Professor' ) selected @endif value="Professor">Professor</option>
                            <option @if(old('cargo')=='Técnico' ) selected @endif value="Técnico">Técnico</option>
                            <option @if(old('cargo')=='Estudante' ) selected @endif value="Estudante">Estudante</option>
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
                            <select id="titulacaoMaxima" class="form-control @error('titulacaoMaxima') is-invalid @enderror" name="titulacaoMaxima" value="{{ old('titulacaoMaxima') }}" autocomplete="titulacaoMaxima">
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
        
                        <div class="col-md-4">
                            <label for="anoTitulacao" class="col-form-label">{{ __('Ano da Titulação*') }}</label>
                            <input id="anoTitulacao" type="text" class="form-control @error('anoTitulacao') is-invalid @enderror" name="anoTitulacao" value="{{ old('anoTitulacao') }}" autocomplete="anoTitulacao">
        
                            @error('anoTitulacao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="areaFormacao" class="col-form-label">{{ __('Área de Formação*') }}</label>
                            <input id="areaFormacao" type="text" class="form-control @error('areaFormacao') is-invalid @enderror" name="areaFormacao" value="{{ old('areaFormacao') }}" autocomplete="areaFormacao">
        
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
                            <input id="SIAPE" type="text" class="form-control @error('SIAPE') is-invalid @enderror" name="SIAPE" value="{{ old('SIAPE') }}" autocomplete="SIAPE">
        
                            @error('SIAPE')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        <div class="col-md-4">
                            <label for="linkLattes" class="col-form-label">{{ __('Link do currículo Lattes*') }}</label>
                            <input id="linkLattes" type="text" class="form-control @error('linkLattes') is-invalid @enderror" name="linkLattes" value="{{ old('linkLattes') }}" autocomplete="linkLattes">
        
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
                                <option @if(old('bolsistaProdutividade')=='nao' ) selected @endif value="nao">Não</option>
                                <option @if(old('bolsistaProdutividade')=='sim' ) selected @endif value="sim">Sim</option>
                            </select>
                            @error('bolsistaProdutividade')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
        
                        <div class="col-md-1" id="nivelInput" @if (old('bolsistaProdutividade') =='sim') style="display: block;" @else style="display: none;" @endif>
                            <label for="nivel" class="col-form-label">{{ __('Nível*') }}</label>
                            <select name="nivel" id="nivel" class="form-control @error('nivel') is-invalid @enderror">
                                <option value="" disabled selected hidden></option>                     
                                <option @if( old('nivel') == '1A') selected @endif value="1A">1A</option>
                                <option @if( old('nivel') == '1B') selected @endif value="1B">1B</option>
                                <option @if( old('nivel') == '1C') selected @endif value="1C">1C</option>
                                <option @if( old('nivel') == '1D') selected @endif value="1D">1D</option>
                                <option @if( old('nivel') == '2') selected @endif value="2">2</option>
                            </select>
                            @error('nivel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                </div>
                <div class="row justify-content-center" style="margin: 20px 0 20px 0">
        
                    <div class="col-md-6" style="padding-left:0">
                        <a class="btn btn-secondary botao-form" href="/" style="width:100%">Cancelar</a>
                    </div>
                    <div class="col-md-6" style="padding-right:0">
                        <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                            {{ __('Salvar') }}
                        </button>
                    </div>
                </div>
            </div>
            @endif
            
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script>
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

    });
    
    function mudar() {
        var divProponente = document.getElementById('proponente');
        var comboBoxTipo = document.getElementById('tipo');
        var comboBoxEditais = document.getElementById('divEditais');
        var comboBoxProjetos = document.getElementById('divProjetos');
        var comboBoxFuncaoParticipante = document.getElementById('divFuncaoParticipante');
        var comboBoxAreas = document.getElementById('divAreas');
        
        if (comboBoxTipo.value == "proponente") {
            divProponente.style.display = "block";
            comboBoxEditais.style.display = "none";
            comboBoxProjetos.style.display = "none";
            comboBoxFuncaoParticipante.style.display = "none";
            comboBoxAreas.style.display = "none";
        } else if (comboBoxTipo.value == "participante") {
            comboBoxEditais.style.display = "block";
            comboBoxProjetos.style.display = "block";
            divProponente.style.display = "none";
            comboBoxFuncaoParticipante.style.display = "block";
            comboBoxAreas.style.display = "none";
        } else if (comboBoxTipo.value == "avaliador") {
            divProponente.style.display = "none";
            comboBoxEditais.style.display = "none";
            comboBoxProjetos.style.display = "none";
            comboBoxFuncaoParticipante.style.display = "none";
            comboBoxAreas.style.display = "block";
        } else {
            divProponente.style.display = "none";
            comboBoxEditais.style.display = "none";
            comboBoxProjetos.style.display = "none";
            comboBoxFuncaoParticipante.style.display = "none";
            comboBoxAreas.style.display = "none";
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
            instituicaoSelect.parentElement.className = 'col-md-2';
            instituicao.parentElement.style.display = '';
        }else if(instituicaoSelect.value === "UFAPE"){
            instituicaoSelect.parentElement.className = 'col-md-6';
            instituicao.parentElement.style.display = 'none';
        }
    }

    function projetosTeste() {
        var edital = $('#edital').val();
        $.ajax({
            type: 'POST',
            url: '{{ route('trabalho.consulta') }}',
            data: 'id='+edital ,
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (dados) => {
            console.log(dados);
            if (dados.length > 0) {
            if($('#projeto').val() == null || $('#projeto').val() == ""){
                var option = '<option selected disabled>-- Projeto --</option>';
            }
            $.each(dados, function(i, obj) {
                if($('#projeto').val() != null && $('#projeto').val() == obj.id){
                    option += '<option selected value="' + obj.id + '">' + obj.titulo + '</option>';
                }else{
                    option += '<option value="' + obj.id + '">' + obj.titulo + '</option>';
                }
            })
            } else {
                var option = "<option selected disabled>-- Projeto --</option>";
            }
            $('#projeto').html(option).show();
        },
            error: (data) => {
                console.log(data);
            }

        })
    }

    window.onload = showInstituicao();
</script>
@endsection