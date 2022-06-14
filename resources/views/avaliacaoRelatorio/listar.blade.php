@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <!--Proponente Dados-->
        <div class="col-md-10" style="margin-top:4rem;padding: 0px">
            @component('projeto.formularioVisualizar.proponente2', ['projeto' => $trabalho, 'edital' => $trabalho->evento])
            @endcomponent
        </div>

        <!--Anexos do Projeto-->
        <div class="col-md-10" style="margin-top:20px">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        {{-- Anexo do Projeto --}}
                        <div class="row justify-content-left">
                            {{-- Arquivo  --}}
                            <div class="col-sm-12">
                                <label for="anexoProjeto" class="col-form-label font-tam"
                                       style="font-weight: bold">{{ __('Projeto: ') }}</label>
                                <a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><img class=""
                                                                                                           src="{{asset('img/icons/pdf.ico')}}"
                                                                                                           style="width:40px"
                                                                                                           alt=""></a>

                            </div>
                            <br>
                            {{-- Autorização Especial --}}
                            <div class="col-sm-12">
                                <label for="nomeTrabalho" class="col-form-label font-tam"
                                       style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
                                @if($trabalho->anexoAutorizacaoComiteEtica != null)
                                    <a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> <img class=""
                                                                                                                src="{{asset('img/icons/pdf.ico')}}"
                                                                                                                style="width:40px"
                                                                                                                alt=""></a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Planos</h5></div>
                        </div>
                        <hr style="border-top: 1px solid#1492E6">

                        {{-- Anexo(s) do Plano(s) de Trabalho  --}}
                        @foreach( $trabalho->participantes as $participante)

                            @php
                                $planoTrabalhoTemp = App\Arquivo::where('participanteId', $participante->id)->first();
                                $relatorio= \App\AvaliacaoRelatorio::where('user_id',auth()->user()->id)->where('arquivo_id',$planoTrabalhoTemp->id)->where('tipo',$tipoRelatorio)->first();
                            @endphp
                            @if(isset($relatorio))
                                <div class="row" style="margin-left: 5px">
                                    <label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold"
                                           title="{{$participante->planoTrabalho->titulo}}">{{ __('Plano: ') }}{{$participante->planoTrabalho->titulo}}</label>

                                    @if($planoTrabalhoTemp != null)
                                        <a href="{{route('download', ['file' => $planoTrabalhoTemp])}}"><img
                                                    src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
                                    @endif
                                    @if($tipoRelatorio == "Parcial")
                                        <div style="margin-left: 25px">
                                            <label for="anexoProjeto" class="col-form-label font-tam"
                                                   style="font-weight: bold"
                                            >{{ __('Relatório Parcial: ') }}</label>
                                            @if($participante->planoTrabalho->relatorioParcial)

                                                <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->planoTrabalho->relatorioParcial]) }}"><i
                                                            class="fas fa-file-pdf fa-2x"></i></a>

                                            @else
                                                <a><i class="fas fa-times-circle fa-2x"></i></a>
                                            @endif
                                        </div>
                                        <div class="col-sm-12">
                                            <form id="formRelatFinal" method="post"
                                                  action="{{route('planos.avaliacoesUser.criar')}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="tipo" value="Parcial">
                                                <input type="hidden" name="trabalho_id" value="{{$trabalho->id}}">
                                                <input type="hidden" name="avaliacao_id" value="{{$relatorio->id}}">
                                                <input type="hidden" name="plano_id"
                                                       value="{{$participante->planoTrabalho->id}}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                                                <div class="col-12" style="padding-left: 0px">

                                                    <div class="row">
                                                        @php
                                                            $relatParcial = App\AvaliacaoRelatorio::where('user_id',Auth::user()->id)->where('tipo','Parcial')->where('arquivo_id',$participante->planoTrabalho->id)->first();
                                                        @endphp
                                                        <div class="col-sm-6 row">
                                                            <label for="lattes" class="col-form-label font-tam"
                                                                   style="font-weight: bold;padding-right: 10px">{{ __('Nota: ') }}</label>

                                                            <input class="form-control" name="nota" type="number"
                                                                   style="width: 60px;"
                                                                   @if(isset($relatParcial)) value="{{$relatParcial->nota}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 10px">
                                                        <label for="lattes" class="col-form-label font-tam"
                                                               style="font-weight: bold;margin-right: 5px;">{{ __('Formulário de Avaliação: ') }}</label>

                                                        @if($evento->formAvaliacaoRelatorio != null)
                                                            <a href="{{route('download', ['file' => $evento->formAvaliacaoRelatorio])}}" target="_new"  >
                                                                <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px">
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="row" style="margin-top: 10px">
                                                        <label for="lattes" class="col-form-label font-tam"
                                                               style="font-weight: bold;margin-right: 5px;">{{ __('Arquivo: ') }}</label>
                                                        @if(isset($relatParcial))
                                                            @if($relatParcial->arquivoAvaliacao != null)
                                                                <a href="{{route('download', ['file' => $relatParcial->arquivoAvaliacao])}}" target="_new"  >
                                                                    <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px">
                                                                </a>
                                                            @endif
                                                        @endif
                                                        <input type="file" class="input-group-text" value="" name="arquivo" accept=".pdf" id="arquivo" required/>

                                                        @error('arquivo')
                                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <label for="lattes" class="col-form-label font-tam"
                                                               style="font-weight: bold">{{ __('Comentário: ') }}</label>
                                                    </div>
                                                    <div class="row">
										<textarea class="col-md-11" minlength="20" id="comentario"
                                                  name="comentario"
                                                  style="border-radius:5px 5px 0 0;height: 71px;"
                                                  required>@if(isset($relatParcial)){{$relatParcial->comentario}}</textarea>@else</textarea>@endif

                                                        <div class="col-md-1" style="flex: 1;align-self: flex-end;">
                                                            <button type="submit" id="id{{$participante->user->id}}"
                                                                    name="id{{$participante->user->id}}"
                                                                    class="btn btn-success"
                                                                    style="height: 40px">Salvar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </form>
                                        </div>



                                    @else
                                        <div style="margin-left: 25px">
                                            <label for="anexoProjeto" class="col-form-label font-tam"
                                                   style="font-weight: bold"
                                            >{{ __('Relatório Final: ') }}</label>
                                            @if($participante->planoTrabalho->relatorioFinal)
                                                <a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->planoTrabalho->relatorioFinal]) }}"><i
                                                            class="fas fa-file-pdf fa-2x"></i></a>
                                            @else
                                                <a><i class="fas fa-times-circle fa-2x"></i></a>
                                            @endif
                                        </div>
                                        <div class="col-sm-12">
                                            <form id="formRelatFinal" method="post"
                                                  action="{{route('planos.avaliacoesUser.criar')}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="tipo" value="Final">
                                                <input type="hidden" name="trabalho_id" value="{{$trabalho->id}}">
                                                <input type="hidden" name="avaliacao_id" value="{{$relatorio->id}}">
                                                <input type="hidden" name="plano_id"
                                                       value="{{$participante->planoTrabalho->id}}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                                                <div class="col-12" style="padding-left: 0px">

                                                    <div class="row">
                                                        @php
                                                            $relatFinal = App\AvaliacaoRelatorio::where('user_id',Auth::user()->id)->where('tipo','Final')->where('arquivo_id',$participante->planoTrabalho->id)->first();
                                                        @endphp
                                                        <div class="col-sm-6 row">
                                                            <label for="lattes" class="col-form-label font-tam"
                                                                   style="font-weight: bold;padding-right: 10px">{{ __('Nota: ') }}</label>

                                                            <input class="form-control" name="nota" type="number"
                                                                   style="width: 60px;"
                                                                   @if(isset($relatFinal)) value="{{$relatFinal->nota}}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top: 10px">
                                                        <label for="lattes" class="col-form-label font-tam"
                                                               style="font-weight: bold;margin-right: 5px;">{{ __('Arquivo: ') }}</label>
                                                        @if(isset($relatFinal))
                                                            @if($relatFinal->arquivoAvaliacao != null)
                                                                <a href="{{route('download', ['file' => $relatFinal->arquivoAvaliacao])}}" target="_new"  >
                                                                    <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px">
                                                                </a>
                                                            @endif
                                                        @endif
                                                        <input type="file" class="input-group-text" value="" name="avaliacaoArq" accept=".pdf" id="avaliacaoArq" required/>
                                                        @error('avaliacaoArq')
                                                        <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <label for="lattes" class="col-form-label font-tam"
                                                               style="font-weight: bold">{{ __('Comentário: ') }}</label>
                                                    </div>
                                                    <div class="row">
										<textarea class="col-md-11" minlength="20" id="comentario"
                                                  name="comentario"
                                                  style="border-radius:5px 5px 0 0;height: 71px;"
                                                  required>@if(isset($relatFinal)){{$relatFinal->comentario}}</textarea>@else</textarea>@endif

                                                        <div class="col-md-1" style="flex: 1;align-self: flex-end;">
                                                            <button type="submit" id="id{{$participante->user->id}}"
                                                                    name="id{{$participante->user->id}}"
                                                                    class="btn btn-success"
                                                                    style="height: 40px">Salvar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="row" style="margin-left: 0px">
                            </div>
                        @endforeach
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

<style>
    label {
        font-weight: bold;
    }
</style>
