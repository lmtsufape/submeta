@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                <a href="{{url()->previous()}}" class="btn btn-primary mb-2"> Voltar</a>
                  <h5 class="card-title">Parecer do avaliador: {{ $avaliador->user->name }}</h5>
                  <h6 class="card-title">Trabalho: {{ $trabalho->titulo }}</h6>
                  <p class="card-text">
                    <h3>Informações do proponente</h3>
                    {{-- Coordenador  --}}
                    <div class="row">

                        <div class="col-sm-6">
                            <label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente</label>
                            <span class="form-control" name="linkLattesEstudante">
                                  @if(App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes != null)
                                    {{ App\Proponente::where('id', $trabalho->proponente_id)->first()->linkLattes }}
                                @endif
						</span>
                        </div>
                        <div class="col-sm-6" style="top: 40px;">
                            <label for="aceito">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoLinkLattes" value="aceito" @if($parecer!=null && $parecer->statusLinkLattesProponente =='aceito') checked @else disabled @endif required>

                            <label for="recusado" >{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoLinkLattes" value="recusado" @if($parecer!=null && $parecer->statusLinkLattesProponente =='recusado') checked @else disabled @endif>
                        </div>

                        <div class="col-sm-6" >
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa:') }}</label>
                            <span  class="form-control" name="linkGrupo">{{ $trabalho->linkGrupoPesquisa }}</span>
                        </div>
                        <div class="col-sm-6" style="top: 40px;">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoGrupoPesquisa" value="aceito" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='aceito' ) checked @else disabled @endif required>

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoGrupoPesquisa" value="recusado" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='recusado' ) checked @else disabled @endif>
                        </div>

                    </div>

                    <h3>Anexos</h3>

                    {{-- Anexo do Projeto --}}
                    <div class="row">
                        {{-- Arquivo  --}}
                        <div class="col-sm-3">
                            <label for="anexoProjeto" class="col-form-label">{{ __('Projeto: ') }}</label>
                            <a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}">Arquivo</a>


                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoProjeto" value="aceito" @if($parecer!=null && $parecer->statusAnexoProjeto =='aceito' ) checked @else disabled @endif required>

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoProjeto" value="recusado" @if($parecer!=null && $parecer->statusAnexoProjeto =='recusado' ) checked @else disabled @endif>
                        </div>

                        <div class="col-sm-3">
                            <label for="anexoLatterCoordenador" class="col-form-label">{{ __('Lattes do Coordenador: ') }}</label>
                            <a href="{{ route('baixar.anexo.lattes', ['id' => $trabalho->id]) }}">Arquivo</a>
                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoLattesCoordenador" value="aceito" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='aceito' ) checked @else disabled @endif required>

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoLattesCoordenador" value="recusado" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='recusado' ) checked @else disabled @endif>
                        </div>

                        <div class="col-sm-3">
                            <label for="anexoPlanilha" class="col-form-label">{{ __('Pontuação calculada: ') }}</label>
                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <input type="number" min="0" step=".01" name="anexoPlanilha"
                                   @if($parecer!=null && $parecer->statusAnexoPlanilhaPontuacao !=null)
                                   @if(is_numeric($parecer->statusAnexoPlanilhaPontuacao)) value="{{$parecer->statusAnexoPlanilhaPontuacao}}"
                                   @else value="0"
                                   @endif @endif disabled>
                        </div>

                        @if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM')
                            {{-- Decisão do CONSU --}}
                            <div class="col-sm-3">
                                <label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label>
                                <a href="{{ route('baixar.anexo.consu', ['id' => $trabalho->id]) }}">Arquivo</a>
                            </div>
                            <div class="col-sm-3" style="top: 5px; text-align: right">
                                <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                                <input type="radio" name="anexoConsu" value="aceito" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='aceito' ) checked @else disabled @endif required>

                                <label for="recusado">{{ __('Recusado') }}</label>
                                <input type="radio" name="anexoConsu" value="recusado" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='recusado' ) checked @else disabled @endif>
                            </div>
                        @endif

                        <div class="col-sm-3">
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>
                            @if($trabalho->anexoAutorizacaoComiteEtica != null)
                                <a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}">Arquivo</a>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoComiteEtica" value="aceito" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='aceito' ) checked @else disabled  @endif required>

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoComiteEtica" value="recusado" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='recusado' ) checked @else disabled  @endif>
                        </div>

                        <div class="col-sm-3">
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>
                            @if($trabalho->justificativaAutorizacaoEtica != null)
                                <a href="{{ route('baixar.anexo.justificativa', ['id' => $trabalho->id]) }}">Arquivo</a>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoJustificativa" value="aceito" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='aceito' ) checked @else disabled  @endif required>

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoJustificativa" value="recusado" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='recusado' ) checked @else disabled  @endif>
                        </div>

                        {{--Planos de trabalho--}}
                        <div class="col-sm-3">
                            <label for="nomeTrabalho" class="col-form-label">{{ __('Plano de Trabalho: ') }}</label>
                            @if ($trabalho->participantes != null)
                                <a href=" " data-toggle="modal" data-target="#modalPlanos">Planos</a>
                            @else
                                -
                            @endif
                        </div>
                        <div class="col-sm-3" style="top: 5px; text-align: right">
                            <label for="aceito" style="left: auto">{{ __('Aceito') }}</label>
                            <input type="radio" name="anexoPlano" value="aceito"  @if($parecer!=null && $parecer->statusPlanoTrabalho =='aceito' ) checked  @else disabled @endif >

                            <label for="recusado">{{ __('Recusado') }}</label>
                            <input type="radio" name="anexoPlano" value="recusado" @if($parecer!=null && $parecer->statusPlanoTrabalho =='recusado' ) checked @else disabled @endif>
                        </div>

                        {{--Modal planos de trabalho--}}
                        <div class="modal fade" id="modalPlanos" tabindex="-1" role="dialog"
                             aria-labelledby="modalPlanosLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalPlanosLabel" align="center">
                                            Planos de Trabalho</h4>
                                    </div>
                                    <div class="modal-body">
                                        @foreach( $trabalho->participantes as $participante)
                                            @php
                                                if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                                                  $planoTrabalho = App\Arquivo::where('participanteId', $participante->id)->first();
                                                }else{
                                                  $planoTrabalho = null;
                                                }
                                            @endphp
                                            <div class="col-sm-12">
                                                <label for="nomeTrabalho" class="col-form-label">{{ __('Plano de Trabalho: ') }}</label>
                                                @if ($planoTrabalho != null)
                                                    <a href="{{route('download', ['file' => $planoTrabalho->nome])}}">{{$planoTrabalho->titulo}}</a>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                            Fechar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
              </div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
<script type="text/javascript">


</script>
@endsection
