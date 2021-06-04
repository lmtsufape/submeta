@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>{{$evento->nome}}</h1>
    </div>

    <form action="{{route('evento.update',$evento->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Tipo--}}
        <div class="row justify-content-center">
            <div class="col-sm-6">{{--Nome do evento--}}
                <label for="nome" class="col-form-label">{{ __('Nome*:') }}</label>
                <input value="{{$evento->nome}}" id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{--End Nome do evento--}}
          
            {{-- Tipo do evento --}}
            <div class="col-sm-2">
                <label for="tipo" class="col-form-label">{{ __('Tipo*:') }}</label>
                <!-- <input value="{{$evento->tipo}}" id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required autocomplete="tipo" autofocus> -->
                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" required>
                    <option value="PIBIC" {{ $evento->tipo == "PIBIC" ? 'selected' :'' }}>PIBIC</option>
                    <option value="PIBIC-EM" {{ $evento->tipo == "PIBIC-EM" ?  'selected' :'' }}>PIBIC-EM</option>
                    <option value="PIBITI" {{ $evento->tipo == "PIBITI" ?  'selected' :'' }}>PIBITI</option>
                </select>
                @error('tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{-- Tipo do evento --}}

            <div class="col-sm-2">
                <label for="natureza" class="col-form-label">{{ __('Natureza*:') }}</label>
                <select id="natureza" type="text" class="form-control @error('natureza') is-invalid @enderror" name="natureza" value="{{ old('natureza') }}" required>
                  @foreach ($naturezas as $natureza)
                    @if ($natureza->id === $evento->natureza_id)
                        <option value="{{ $natureza->id }}" selected>{{ $natureza->nome }}</option>
                    @else
                        <option value="{{ $natureza->id }}">{{ $natureza->nome }}</option>
                    @endif
                  @endforeach              
                </select>

                @error('natureza')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-2">
                <label for="numParticipantes" class="col-form-label">{{ __('Nº de Discentes*:') }}</label>
                <input id="numParticipantes" type="number" min="1" max="20" class="form-control @error('numParticipantes') is-invalid @enderror" name="numParticipantes" value="{{ $evento->numParticipantes }}" required autocomplete="numParticipantes" autofocus>

                @error('numParticipantes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end nome | Participantes | Tipo--}}

        {{-- Descricao Evento --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição*:</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" value="{{ $evento->descricao }}" id="descricao" name="descricao" rows="3">{{$evento->descricao}}</textarea>
                    @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <label for="coordenador_id" class="col-form-label">{{ __('Coordenador*:') }}</label>
                <select class="form-control @error('funcaoParticipante') is-invalid @enderror" id="coordenador_id" name="coordenador_id">
                    <option value="" disabled selected hidden>-- Coordenador da Comissão Avaliadora --</option>
                    @foreach($coordenadores as $coordenador)
                        @if ($coordenador->id === $evento->coordenadorId)
                            <option value="{{$coordenador->id}}" selected>{{$coordenador->user->name}}</option>
                        @else
                            <option value="{{$coordenador->id}}">{{$coordenador->user->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Projetos</p>
            </div>
        </div>
        {{-- dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">

            {{-- Início da Submissão --}}
            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão*:') }}</label>
                <input value="{{$evento->inicioSubmissao}}" id="inicioSubmissao" type="date" class="form-control @error('inicioSubmissao') is-invalid @enderror" name="inicioSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
                </span>
                @enderror
            </div>{{-- end Início da Submissão --}}
            {{-- Fim da submissão --}}
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão*:') }}</label>
                <input value="{{$evento->fimSubmissao}}" id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message . date('d/m/Y', strtotime(old('inicioSubmissao'))) . '.' }}</strong>
                </span>
                @enderror
            </div>{{-- end Fim da submissão --}}
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="inicioRevisao" class="col-form-label">{{ __('Início da Avaliação*:') }}</label>
              <input value="{{$evento->inicioRevisao}}" id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

              @error('inicioRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fimRevisao" class="col-form-label">{{ __('Fim da Avaliação*:') }}</label>
              <input value="{{$evento->fimRevisao}}" id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

              @error('fimRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime( old('inicioRevisao') )) . '.' }}</strong>
              </span>
              @enderror
          </div>
        </div>
        
        {{-- inicioRevisao | fimRevisao | inicioResultado | fimResultado--}}
        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="resultado_preliminar" class="col-form-label">{{ __('Resultado Preliminar*:') }}</label>
              <input id="resultado_preliminar" value="{{$evento->resultado_preliminar}}" type="date" class="form-control @error('resultado_preliminar') is-invalid @enderror" name="resultado_preliminar" value="{{ old('resultado_preliminar') }}" required autocomplete="resultado_preliminar" autofocus>

              @error('resultado_preliminar')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="inicio_recurso" class="col-form-label">{{ __('Início do recurso*:') }}</label>
              <input id="inicio_recurso" type="date" value="{{ $evento->inicio_recurso }}" class="form-control @error('inicio_recurso') is-invalid @enderror" name="inicio_recurso" value="{{ old('inicio_recurso') }}" required autocomplete="inicio_recurso" autofocus>

              @error('inicio_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
              </span>
              @enderror
          </div>
          
        </div>
        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="fim_recurso" class="col-form-label">{{ __('Fim do Recurso*:') }}</label>
              <input id="fim_recurso" type="date" value="{{ $evento->fim_recurso }}" class="form-control @error('fim_recurso') is-invalid @enderror" name="fim_recurso" value="{{ old('fim_recurso') }}" required autocomplete="resultado" autofocus>

              @error('fim_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
              </span>
              @enderror
          </div>
          
          <div class="col-sm-6">
              <label for="resultado_final" class="col-form-label">{{ __('Resultado Final*:') }}</label>
              <input id="resultado_final" type="date" value="{{ $evento->resultado_final }}" class="form-control @error('resultado_final') is-invalid @enderror" name="resultado_final" value="{{ old('resultado_final') }}" required autocomplete="resultado" autofocus>

              @error('resultado_final')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message . date('d/m/Y', strtotime($ontem ?? '')) . '.' }}</strong>
              </span>
              @enderror
          </div>
        </div>
        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Documentos</p>
            </div>
        </div>
        
        {{-- Pdf Edital --}}
        <div class="row justify-content-center" style="margin-top:10px">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfEdital">PDF do Edital*:</label>
                    <a href="{{route('download', ['file' => $evento->pdfEdital])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                        <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                    </a>
                    <input type="file" class="form-control-file @error('pdfEdital') is-invalid @enderror" name="pdfEdital" value="{{ old('pdfEdital') }}" id="pdfEdital">
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('pdfEdital')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
       
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="modeloDocumento">Arquivo com os modelos de documentos do edital:</label>
                    <a href="{{route('download', ['file' => $evento->modeloDocumento])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                        <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                    </a>
                    <input type="file" class="form-control-file @error('modeloDocumento') is-invalid @enderror" name="modeloDocumento" value="{{ old('modeloDocumento') }}" id="modeloDocumento">
                    <small>O arquivo selecionado deve ter até 2mb.</small>
                    @error('modeloDocumento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
        </div>
       

        <div class="row justify-content-center" style="margin: 20px 0 20px 0">

            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="{{ route('admin.editais') }}" style="width:100%">Cancelar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
