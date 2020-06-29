@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>Novo Edital</h1>
    </div>

    <form action="{{route('evento.criar')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Participantes | Tipo--}}
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <label for="nome" class="col-form-label">{{ __('Nome*:') }}</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
         
            <div class="col-sm-3">
                <label for="tipo" class="col-form-label">{{ __('Tipo*:') }}</label>
                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required>
                  <option @if(old('tipo')=='PIBIC' ) selected @endif value="PIBIC">PIBIC</option>
                  <option @if(old('tipo')=='PIBIC-EM' ) selected @endif value="PIBIC-EM">PIBIC-EM</option>
                  <option @if(old('tipo')=='PIBITI' ) selected @endif value="PIBITI">PIBITI</option>                  
                </select>

                @error('tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-3">
                <label for="natureza" class="col-form-label">{{ __('Natureza*:') }}</label>
                <select id="natureza" type="text" class="form-control @error('natureza') is-invalid @enderror" name="natureza" value="{{ old('natureza') }}" required>
                  @foreach ($naturezas as $natureza)
                    <option @if(old('natureza')==$natureza->id ) selected @endif value="{{ $natureza->id }}">{{ $natureza->nome }}</option>  
                  @endforeach              
                </select>

                @error('natureza')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end nome | Participantes | Tipo--}}

        {{-- Descricao Edital --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição*:</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" required autocomplete="descricao" autofocus id="descricao" name="descricao" rows="3">{{ old('descricao') }}</textarea>
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
              <select class="form-control @error('coordenador_id') is-invalid @enderror" id="coordenador_id" name="coordenador_id">
                  <option value="" disabled selected hidden>-- Coordenador da Comissão Avaliadora --</option>
                  @foreach($coordenadors as $coordenador)
                    <option @if(old('coordenador_id')==$coordenador->id ) selected @endif value="{{$coordenador->id}}">{{$coordenador->user->name}}</option>
                  @endforeach
              </select>
              @error('coordenador_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
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

            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão*:') }}</label>
                <input id="inicioSubmissao" type="date" class="form-control @error('inicioDaSubmissao') is-invalid @enderror" name="inicioDaSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioDaSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>
                        @if ($message != null)
                            @for ($i = 0; $i < 9; $i++) 
                                @if ($i < 8)
                                    {{ explode(" ", $message)[$i] }}
                                @else 
                                    {{ date('d/m/Y', strtotime(explode(" ", $message)[$i])) }}
                                @endif
                            @endfor
                        @endif
                    </strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão*:') }}</label>
                <input id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}

        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="inicioRevisao" class="col-form-label">{{ __('Início da Avaliação*:') }}</label>
              <input id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

              @error('inicioRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fimRevisao" class="col-form-label">{{ __('Fim da Avaliação*:') }}</label>
              <input id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

              @error('fimRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>

        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="inicio_recurso" class="col-form-label">{{ __('Início do recurso*:') }}</label>
              <input id="inicio_recurso" type="date" class="form-control @error('inicio_recurso') is-invalid @enderror" name="inicio_recurso" value="{{ old('inicio_recurso') }}" required autocomplete="inicio_recurso" autofocus>

              @error('inicio_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fim_recurso" class="col-form-label">{{ __('Fim do recurso*:') }}</label>
              <input id="fim_recurso" type="date" class="form-control @error('fim_recurso') is-invalid @enderror" name="fim_recurso" value="{{ old('fim_recurso') }}" required autocomplete="resultado" autofocus>

              @error('fim_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>
        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="resultado_preliminar" class="col-form-label">{{ __('Data do Resultado preliminar*:') }}</label>
              <input id="resultado_preliminar" type="date" class="form-control @error('resultado_preliminar') is-invalid @enderror" name="resultado_preliminar" value="{{ old('resultado_preliminar') }}" required autocomplete="resultado_preliminar" autofocus>

              @error('resultado_preliminar')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="resultado_final" class="col-form-label">{{ __('Data do Resultado final*:') }}</label>
              <input id="resultado_final" type="date" class="form-control @error('resultado_final') is-invalid @enderror" name="resultado_final" value="{{ old('resultado_final') }}" required autocomplete="resultado" autofocus>

              @error('resultado_final')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
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
                    <label for="pdfEdital">Anexar edital*:</label>    
                    @if(old('pdfEditalPreenchido') != null)
                        <a id="pdfEditalTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'pdfEdital' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="pdfEditalPreenchido" name="pdfEditalPreenchido" value="{{ old('pdfEditalPreenchido') }}" >               
                    <input type="file" class="form-control-file @error('pdfEdital') is-invalid @enderror" name="pdfEdital" value="{{ old('pdfEdital') }}" id="pdfEdital" onchange="exibirAnexoTemp(this)">
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
                    <label for="modeloDocumento">Anexar arquivo com os modelos de documentos do edital:</label>
                    @if(old('modeloDocumentoPreenchido') != null)
                    <a id="modeloDocumentoTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'modeloDocumento' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="modeloDocumentoPreenchido" name="modeloDocumentoPreenchido" value="{{ old('modeloDocumentoPreenchido') }}" >
                    <input type="file" class="form-control-file @error('modeloDocumento') is-invalid @enderror" name="modeloDocumento" value="{{ old('modeloDocumento') }}" id="modeloDocumento" onchange="exibirAnexoTemp(this)">
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
                    {{ __('Criar Edital') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    function exibirAnexoTemp(file){
        console.log(file.id);
        if(file.id === "pdfEdital"){
        var pdfEditalPreenchido = document.getElementById('pdfEditalPreenchido');
        pdfEditalPreenchido.value = "sim";
        }
        if(file.id === "modeloDocumento"){
        var modeloDocumentoPreenchido = document.getElementById('modeloDocumentoPreenchido');
        modeloDocumentoPreenchido.value = "sim";
        }
    }
</script>
@endsection