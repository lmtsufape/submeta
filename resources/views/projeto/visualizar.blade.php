@extends('layouts.app')

@section('content')
<div class="container content">

  <div class="row justify-content-center">
    <div class="col-sm-12">
      <div class="card" style="margin-top:50px">
        <div class="card-body">
          <h3 class="card-title">Dados do Projeto</h3>
          <p class="card-text">
              <input type="hidden" name="editalId" value="{{ $edital->id }}">

              {{-- Nome do Projeto  --}}
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Nome do Projeto:') }}</label>
                  <input id="nomeTrabalho" value="{{ $projeto->titulo }}" type="text" class="form-control @error('nomeTrabalho') is-invalid @enderror" name="nomeProjeto" value="{{ old('nomeTrabalho') }}" required autocomplete="nomeTrabalho" autofocus disabled>

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
                  <select class="form-control @error('grandeArea') is-invalid @enderror" id="grandeArea" name="grandeArea" disabled>
                    <option value="" disabled selected hidden>-- Grande Área --</option>
                    @foreach($grandeAreas as $grandeArea)
                      @if($grandeArea->id === $projeto->grande_area_id)
                        <option value="{{$grandeArea->id}}" selected>{{$grandeArea->nome}}</option>
                      @else
                        <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                      @endif
                    @endforeach
                  </select>

                  @error('grandeArea')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                  <select class="form-control @error('area') is-invalid @enderror" id="area" name="area" disabled>
                    <option value="" disabled selected hidden>-- Área --</option>
                    @foreach($areas as $area)
                      @if($area->id === $projeto->area_id)
                        <option value="{{$area->id}}" selected>{{$area->nome}}</option>
                      @else
                        <option value="{{$area->id}}">{{$area->nome}}</option>
                      @endif
                    @endforeach
                  </select>

                  @error('area')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-4">
                  <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                  <select class="form-control @error('subArea') is-invalid @enderror" id="subArea" name="subArea" disabled>
                    <option value="" disabled selected hidden>-- Sub Área --</option>
                    @foreach($subAreas as $subArea)
                      @if($subArea->id === $projeto->sub_area_id)
                        <option value="{{$subArea->id}}" selected>{{$subArea->nome}}</option>
                      @else
                        <option value="{{$subArea->id}}">{{$subArea->nome}}</option>
                      @endif
                    @endforeach
                  </select>

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
                  <input class="form-control" value="{{ auth()->user()->name }}" type="text" id="nomeCoordenador" name="nomeCoordenador" disabled="disabled" value="{{ Auth()->user()->name }}">
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                  <input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante"
                  @if(Auth()->user()->proponentes->linkLattes != null)
                    value="{{ Auth()->user()->proponentes->linkLattes }}"
                  @else
                    value=""
                  @endif disabled>

                  @error('linkLattesEstudante')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                  <input value="{{ $projeto->pontuacaoPlanilha }}" class="form-control @error('pontuacaoPlanilha') is-invalid @enderror" type="text" name="pontuacaoPlanilha" disabled>

                  @error('pontuacaoPlanilha')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-sm-6">
                  <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                  <input value="{{ $projeto->linkGrupoPesquisa }}" class="form-control @error('linkGrupo') is-invalid @enderror" type="text" name="linkGrupo" disabled>

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
              <div class="row">
                {{-- Arquivo  --}}
                <ul>
                    <li>
                        <a href="{{ route('baixar.anexo.projeto', ['id' => $projeto->id])}}">{{ __('Projeto') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('baixar.anexo.lattes', ['id' => $projeto->id]) }}">{{ __('Lattes do Coordenador') }}</a>
                    </li>
                    <li>
                        @if (!(is_null($projeto->anexoAutorizacaoComiteEdica))) 
                            <a href="{{ route('baixar.anexo.comite', ['id' => $projeto->id]) }}">{{ __('Autorização do Comitê de Ética') }}</a>
                        @else
                        <a href="#">{{ __('Justificativa do Comitê de Ética') }}</a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('baixar.anexo.planilha', ['id' => $projeto->id]) }}">{{ __('Planilha de Pontuação') }}</a>
                    </li>
                    @if($edital->tipo == 'PIBIC' || $edital->tipo == 'PIBIC-EM')
                    <li>
                        <a href="{{ route('baixar.anexo.consu', ['id' => $projeto->id]) }}">{{__('Decisão do CONSU')}}</a>
                    </li>
                    @endif
                </ul>
            </div>

            <hr>
              
              <h3>Participantes</h3>

              {{-- Participantes  --}}
              <div class="row" style="margin-top:20px">
                <div class="col-sm-12">
                  <div id="participantes">
                    @foreach($participantes as $participante)
                      @foreach($users as $user)
                        @if($participante->user_id === $user->id)
                          <div id="novoParticipante">
                            <br>
                            <div class="row">
                              <div class="col-sm-5">
                                <label>Nome Completo</label>
                                <input value="{{ $user->name }}" type="text" style="margin-bottom:10px" class="form-control @error('nomeParticipante') is-invalid @enderror" name="nomeParticipante[]" placeholder="Nome" required disabled>
                                @error('nomeParticipante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                              <div class="col-sm-4">
                                <label>E-mail</label>
                                <input value="{{ $user->email }}" type="email" style="margin-bottom:10px" class="form-control @error('emailParticipante') is-invalid @enderror" name="emailParticipante[]" placeholder="email" required disabled>
                                @error('emailParticipante')
                                <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                              <div class="col-sm-3">
                                <label>Função:</label>
                                <select class="form-control @error('funcaoParticipante') is-invalid @enderror" name="funcaoParticipante[]" id="funcaoParticipante" disabled>
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
                            @foreach ($arquivos as $arquivo)
                            @if($arquivo->participanteId === $participante->id)
                                <a href="{{ route('baixar.plano', ['id' => $arquivo->id]) }}">Plano de trabalho atual</a>
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
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('javascript')
<script>
</script>
@endsection