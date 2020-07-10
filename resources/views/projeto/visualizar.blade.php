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
                                <span id="nomeTrabalho" class="form-control" name="nomeProjeto">{{ $projeto->titulo }}</span>
                            </div>
                        </div>

                        {{-- Grande Area --}}
                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <label for="grandeArea" class="col-form-label">{{ __('Grande Área:') }}</label>
                                <span class="form-control" id="grandeArea" name="grandeArea">{{$grandeArea->nome}}</span>                               
                            </div>
                            <div class="col-sm-4">
                                <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                                <span class="form-control" id="area" name="area">{{$area->nome}}</span>                               
                            </div>
                            <div class="col-sm-4">
                                <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                                <span  class="form-control" id="subArea" name="subArea">{{$subArea->nome}}</span>
                            </div>
                        </div>

                        <hr>

                        <h3>Coordenador</h3>
                        {{-- Coordenador  --}}
                        <div class="row justify-content-center">

                            <div class="col-sm-6">
                                <label for="nomeCoordenador" class="col-form-label">{{ __('Coordenador:') }}</label>
                                <span class="form-control" id="nomeCoordenador" name="nomeCoordenador" disabled>{{ $proponente->user->name }}</span>
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                                <span class="form-control" name="linkLattesEstudante">
                                @if($proponente->linkLattes != null)
                                    {{ $proponente->linkLattes }}                               
                                @endif
                                </span>
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                                <span class="form-control" name="pontuacaoPlanilha">{{$projeto->pontuacaoPlanilha}}</span>                               
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                                <span  class="form-control" name="linkGrupo">{{ $projeto->linkGrupoPesquisa }}</span>                               
                            </div>

                        </div>

                        <hr>
                        <h3>Anexos</h3>

                        {{-- Anexo do Projeto --}}
                        <div class="row justify-content-center">
                            {{-- Arquivo  --}}
                            <div class="col-sm-6">
                                <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto: ') }}</label> 
                                <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}">Arquivo atual</a>
                            </div>

                            <div class="col-sm-6">
                                <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador: ') }}</label>
                                <a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>
                                @if($projeto->anexoAutorizacaoComiteEtica != null)
                                    <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                                @else
                                    -
                                @endif                               
                            </div>

                            <div class="col-sm-6">
                                <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação: ') }}</label>
                                <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                            </div>

                            <div class="col-sm-6">
                                <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>
                                @if($projeto->justificativaAutorizacaoEtica != null)
                                    <a href="{{ route('baixar.anexo.justificativa', ['id' => $projeto->id]) }}"> Arquivo atual</a>
                                @else
                                    -
                                @endif                              
                            </div>

                            @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                            {{-- Decisão do CONSU --}}
                            <div class="col-sm-6">
                                <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label>
                                <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}"> Arquivo atual</a>
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
                                                        <span style="margin-bottom:10px" class="form-control" name="nomeParticipante[]">{{ $user->name }}</span>                                                    
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label>E-mail</label>
                                                        <span style="margin-bottom:10px" class="form-control" name="emailParticipante[]">{{ $user->email }}</span>                                                        
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label>Função:</label>
                                                        <select disabled class="form-control" name="funcaoParticipante[]" id="funcaoParticipante">
                                                            <option value="" disabled selected hidden>-- Função --</option>
                                                            @foreach($funcaoParticipantes as $funcaoParticipante)
                                                                @if($funcaoParticipante->id === $participante->funcao_participante_id)
                                                                <option value="{{$funcaoParticipante->id}}" selected>{{$funcaoParticipante->nome}}</option>
                                                                @else
                                                                <option value="{{$funcaoParticipante->id}}">{{$funcaoParticipante->nome}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <h5>Dados do plano de trabalho</h5>   
                                                @foreach($arquivos as $arquivo)                                            
                                                    @if($arquivo->participanteId === $participante->id)  
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div id="planoTrabalho">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label>Titulo </label>
                                                                        <span style="margin-bottom:10px" class="form-control" name="nomePlanoTrabalho[]">
                                                                            {{$arquivo->titulo}}
                                                                        </span>
                                                                    </div>
                                                                    
                                                                    {{-- Arquivo  --}}
                                                                    <div class="col-sm-7">
                                                                        <label for="nomeTrabalho">Anexo</label>                                                            
                                                                            <p>
                                                                                <a href="{{ route('baixar.plano', ['id' => $arquivo->id]) }}">Plano de trabalho atual</a>
                                                                            </p>                                                               
                                                                    </div>                                                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>                               
                            </div>
                        </div>

                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            @if (Auth()->user()->administradors != null)
                                <a href="{{ route('admin.editais') }}" class="btn btn-secondary" style="width:100%">Voltar</a>
                            @elseif ($participantes->contains('user_id', Auth()->user()->id))
                                <a href="{{route('participante.edital',['id'=>$edital->id])}}" class="btn btn-secondary" style="width:100%">Voltar</a> 
                            @else
                                <a href="{{ route('projetos.edital', ['id' => $edital->id]) }}" class="btn btn-secondary" style="width:100%">Voltar</a>
                            @endif
                            
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
