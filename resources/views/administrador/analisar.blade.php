@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Trabalhos do evento:  {{ $evento->nome }}</h3>
        {{-- <h6>Data inicioSubmissao: {{ date('d/m/Y', strtotime($evento->inicioSubmissao)) }}</h6>
        <h6>Data fim da submissao:  {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</h6>  --}}
        <h6>Data inicioRevisao:   {{ date('d/m/Y', strtotime($evento->inicioRevisao)) }}</h6>
        <h6>Data fimRevisao:      {{ date('d/m/Y', strtotime($evento->fimRevisao)) }}</h6>
        <h6>Data do resultado:       {{ date('d/m/Y', strtotime($evento->resultado_final)) }}</h6>
      </div>
    </div>
  </div>
  <hr>
      <div class="accordion" id="accordionExample">
        @foreach( $trabalhos as $trabalho )
        <div class="card ">
          <div class="card-header " id="headingOne">
            <h2 class="mb-0">

              <a class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne{{ $trabalho->id }}" aria-expanded="true" aria-controls="collapseOne">
                <h5>{{ $trabalho->titulo }}</h5>

              </a>
            </h2>
          </div>

          <div id="collapseOne{{ $trabalho->id }}" class="collapse @if($trabalhos->first() == $trabalho) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              {{-- <div class="card" style="margin-top:50px"> --}}
                  <div class="card-body">
                      <h5 class="card-title">Visualizar Projeto</h5>
                      <p class="card-text">
                          <input type="hidden" name="eventoId" value="{{ $evento->id }}">

                          {{-- Nome do Projeto  --}}
                          <div class="row justify-content-center">
                              <div class="col-sm-12">
                                  <label for="nomeTrabalho" class="col-form-label">{{ __('Nome do Projeto:') }}</label>
                                  <span id="nomeTrabalho" class="form-control" name="nomeProjeto">{{ $trabalho->titulo }}</span>
                              </div>
                          </div>

                          {{-- Grande Area --}}
                          <div class="row justify-content-center">
                              <div class="col-sm-4">
                                  <label for="grandeArea" class="col-form-label">{{ __('Grande Área:') }}</label>
                                  <span class="form-control" id="grandeArea" name="grandeArea">{{App\GrandeArea::where('id', $trabalho->grande_area_id)->first()->nome}}</span>
                              </div>
                              <div class="col-sm-4">
                                  <label for="area" class="col-form-label">{{ __('Área:') }}</label>
                                  <span class="form-control" id="area" name="area">{{App\Area::where('id', $trabalho->area_id)->first()->nome}}  </span>
                              </div>
                              <div class="col-sm-4">
                                  <label for="subArea" class="col-form-label">{{ __('Sub Área:') }}</label>
                                  <span  class="form-control" id="subArea" name="subArea">{{App\SubArea::where('id', $trabalho->sub_area_id)->first()->nome}}</span>
                              </div>
                          </div>

                          <hr>

                          <h3>Coordenador</h3>
                          {{-- Coordenador  --}}
                          <div class="row justify-content-center">

                              <div class="col-sm-6">
                                  <label for="nomeCoordenador" class="col-form-label">{{ __('Coordenador:') }}</label>
                                  <span class="form-control" id="nomeCoordenador" name="nomeCoordenador" disabled>{{ App\Proponente::find($trabalho->proponente_id)->user->name }}</span>
                              </div>
                              <div class="col-sm-6">
                                  <label for="nomeCoordenador" class="col-form-label">{{ __('E-mail do Coordenador:') }}</label>
                                  <span class="form-control" id="nomeCoordenador" name="nomeCoordenador" disabled>{{ App\Proponente::find($trabalho->proponente_id)->user->email }}</span>
                              </div>

                              <div class="col-sm-6">
                                  <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                                  <span class="form-control" name="linkLattesEstudante">
                                  @if(App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes != null)
                                      {{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}
                                  @endif
                                  </span>
                              </div>

                              <div class="col-sm-6">
                                  <label for="nomeTrabalho" class="col-form-label">{{ __('Pontuação da Planilha de Pontuação :') }}</label>
                                  <span class="form-control" name="pontuacaoPlanilha">{{$trabalho->pontuacaoPlanilha}}</span>
                              </div>

                              <div class="col-sm-12">
                                  <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                                  <span  class="form-control" name="linkGrupo">{{ $trabalho->linkGrupoPesquisa }}</span>
                              </div>

                          </div>

                          <hr>
                          <h3>Anexos</h3>

                          {{-- Anexo do Projeto --}}
                          <div class="row justify-content-center">
                              {{-- Arquivo  --}}
                              <div class="col-sm-6">
                                  <label for="anexoProjeto" class="col-form-label">{{ __('Anexo Projeto: ') }}</label>
                                  <a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}">Arquivo atual</a>
                              </div>

                              <div class="col-sm-6">
                                  <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Anexo do Lattes do Coordenador: ') }}</label>
                                  <a href="{{ route('baixar.anexo.lattes', ['id' => $trabalho->id]) }}"> Arquivo atual</a>
                              </div>

                              <div class="col-sm-6">
                                  <label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>
                                  @if($trabalho->anexoAutorizacaoComiteEtica != null)
                                      <a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> Arquivo atual</a>
                                  @else
                                      -
                                  @endif
                              </div>

                              <div class="col-sm-6">
                                  <label for="anexoPlanilha" class="col-form-label">{{ __('Anexo do Planilha de Pontuação: ') }}</label>
                                  <a href="{{ route('baixar.anexo.planilha', ['id' => $trabalho->id]) }}"> Arquivo atual</a>
                              </div>

                              <div class="col-sm-6">
                                  <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>
                                  @if($trabalho->justificativaAutorizacaoEtica != null)
                                      <a href="{{ route('baixar.anexo.justificativa', ['id' => $trabalho->id]) }}"> Arquivo atual</a>
                                  @else
                                      -
                                  @endif
                              </div>

                              @if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM')
                              {{-- Decisão do CONSU --}}
                              <div class="col-sm-6">
                                  <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label>
                                  <a href="{{ route('baixar.anexo.consu', ['id' => $trabalho->id]) }}"> Arquivo atual</a>
                              </div>
                              @endif

                          </div>

                          <hr>
                          <h4>Discentes</h4>

                          {{-- Participantes  --}}
                          <div class="row" style="margin-top:20px">
                              <div class="col-sm-12">
                                  <div id="participantes">
                                      @foreach($trabalho->participantes as $participante)
                                          {{-- @foreach($users as $user) --}}
                                              {{-- @if($participante->user_id === $user->id) --}}
                                              <div id="novoParticipante">
                                                  <br>
                                                  <h5>Dados do discente</h5>
                                                  <div class="row">
                                                      <div class="col-sm-5">
                                                          <label>Nome Completo</label>
                                                          <span style="margin-bottom:10px" class="form-control" name="nomeParticipante[]">{{ $participante->user->name }}</span>
                                                      </div>

                                                      <div class="col-sm-4">
                                                          <label>E-mail</label>
                                                          <span style="margin-bottom:10px" class="form-control" name="emailParticipante[]">{{ $participante->user->email }}</span>
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
                                                  @php
                                                    $arquivos = App\Arquivo::where('trabalhoId', $trabalho->id)->get();
                                                  @endphp
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
                                              {{-- @endif --}}
                                          {{-- @endforeach --}}
                                      @endforeach
                                  </div>
                              </div>
                          </div>
                        <hr>
                        <h4>Avaliadores</h4>
                        <table class="table table-bordered" style="margin-top:20px">
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Status avaliação</th>
                                <th scope="col" style="text-align:center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($trabalho->avaliadors as $avaliador)
                                <tr>
                                    <td>{{$avaliador->user->name}}</td>
                                    <td>{{$avaliador->user->email}}</td>
                                    <td>@if($avaliador->pivot->parecer == null) Pendente @else Avaliado @endif</td>
                                    <td> 
                                        <div class="btn-group dropright dropdown-options">
                                            <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                                            </a>
                                            <div class="dropdown-menu">
                                            @if($avaliador->pivot->parecer != null)
                                                <a href="{{ route('admin.visualizarParecer', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" class="dropdown-item text-center">
                                                    Vizualizar Parecer
                                                </a>
                                            @else
                                                <a href="{{ route('admin.removerProjAval', ['trabalho_id' => $trabalho->id, 'avaliador_id' => $avaliador->id]) }}" class="dropdown-item text-center">
                                                    Desatribuir Avaliador
                                                </a>
                                            @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </p>
                  </div>
              {{-- </div> --}}
            </div>
          </div>
        </div>
        @endforeach
      </div>
</div>

@endsection

@section('javascript')
<script>

</script>
@endsection
