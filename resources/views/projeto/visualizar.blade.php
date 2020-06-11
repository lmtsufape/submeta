@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                    <h5 class="card-title">Visualizar Projeto</h5>
                    <p class="card-text">
                        <input type="hidden" name="editalId" value="{{ $edital->id }}">

                        {{-- Nome do Projeto  --}}
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Nome do Projeto:') }}</label>
                                <span id="nomeTrabalho" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeProjeto" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus>
                                {{ $projeto->titulo }} </span>

                                @error('nomeTrabalho')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Grande Area --}}
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <label for="grandeArea" class="col-form-label">{{ __('Grande Área:') }}</label>
                                <span class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea">
                                    {{$grandeArea->nome}}</span>
                                @error('grandeArea')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                                <span class="form-control @error('area') is-invalid @enderror" id="area" name="area">
                                    {{$area->nome}}</span>
                                @error('area')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                                <span  class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea">
                                    {{$subArea->nome}}</span>

                                @error('subArea')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <hr>
                        <h3>Coordenador</h3>

                        {{-- Coordenador  --}}
                        <div class="row justify-content-center">

                            <div class="col-sm-6">
                                <label for="nomeCoordenador" class="col-form-label">{{ __('Coordenador:') }}</label>
                                <span class="form-control"  type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                                {{ $proponente->user->name }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                                <span class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante">
                                @if($proponente->linkLattes != null)
                                    {{ $proponente->linkLattes }}                               
                                @endif
                                </span>

                                @error('linkLattesEstudante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                                <span class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha">
                                    {{$projeto->pontuacaoPlanilha}}</span>
                                @error('pontuacaoPlanilha')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                                <span  class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo">
                                {{ $projeto->linkGrupoPesquisa }}</span>
                                @error('linkGrupo')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <hr>
                        <h3>Anexos</h3>

                        {{-- Anexo do Projeto --}}
                        <div class="row justify-content-center">
                            {{-- Arquivo  --}}
                            <div class="col-sm-6">
                                <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto: ') }}</label> <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}">Arquivo atual</a>

                                
                                @error('anexoProjeto')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador: ') }}</label><a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                                
                                @error('anexoLatterCoordenador')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>





                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>
                                @if($projeto->anexoAutorizacaoComiteEtica != null)
                                    <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                                @else
                                    -
                                @endif
                                
                                <br>
                                                                
                                @error('anexoComiteEtica')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-sm-6 mt-3">
                                <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação: ') }}</label><a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                                
                                @error('anexoPlanilha')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>
                                @if($projeto->justificativaAutorizacaoEtica != null)
                                    <a href="{{ route('baixar.anexo.justificativa', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                                @else
                                    -
                                @endif
                                
                                @error('justificativaAutorizacaoEtica')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                            {{-- Decisão do CONSU --}}
                            <div class="col-sm-6">
                                <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label><a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"> Arquivo atual</a>

                               
                                @error('anexoCONSU')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endif

                        </div>

                        <hr>
                        <h4>Participantes</h4>

                        {{-- Participantes  --}}
                        <div class="row" style="margin-top:20px">
                            <div class="col-sm-12">
                                <div id="participantes">
                                    @foreach($participantes as $participante)
                                    @foreach($users as $user)
                                    @if($participante->user_id === $user->id)
                                    <div id="novoParticipante">
                                        <br>
                                        <h5>Dados do participante</h5>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label>Nome Completo</label>
                                                <span  type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" required>
                                                {{ $user->name }}</span>
                                                @error('nomeParticipante')
                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-4">
                                                <label>E-mail</label>
                                                <span type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" required>
                                                {{ $user->email }}</span>
                                                @error('emailParticipante')
                                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Função:</label>
                                                <select disabled class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante">
                                                    <option value="" disabled selected hidden>-- Função --</option>
                                                    @foreach($funcaoParticipantes as $funcaoParticipante)
                                                    @if($funcaoParticipante->id === $participante->funcao_participante_id)
                                                    <option value="{{$funcaoParticipante->id}}" selected>{{$funcaoParticipante->nome}}</option>
                                                    @else
                                                    <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                                    @endif
                                                    @endforeach

                                                    @error('funcaoParticipante')
                                                    <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>
                                        <h5>Dados do plano de trabalho</h5>
                                        @foreach ($arquivos as $arquivo)
                                                                @if($arquivo->participanteId === $participante->id)
                                                                    <a href="{{ route('baixar.plano', ['id' => $arquivo->id]) }}">Plano de trabalho atual</a>
                                                                @endif
                                                            @endforeach
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="planoTrabalho">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label>Titulo </label>
                                                            <span type="text" style="margin-bottom:10px" class="form-control @error('nomePlanoTrabalho') is-invalid @enderror" name="nomePlanoTrabalho[]" placeholder="Nome">
                                                                {{$arquivo->titulo}}
                                                            </span>

                                                            @error('nomePlanoTrabalho')
                                                            <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        {{-- Arquivo  --}}
                                                        <div class="col-sm-7">
                                                            <label for="nomeTrabalho">Anexo</label>
                                                            
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </div>
                                <a href="#" class="btn btn-primary" id="addCoautor" style="width:100%;margin-top:10px">Participantes +</a>
                            </div>
                        </div>

                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <a href="{{route('evento.visualizar',['id'=>$edital->id])}}" class="btn btn-secondary" style="width:100%">Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Enviar') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
